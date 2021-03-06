<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductionResource;
use App\Models\Production;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductionController extends Controller
{
    public function index()
    {
        $productions = Production::query()
            ->with('user','publisher')
            ->search(['id', 'name'])
            ->filter()
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Production/Index', [
            'productions' => ProductionResource::collection($productions->paginate(request()->perpage)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Production/Create', [
            'production' => new Production(),
            'publishers' => Publisher::get(),
        ]);
    }

    public function store(Request $request)
    {
        $production = Production::create($this->validateData($request) + [
            'user_id'  => Auth::id(),
        ]);

        return redirect()
            ->route('productions.show', $production->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Production $production)
    {
        ProductionResource::withoutWrapping();

        return Inertia::render('Production/Show', [
            'production' => new ProductionResource($production),
        ]);
    }

    public function edit(Production $production)
    {
        return Inertia::render('Production/Edit', [
            'production' => $production,
            'publishers' => Publisher::get(),
        ]);
    }

    public function update(Request $request, Production $production)
    {
        $production->update($this->validateData($request, $production->id));

        return redirect()
            ->route('productions.show', $production->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Production $production)
    {
        $production->delete();

        return redirect()
            ->route('productions.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function getFilterProperty()
    {
        return [
            'publisher' => Publisher::active()->pluck('name', 'id'),
            'active' => Production::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
            ],
            'publisher_id' => [
                'required',
                'numeric',
            ],
        ]);
    }

}
