<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CostCategoryResource;
use App\Models\CostCategory;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CostCategoryController extends Controller
{
    use DateFilter;

    public function create()
    {
        return Inertia::render('VersionVariable/CostCategoryForm', [
            'costCategory' => new CostCategory(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        CostCategory::insert($this->validateData($request));

        return redirect()
            ->route('version-variables.index')
            ->with('status', 'The record has been added successfully.');
    }

    public function show()
    {
        return 123;
    }

    public function edit(CostCategory $costCategory)
    {
        // return 123;
        return Inertia::render('VersionVariable/CostCategoryEdit', [
            'costCategory' => $costCategory,
        ]);
    }

    public function update(Request $request, CostCategory $costCategory)
    {
        // return "update";
        $costCategory->update($this->validateData($request, $costCategory->id));
        return redirect()
            ->route('version-variables.index', $costCategory->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(CostCategory $costCategory)
    {
        $costCategory->delete();
        return redirect()
            ->route('version-variables.index')
            ->with('status', 'The record has been delete successfully.');
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => ['required', 'string'],
            'active' => []
        ]);
    }
}
