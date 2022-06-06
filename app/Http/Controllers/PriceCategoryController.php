<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PriceCategoryResource;
use App\Models\PriceCategory;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PriceCategoryController extends Controller
{
    use DateFilter;

    public function index()
    {
        $priceCategory = PriceCategory::query()
            ->search(['id', 'name',])
            ->filter()
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('PriceCategory/Index', [
            'priceCategories' => PriceCategoryResource::collection($priceCategory->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('PriceCategory/Create', [
            'priceCategory'  => new PriceCategory(),
        ]);
    }

    public function store(Request $request)
    {

        $priceCategory = PriceCategory::create($this->validateData($request));

        return redirect()
            ->route('price-categories.show', $priceCategory->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(PriceCategory $priceCategory)
    {
        PriceCategoryResource::withoutWrapping();

        return Inertia::render('PriceCategory/Show', [
            'priceCategory' => new PriceCategoryResource($priceCategory),
        ]);
    }

    public function edit(PriceCategory $pricecategory)
    {
        return Inertia::render('PriceCategory/Edit', [
            'priceCategory' => $pricecategory,
        ]);
    }

    public function update(Request $request, PriceCategory $pricecategory)
    {
        $pricecategory = PriceCategory::create($this->validateData($request, $pricecategory->id));

        return redirect()
            ->route('price-categories.show', $pricecategory->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(PriceCategory $pricecategory)
    {
        $pricecategory->delete();

        return redirect()
            ->route('price-categories.index')
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
            'name'       => ['required'],
        ]);
    }
}
