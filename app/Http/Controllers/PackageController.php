<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\PackageProduct;
use App\Models\Product;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PackageController extends Controller
{
    use DateFilter;

    public function index()
    {
        $products = Product::query()
        ->with('categories', 'publisher')
        ->filter()
        ->dateFilter()
        ->where('type', 1)
        ->search(['id', 'name'], ['publisher:name'])
        ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');


        return Inertia::render('Package/Index', [
            'products' => ProductResource::collection($products->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $products =Product::query()
        ->when(isset(request()->search), function ($query) {
            $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                ->orWhere('id', request()->search)
                ->orWhereIn('id', explode(',', request()->selected));
        })
        ->where('type', '!=', 1)
        ->get();

        foreach($products as $product)
        {
            $property = (object)[
                'name'  => (string) ($product->name ?? ''),
                'cost'  => (int) ($product->production_cost ?? ''),
                'mrp'   => (int) ($product->mrp ?? ''),
            ];
        
            $productList[$product->id] = $property;
        }
        return Inertia::render('Package/Create', [
            'product' => new Product(),
            // 'productList' => $products,
            'productList' => $productList,
            'categories'  => Category::mainCategory()->with('subcategories.subcategories.subcategories.subcategories')->active()->get(),
            'productType'  => Product::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);
        $this->categoryInsert($request, $product);

        if(is_array($request->product_ids)) {
            $this->packageInsert($request, $product);
        }

        return redirect()
            ->route('packages.show', $product->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Product $product)
    {
        ProductResource::withoutWrapping();
        $product = Product::find(request()->segment(2));
        return Inertia::render('Package/Show', [
            'product' => new ProductResource($product),
            'categories' => $product->categories()->pluck('name')
        ]);
    }

    public function edit(Product $product)
    {
        $product = Product::find(request()->segment(2));
        
        $products =Product::query()
        ->when(isset(request()->search), function ($query) {
            $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                ->orWhere('id', request()->search)
                ->orWhereIn('id', explode(',', request()->selected));
        })
        ->where('type', '!=', 1)
        ->get();
        
        foreach($products as $item)
        {
            $property = (object)[
                'name'  => (string) ($item->name ?? ''),
                'cost'  => (int) ($item->production_cost ?? ''),
                'mrp'   => (int) ($item->mrp ?? ''),
            ];
        
            $productList[$item->id] = $property;
        }
        
        return Inertia::render('Package/Edit', [
            'product'               => $product,
            'productCategories'     => $product->categories,
            'productList'           => $productList,
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
            ->route('packages.show', $product->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function categoryInsert($request, $product)
    {
        CategoryProduct::where(['product_id' => $product->id])->delete();
        
        if(is_array($request->category_ids)) {
            foreach($request->category_ids as $category_id) {
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
            foreach($request->product_ids as $package_id) {
                PackageProduct::onlyTrashed()->updateOrCreate(
                    ['package_id' => $product->id],
                    ['product_id' => $package_id, 
                    'deleted_at' => null
                    ]
                );

                // if(is_array($request->packageProductPrice)) {
                //     foreach($request->packageProductPrice as $id => $packageProductPrice) {
                //         PackageProduct::where(['product_id'=> $id, 'id' => $package->id])->update([
                //             'price' => $packageProductPrice
                //         ]);
                //     }
                // }
            }
    }

    public function destroy(Product $product)
    {
        $product->delete();

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
