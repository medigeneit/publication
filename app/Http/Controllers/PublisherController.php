<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::query()
            ->with('user')
            ->filter()
            ->search(['id', 'name', 'phone', 'email'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Publisher/Index', [
            'publishers' => PublisherResource::collection($publishers->paginate(request()->perpage)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Publisher/Create', [
            'publisher' => new Publisher(),
        ]);
    }

    public function store(Request $request)
    {
        $publisher = Publisher::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('publishers.show', $publisher->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Publisher $publisher)
    {
        PublisherResource::withoutWrapping();

        return Inertia::render('Publisher/Show', [
            'publisher' => new PublisherResource($publisher),
        ]);
    }

    public function edit(Publisher $publisher)
    {
        return Inertia::render('Publisher/Edit', [
            'publisher' => $publisher,
        ]);
    }

    public function update(Request $request, Publisher $publisher)
    {
        $publisher->update($this->validateData($request, $publisher->id));

        return redirect()
            ->route('publishers.show', $publisher->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()
            ->route('publishers.index')
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
            'active' => Publisher::getActiveProperties()
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => ['required'],
            'phone' => '',
            'email' => '',
            'address' => '',
            'active' => ['required'],
        ]);
    }
}
