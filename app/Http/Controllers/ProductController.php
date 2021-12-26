<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Publisher;
use App\Models\PackageProduct;
use App\Models\PriceCategory;
use App\Models\Pricing;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    use DateFilter;

    public function index()
    {
        return
            $products = Product::query()
            ->with('categories', 'publisher', 'prices')
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'], ['publisher:name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Product/Index', [
            'products' => ProductResource::collection($products->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
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
        $this->packageInsert($request, $product);

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
                Product::insert(
                    [
                        'pricing_id' => $index,
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
        return Inertia::render('Product/Edit', [
            'product'               => $product,
            'productCategories'     => $product->categories,
            'publisherList'         => Publisher::active()->pluck('name', 'id'),
            'productList'           => Product::where('id', '!=', $product->id)->pluck('name', 'id'),
            'product_ids'           => $product->package_products()->get()->pluck('id')->toArray(),
            'category_ids'          => $product->categories()->get()->pluck('id')->toArray(),
            'categories'            => Category::mainCategory()->with('subcategories.subcategories.subcategories.subcategories')->active()->get(),
            'productType'           => Product::getTypes(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validateData($request, $product->id));

        $this->categoryInsert($request, $product);

        $this->packageInsert($request, $product);

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
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name'                  => ['required'],
            'type'                  => ['required'],
            'publisher_id'          => '',
            'production_cost'       => ['required'],
            'mrp'                   => ['required'],
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
            'active'                => ['required'],

        ]);
    }
}
