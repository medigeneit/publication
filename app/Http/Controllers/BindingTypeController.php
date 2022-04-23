<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BindingTypeResource;
use App\Models\BindingType;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BindingTypeController extends Controller
{
    use DateFilter;

    public function create()
    {
        return Inertia::render('VersionVariable/BindingTypeCreate', [
            'bindingType' => new BindingType(),
        ]);
    }

    public function store(Request $request)
    {

        $bindingType = BindingType::create($this->validateData($request));

        return redirect()
            ->route('version-variables.index', $bindingType->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(BindingType $bindingType)
    {
        BindingTypeResource::withoutWrapping();

        return Inertia::render('BindingType/Show', [
            'bindingType' => new BindingTypeResource($bindingType),
        ]);
    }

    public function edit(BindingType $bindingType)
    {
        // return $bindingType;

        return Inertia::render('VersionVariable/BindingTypeEdit', [
            'bindingType' => $bindingType,
        ]);
    }

    public function update(Request $request, BindingType $bindingType)
    {
        // return $request;
        $bindingType->update($this->validateData($request, $bindingType->id));

        return redirect()
            ->route('version-variables.index', $bindingType->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(BindingType $bindingType)
    {
        $bindingType->delete();

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
