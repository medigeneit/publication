<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageProductListResource;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Version;
use App\Models\Volume;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PackageController extends Controller
{
    use DateFilter;

    public function index()
    {
        // DB::enableQueryLog();

        $packages = Package::query()
            ->withMorphTo('package_products.product.productable', [
                Volume::class => [
                    'version.production'
                ],
                Version::class => [
                    'volumes', 'production'
                ]
            ])
            ->dateFilter();

        // return PackageResource::collection($packages->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input()));
        return Inertia::render('Package/Index', [
            'packages' => PackageResource::collection($packages->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            // 'packages' => $packages,
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $price_categories = PriceCategory::pluck('name', 'id');
        PackageProductListResource::$price_categories = $price_categories;
        $product_list =Product::with([
            'prices',
            'productable' => function (MorphTo $morphTo) {

                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with([
                            'version.production',
                            'version.last_printing'

                        ]);
                    },
                    Version::class => function ($query) {
                        $query->with([
                            'production.publisher:id,name',
                            'last_printing'
                        ]);
                    },
                ]);
            }
        ])->get();

        PackageResource::withoutWrapping();
        
        // return  [
        return Inertia::render('Package/Create', [
            'package' => new Package(),
            'productList' => PackageProductListResource::collection($product_list),
            // 'productList' => $product_list,
        ]);
        // ];
    }

    public function store(Request $request)
    {
        $package = Package::create($this->validateData($request));

        return redirect()
            ->route('packages.show', $package->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Package $package)
    {
        PackageResource::withoutWrapping();

        return Inertia::render('Package/Show', [
            'package' => new PackageResource($package),
        ]);
    }

    public function edit(Package $package)
    {
        return Inertia::render('Package/Edit', [
            'package' => $package,
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $package->update($this->validateData($request, $package->id));

        return redirect()
            ->route('packages.show', $package->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()
            ->route('packages.index')
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
        $this->getQuery();

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
            //
        ]);
    }
}
