<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostCategoryResource;
use App\Http\Resources\PrintingDetailCategoryResource;
use App\Http\Resources\VersionVariableResource;
use App\Models\CostCategory;
use App\Models\PrintingDetail;
use App\Models\PrintingDetailsCategoryKey;
use App\Models\PrintingDetailsCategoryValue;
use App\Models\VersionCost;
// use App\Models\VersionVariable;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VersionVariableControllor extends Controller
{
    use DateFilter;

    public function index()
    {


        $costCategories = $this->setQuery(CostCategory::query())
            ->search()->filter()
            ->getQuery();

        $printingDetailsCategoryValue = PrintingDetailsCategoryValue::query()
            ->with('values:id,name,printing_details_category_key_id,active')
            ->onlyKeyes()
            ->get();

        return Inertia::render('VersionVariable/Index', [
            'costCategories' => CostCategoryResource::collection($costCategories->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'printingDetailsCategoryValue' => PrintingDetailCategoryResource::collection($printingDetailsCategoryValue),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('VersionVariable/Create', [
            'costCategories'       => CostCategory::get()
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $versionVariable = PrintingDetailsCategoryValue::create($this->validateData($request));

        return back();

        // return redirect()
        //     ->route('collections.show', $versionVariable->id)
        //     ->with('status', 'The record has been added successfully.');
    }

    // public function show(VersionVariable $versionVariable)
    // {
    //     VersionVariableResource::withoutWrapping();

    //     return Inertia::render('VersionVariable/Show', [
    //         'versionVariable' => new VersionVariableResource($versionVariable),
    //     ]);
    // }

    // public function edit(VersionVariable $versionVariable)
    // {
    //     return Inertia::render('VersionVariable/Edit', [
    //         'versionVariable' => $versionVariable,
    //     ]);
    // }

    public function update(Request $request)
    {
        return 123;
    }

    public function destroy(Request $request)
    {
        return 123;

        // $versionVariable->delete();

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
            'name' => [
                'required',
                'string'
            ],
            'printing_details_category_key_id' => ['Nu'],
            'action' => []
        ]);
    }
}
