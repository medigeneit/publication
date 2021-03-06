<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Author;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\ModeratorType;
use App\Models\Outlet;
use App\Models\Package;
use App\Models\Product;
use App\Models\Publisher;
use App\Models\PackageProduct;
use App\Models\PriceCategory;
use App\Models\Pricing;
use App\Models\Version;
use App\Models\Volume;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;

use function PHPUnit\Framework\returnSelf;

class ProductController extends Controller
{
    use DateFilter;

    public function index()
    {
        // \DB::connection()->enableQueryLog();

        // $filter = new IntToRoman();

        // return request()->number;

        $search = preg_replace('/ /', '%', request()->search);
        // return
        $search = request()->search ? explode(',', $search) : NULL;
        $search_by_name = $search[0] ?? '';
        $search_by_edition = $search[1] ?? '';
        $search_by_vol = $search[2] ?? '';
        // $search = preg_replace('//', '.', request()->search);

        $price_categories = PriceCategory::pluck('name', 'id');
        ProductResource::$price_categories = $price_categories;

        $products = Product::query()
            // ->with(['categories',  'prices', 'storages.outlet', 'storages.productRequests'])
            // ->withMorphTo('productable', [
            //     Volume::class => [
            //         'version.production.publisher:id,name',
            //         'version.volumes:id,version_id',
            //         'version.moderators:id,author_id,moderator_type,version_id',
            //         'version.moderators.moderators_type:id,name',
            //         'version.moderators.author:id,name'
            //     ],
            //     Version::class => [
            //         'moderators:id,author_id,moderator_type,version_id',
            //         'moderators.moderators_type:id,name',
            //         'moderators.author:id,name',
            //         'volumes',
            //         'production.publisher:id,name'
            //     ]
            // ])

            // ->with('categories', 'publisher', 'prices', 'price_categories')

            ->with(['categories',  'prices', 'storages.outlet', 'storages.productRequests', 'storages.productRequests.storage.outlet', 'productable' => function (MorphTo $morphTo) {

                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with([
                            'version.production.publisher:id,name',
                            'version.volumes:id,version_id',
                            'version.moderators:id,author_id,moderator_type,version_id',
                            'version.moderators.moderators_type:id,name',
                            'version.moderators.author:id,name',
                            'version.last_printing'
                        ]);
                    },
                    Version::class => function ($query) {
                        $query->with([
                            'moderators:id,author_id,moderator_type,version_id',
                            'moderators.moderators_type:id,name',
                            'moderators.author:id,name',
                            'volumes',
                            'production.publisher:id,name',
                            'last_printing'

                        ]);
                    },
                    Package::class => function ($query) {
                        $query->with('package_products.product.storages')
                        ->withMorphTo('package_products.product.productable', [
                            Volume::class => [
                                'version.production'
                            ],
                            Version::class => [
                                'volumes', 'production'
                            ]
                        ]);
                    },

                ]);
            }])
            // */

            ->filter()
            ->dateFilter()
            ->search(request()->search)
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');


        // return
        // $products =  ProductResource::collection($products->get());
        // $products =  $products->get();
        // $products =  $products->where('id',10)->first()->storages->pluck('quantity')->sum();
        // $instance =  $products[10];
        // $moderators = $instance->productable_type == Volume::class ? ($instance->productable->version->moderators) :  ($instance->productable_type == Version::class ? $instance->productable->moderators : []);
        // return $products->get();
        
        return Inertia::render('Product/Index', [
            'products' => ProductResource::collection($products->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'outlets' => Outlet::pluck('name', 'id'),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Product/Create', [
            'product' => new Product(),
            'publisherList' => Publisher::active()->pluck('name', 'id'),
            // 'productList' => Product::pluck('name', 'id'),
            'categories'  => Category::mainCategory()->with('subcategories.subcategories.subcategories.subcategories')->active()->get(),
            'productType'  => Product::getTypes(),
            'priceCategories' => PriceCategory::get(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);
        $this->categoryInsert($request, $product);
        // $this->packageInsert($request, $product);

        if (is_array($request->amounts)) {

            foreach ($request->amounts as $index => $amount) {
                // return $index;
                if ($amount == '') {
                    continue;
                }
                Pricing::insert(
                    [
                        'product_id' => $product->id,
                        'price_category_id' => $index,
                        'amount' => $amount,
                        'deleted_at' => NULL
                    ]
                );
            }
        }

        return redirect()
            ->route('products.show', $product->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Product $product)
    {
        ProductResource::withoutWrapping();

        return Inertia::render('Product/Show', [
            'product' => new ProductResource($product),
            'categories' => $product->categories()->pluck('name')
        ]);
    }

    public function edit(Product $product)
    {
        $product->load('prices', 'categories');
        // return $product->prices()->pluck('amount', 'id');
        return Inertia::render('Product/Edit', [
            "data" => [
                'product'                   => $product,
                'category_ids'              => $product->categories->pluck('id')->toArray(),
                'categories'                => Category::mainCategory()->with('subcategories.subcategories.subcategories.subcategories')->active()->get(),
                'priceCategories'           => PriceCategory::get(),
                'selectedPriceCategories'   => $product->prices->pluck('amount', 'price_category_id'),
            ]
        ]);
    }

    public function update(Request $request, Product $product)
    {
        
        $product->update($this->validateData($request, $product->id));

        if ($request->image && $request->file('image')) {
            
            $image = request()->file('image');
            $extention = strtolower($image->getClientOriginalExtension());
            $name = 'product_' . strtolower(Str::random(4));
            $fileName = $name . time() . '.' . $extention;
            $path = 'products/';

            $finalImage = ImageManagerStatic::make($image->getRealPath())
                ->resize(260, 360)
                ->encode($extention);

            Storage::put('public/' . $path . $fileName, $finalImage->__toString());

            $finalImage = 'storage/' . $path . $fileName;
            $product->update([
                'img' => $finalImage
            ]);
            Session::flash('status', 'This is a message!'); 
        }
        if (is_array($request->amounts)) {

            foreach ($request->amounts as $index => $amount) {
                // return $index;
                if ($amount == '') {
                    continue;
                }
                Pricing::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'price_category_id' => $index,
                    ],
                    [
                        'amount' => $amount,
                        'deleted_at' => NULL
                    ]
                );
            }
        }

        $this->categoryInsert($request, $product);

        // $this->packageInsert($request, $product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function categoryInsert($request, $product)
    {
        CategoryProduct::where(['product_id' => $product->id])->delete();

        if (is_array($request->category_ids)) {
            foreach ($request->category_ids as $category_id) {
                CategoryProduct::onlyTrashed()->updateOrCreate(
                    [
                        'product_id' => $product->id
                    ],
                    [
                        'category_id'   => $category_id,
                        'deleted_at'    => null
                    ]
                );
            }
        }
    }

    protected function packageInsert($request, $product)
    {
        PackageProduct::where(['package_id' => $product->id])->delete();

        if (is_array($request->product_ids)) {
            foreach ($request->product_ids as $package_id) {
                PackageProduct::onlyTrashed()->updateOrCreate(
                    ['package_id' => $product->id],
                    ['product_id' => $package_id, 'deleted_at' => null]
                );
            }
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
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
            'type' => Product::getTypes(),
            'active' => Product::getActiveProperties(),
            'moderator_type' => ModeratorType::pluck('name', 'id'),
            'author' => Author::query()
                // ->when(request()->moderator_type,function($query){
                //     $query->where('moderator_type',request()->moderator_type);
                // })
                ->pluck('name', 'id'),
            'category' => Category::pluck('name', 'id'),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'soft'                  => [''],
            'name'                  => [''],
            'type'                  => [''],
            'publisher_id'          => '',
            'production_cost'       => [''],
            'mrp'                   => [''],
            'wholesale_price'       => [''],
            'retail_price'          => [''],
            'distribute_price'      => [''],
            'special_price'         => '',
            'outside_dhaka_price'   => '',
            'ecom_distribute_price' => '',
            'ecom_wholesale_price'  => '',
            'edition'               => '',
            'isbn'                  => '',
            'crl'                   => '',
            'alert_quantity'        => '',
            'active'                => [''],

        ]);
    }
}
