<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SaleProductResource;
use App\Http\Resources\SaleResource;
use App\Models\Outlet;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Sale;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::query()
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Sale/Index', [
            'sales' => SaleResource::collection($sales->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $productList = [];

        // return request()->search;

        $products = Product::query()
            ->with(['categories',  'prices', 'storages.outlet', 'productable' => function (MorphTo $morphTo) {
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
            ->where('active', 1)
            // ->when(isset(request()->search), function ($query) {
            //     $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
            //         ->orWhere('id', request()->search)
            //         ->orWhereIn('id', explode(',', request()->selected));
            // })
            ->search(request()->search)
            // ->orderBy('name')
            ->get();


            foreach ($products as $product) {
                // $unit_price = (object) [
                    //     1 => (float) ($product->wholesale_price ?? 0),
            //     2 => (float) ($product->retail_price ?? 0),
            //     3 => (float) ($product->distribute_price ?? 0),
            //     4 => (float) ($product->special_price ?? 0),
            // ];

            $unit_price = $product->prices->pluck('name', 'id');

            $property = (object)[
                'name'          => (string) ($product->product_name ?? ''),
                'maxQuantity'   => (int) rand(10, 20),
                'unitPrice'     => (object) $unit_price,

            ];

            $productList[$product->id] = $property;
        }


        // $productList[5] = [
        //     'name'          => 'Last Hour',
        //     'maxQuantity'   => 10,
        //     'unitPrice'     => [
        //         1 => 790,
        //         2 => 740,
        //     ],
        // ];

        // $productList[7] = [
        //     'name'          => 'SBA Pearl',
        //     'maxQuantity'   => 5,
        //     'unitPrice'     => [
        //         1 => 590,
        //         2 => 540,
        //     ],
        // ];
        // return PriceCategory::pluck('name', 'id');

        return Inertia::render('Sale/SaleMemo', [
            'sale' => new Sale(),
            'outlets' => Outlet::active()->pluck('name', 'id'),
            'price_types' => PriceCategory::pluck('name', 'id'),
            'products' => $productList,
            // 'showProductList' => request()->search,
            'search' => request()->search,
        ]);
    }

    public function store(Request $request)
    {
        return $request;

        $sale = Sale::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);
        return redirect()
            ->route('sales.show', $sale->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Sale $sale)
    {
        SaleResource::withoutWrapping();

        return Inertia::render('Sale/Show', [
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
