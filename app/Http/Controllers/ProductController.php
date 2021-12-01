<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    use DateFilter;

    public function index()
    {
        $products = $this->setQuery(Product::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        // foreach($products->get() as $product)
        // {
        //     $storages = $product->storages->where('product_id', $product->id)->pluck('quantity')->toArray();
        //     $store_count[] = array_sum($storages);
        // }
        // return var_dump($store_count);
        return Inertia::render('Product/Index', [
            'products' => ProductResource::collection($products->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
            // 'store_court' => $store_count
        ]);
    }

    public function create()
    {
        return Inertia::render('Product/Create', [
            'product' => new Product(),
            'publisherList' => Publisher::active()->pluck('name', 'id'),
            'productList' => Product::pluck('name', 'id'),
            'categoryList' => Category::active()->pluck('name', 'id'),
            'categoryProduct' => new CategoryProduct,
            'productType'  => Product::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        $this->categpryInsert($request, $product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Product $product)
    {
        ProductResource::withoutWrapping();

        return Inertia::render('Product/Show', [
            'product' => new ProductResource($product),
        ]);
    }

    public function edit(Product $product)
    {
        return Inertia::render('Product/Edit', [
            'product'               => $product,
            'productCategories'     => $product->categories,
            'publisherList'         => Publisher::active()->pluck('name', 'id'),
            'productList'           => Product::pluck('name', 'id'),
            'categoryList'          => Category::active()->pluck('name', 'id'),
            'categoryProduct'       => CategoryProduct::where('product_id', $product->id)->pluck('category_id'),
            'productType'           => Product::getTypes(),
        ]);
    }

    public function update(Request $request, Product $product)
    {

        $product->update($this->validateData($request, $product->id));
        
        $this->categoryInsert($request, $product);

        return redirect()
            ->route('products.show', $product->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function categpryInsert($request, $product)
    {
        if($request->category_id) {
            
            CategoryProduct::where(['product_id' => $product->id])->delete();


            CategoryProduct::withTrashed()->updateOrCreate(
                ['product_id'       => $product->id],
                [   
                    'category_id'   => $request->category_id,
                    'deleted_at'    => null
                ]
            );
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
            'type' => Product::getTypes(),
            'active' => Product::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name'                  => ['required'],
            'type'                  => ['required'],
            'publisher_id'          => ['required'],
            'production_cost'       => ['required'],
            'mrp'                   => ['required'],
            'wholesale_price'       => ['required'],
            'retail_price'          => ['required'],
            'distribute_price'      => ['required'],
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
