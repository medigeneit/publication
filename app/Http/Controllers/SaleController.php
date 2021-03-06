<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleProductResource;
use App\Http\Resources\SaleResource;
use App\Models\AddressesOf;
use App\Models\Area;
use App\Models\Customer;
use App\Models\District;
use App\Models\Division;
use App\Models\GenesisCustomerInfo;
use App\Models\Outlet;
use App\Models\Payment;
use App\Models\PriceCategory;
use App\Models\Pricing;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Storage;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::query()
            ->with('customer', 'outlet', 'payments', 'user')
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        SaleResource::withoutWrapping();

        // return  SaleResource::collection($sales->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input()));
        // return $sales->get();

        return Inertia::render('Sale/Index', [
            'sales' => SaleResource::collection($sales->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $productList = [];

        // return
        $products = Product::query()
            ->with(['categories',  'prices.price_categroy', 'storages.outlet', 'productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with([
                            'version.production.publisher:id,name',
                            'version.volumes:id,version_id',
                            'version.moderators:id,author_id,moderator_type,version_id',
                            'version.moderators.moderators_type:id,name',
                            'version.moderators.author:id,name'
                        ]);
                    },
                    Version::class => function ($query) {
                        $query->with([
                            'moderators:id,author_id,moderator_type,version_id',
                            'moderators.moderators_type:id,name',
                            'moderators.author:id,name',
                            'volumes',
                            'production.publisher:id,name'
                        ]);
                    },
                ]);
            }])
            // ->where('active', 1)
            // ->when(isset(request()->search), function ($query) {
            //     $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
            //         ->orWhere('id', request()->search)
            //         ->orWhereIn('id', explode(',', request()->selected));
            // })
            ->search(request()->search)
            // ->orderBy('name')
            ->get();


        $price_category = PriceCategory::get();

        foreach ($products as $product) {

            $property = (object)[
                'name'          => (string) ($product->product_name ?? ''),
                'maxQuantity'   => (int) rand(10, 20),
                'unitPrice'     => (object) $product->prices->pluck('amount', 'price_category_id'),

            ];

            $productList[$product->id] = $property;
        }
        // return Division::with('districts.areas')->get();
        return Inertia::render('Sale/SaleMemo', [
            'sale' => new Sale(),
            'outlets' => Outlet::active()->pluck('name', 'id'),
            'price_types' => $price_category,
            'products' => $productList,
            'search' => request()->search,
            'areas' => Area::get(),
            'divisions' => Division::with('districts.areas')->get(),
            'districts' => District::pluck('name', 'id'),
            'search' => request()->search,
        ]);
    }

    public function store(Request $request)
    {
        // return $request->customer_phone;
        // return Http::get('https://api.genesisedu.info/publication/doctor-course-info?reg_no=22107001');
        // return $request;

        if ($request->paid && $request->sale_id) {
            $payment = Payment::create([
                'sale_id' => $request->sale_id,
                'amount' => $request->paid,
                'status' => 1,
                'payment_type' => 1,
                'due_condition' => $request->due_condition,
            ]);
            return redirect()
                ->route('sales.show', $request->sale_id)
                ->with('status', 'The record has been added successfully.');
        }
        $customer = Customer::updateOrCreate(
            [
                'phone'     => $request->customer_phone,
            ],
            [
                'name'      => $request->customer_name,
                'email'     => $request->email,
                'user_id'   => Auth::user()->id
            ]
        );

        if ($request->customer_address) {
            $adress = AddressesOf::updateOrCreate(
                [
                    'customer_id'     => $customer->id,
                ],
                [
                    'area_id'      => $request->area_id,
                    'address'     => $request->customer_address,
                ]
            );
        }

        // return 22107785
        $registerd = GenesisCustomerInfo::where('reg_no', $request->reg)->first();
        if ($registerd) {
            return redirect()
                ->route('sales.show', $request->sale_id)
                ->with('status', 'The record is already existed.');
        }


        if ($customer && $request->outlet_id && $request->subtotal) {
            $sale = Sale::create(
                [
                    'outlet_id' => $request->outlet_id,
                    'customer_id' => $customer->id,
                    'discount' => $request->discount ?? 0,
                    'discount_purpose' => $request->discount_purpose ?? null,
                    'payable' => ($request->subtotal - ($request->discount ?? 0)) ?? 0,
                    'user_id' => Auth::user()->id,
                    'address_id' => $adress->id ?? null,
                    'memo_type' => $request->memo_type,
                ]
            );

            if ($sale) {

                if ($request->memo_type == 3 && $request->reg && !$registerd) {
                    GenesisCustomerInfo::create([
                        'reg_no' => $request->reg,
                        'sale_id' => $sale->id,
                        'customer_id' => $customer->id,
                        'course_name' => $request->course,
                        'batch_id' => $request->batch_id ?? null,
                        'batch_name' => $request->batch,
                    ]);
                }

                $just_products = [];
                $sold_products = [];
                $sold_single_product = [];
                $storage_products_update = ' CASE product_id ';

                foreach ($request->products as $product) {
                    // return $product['quantity'];
                    $sold_single_product = [
                        'product_id' => $product['productId'],
                        'sale_id' => $sale->id,
                        'quantity' => $product['quantity'],
                        'price_type' => $product['selected_price_type'],
                        'unit_price' => $product['selected_unit_price'],
                    ];
                    $sold_products[] = $sold_single_product;
                    $just_products[] = (int)$product['productId'];
                    $storage_products_update .= ' when ' . $product['productId'] . ' then quantity - ' . $product['quantity'];


                    // Storage::Update
                }

                $storage_products_update .= " ELSE quantity END";
                // return $just_products;

                $storage_update = Storage::where('outlet_id', $request->outlet_id)
                    ->whereIn('product_id', $just_products);

                $storage_update->update([
                    'quantity' => DB::raw($storage_products_update)
                ]);

                // return $demo ->get();

                if ($request->paid) {
                    $payment = Payment::create([
                        'sale_id' => $sale->id,
                        'amount' => $request->paid,
                        'status' => 1,
                        'payment_type' => 1,
                        'due_condition' => $request->due_condition,
                    ]);
                }

                $sale_detail = SaleDetail::insert($sold_products);
            }
        }

        // return Customer::with('adress')->get();



        // $sale = Sale::create($this->validateData($request) + [
        //     'user_id' => Auth::id()
        // ]);
        return redirect()
            ->route('sales.show', $sale->id)
            // ->route('sales.index')
            ->with('status', 'The record has been added successfully.');
    }

    public function show($id)
    {
        // return GenesisCustomerInfo::with('sale')->get();
        // return Sale::with('genesis_info')->get();

        // return $sale->with('outlet', 'customer.adress', 'genesis_info', 'user')
        $sale = Sale::with(['outlet',
        'customer.address.area.district.division',
        'genesis_info',
        'user',
        'sale_details.product',
        'sale_details.price_category',
        ])
        // ->when()
        ->find($id);
        // return $sale->customer;
        SaleResource::withoutWrapping();
        SaleResource::$show = true;
        // return new SaleResource($sale);

        return Inertia::render('Sale/Invoice', [
            'sale' => new SaleResource($sale),
        ]);
    }

    public function edit(Sale $sale)
    {
        return Inertia::render('Sale/Edit', [
            'sale' => $sale,
            'outlets' => Outlet::active()->pluck('name', 'id')
        ]);
    }

    public function update(Request $request, Sale $sale)
    {
        $sale->update($this->validateData($request, $sale->id));

        return redirect()
            ->route('sales.show', $sale->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function search()
    {
        $this->getQuery()
            ->when(request()->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'regexp', $search);
                });
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            //
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'outlet_id'         => [''],
            'customer_name'     => ['required'],
            'customer_phone'    => ['required'],
            'customer_address'  => ['required'],
            'subtotal'          => '',
            'discount'          => '',
            'discount_purpose'  => '',
            'amount'            => ''
        ]);
    }
}
