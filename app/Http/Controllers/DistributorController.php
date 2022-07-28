<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistributorResource;
use App\Models\Area;
use App\Models\Distributor;
use App\Models\District;
use App\Models\Division;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Volume;
use App\Models\Version;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DistributorController extends Controller
{
    use DateFilter;

    public function index()
    {
        $distributors = Distributor::query()
                ->filter()
                ->dateFilter()
                ->search(['id', 'name', 'address', 'phone'])
                ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Distributor/Index', [
            'distributors' => DistributorResource::collection($distributors->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
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
            ->productSearch(request()->search)
            // ->orderBy('name')
            ->get();

        foreach ($products as $product) {

            $property = (object)[
                'id'    => (int) ($product->id ?? 0),
                'name'  => (string) ($product->product_name ?? ''),

            ];

            $productList[$product->id] = $property;
        }
        return Inertia::render('Distributor/Create', [
            "data" => [
                'distributor' => new Distributor(),
                'distributorType'  => Distributor::getTypes(),
                'areas' => Area::get(),
                'divisions' => Division::with('districts.areas')->get(),
                'districts' => District::pluck('name', 'id'),
                "priceCategories" => PriceCategory::pluck('name', 'id'),
                "productList" => $productList
            ]
        ]);
    }

    public function store(Request $request)
    {
        return $request;
        $distributor = Distributor::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('distributors.show', $distributor->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Distributor $distributor)
    {
        DistributorResource::withoutWrapping();

        return Inertia::render('Distributor/Show', [
            'distributor' => new DistributorResource($distributor),
        ]);
    }

    public function edit(Distributor $distributor)
    {
        return Inertia::render('Distributor/Edit', [
            'distributor' => $distributor,
            'distributorType'  => Distributor::getTypes(),
        ]);
    }

    public function update(Request $request, Distributor $distributor)
    {
        $distributor->update($this->validateData($request, $distributor->id));

        return redirect()
            ->route('distributors.show', $distributor->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()
            ->route('distributors.index')
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

    protected function filter()
    {
        $this->getQuery()
            ->when(request()->type, function($query) {
                $query->where('type', request()->type);
            })
            ->when(isset(request()->active), function($query) {
                $query->where('active', request()->active);
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            'type'      => Distributor::getTypes(),
            'active'    => Distributor::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name'      => ['required'],
            'address'   => '',
            'phone'     => '',
            'email'     => '',
            'type'     => ['required'],
            'active'    => ['required'],
        ]);
    }

    // public function client_id_generate($client_id_list = [])
    // {
    //     // return 313;
    //     if (!$client_id_list) {
    //         # code...
    //         $client_id_list = Distributor::pluck('client_id')->toArray();
    //     }
    //     $chars = "ABCDEFGHOTKLMNOPQRSTUVWXYZ";
    //     $nums = "0123456789";
    //     $generated_id = substr(str_shuffle($chars),0, 1) . substr(str_shuffle($nums),0, 6);
    //     // return $generated_id;
    //     // $generated_id = 'O914078';
        

    //     if(!in_array($generated_id, $client_id_list)) {
    //         return $generated_id;
    //     } else {
    //         $this->client_id_generate($client_id_list);
    //         // return $generated_id;
    //     }
    // }

}
