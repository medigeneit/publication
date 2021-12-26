<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PackageController extends Controller
{
    use DateFilter;

    public function index()
    {
        $collections = $this->setQuery(Product::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Product/Index', [
            'collections' => ProductResource::collection($collections->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Product/Create', [
            'product' => new Product(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateData($request));

        return redirect()
            ->route('collections.show', $product->id)
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
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validateData($request, $product->id));

        return redirect()
            ->route('collections.show', $product->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('collections.index')
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
