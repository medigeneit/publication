<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PressResorce;
use App\Http\Resources\PressResource;
use App\Models\Press;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PressController extends Controller
{
    use DateFilter;

    public function index()
    {
        $presses = $this->setQuery(Press::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Press/Index', [
            'presses' => PressResource::collection($presses->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Press/Create', [
            'press' => new Press(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $press = Press::create($this->validateData($request) + [
            'user_id' => Auth::user()->id
        ]);

        return redirect()
            ->route('presses.show', $press->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Press $press)
    {
        PressResource::withoutWrapping();

        return Inertia::render('Press/Show', [
            'press' => new PressResource($press),
        ]);
    }

    public function edit(Press $press)
    {
        return Inertia::render('Press/Edit', [
            'press' => $press,
        ]);
    }

    public function update(Request $request, Press $press)
    {
        $press->update($this->validateData($request, $press->id) + [
            'user_id' => Auth::user()->id
        ]);

        return redirect()
            ->route('presses.show', $press->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Press $press)
    {
        $press->delete();

        return redirect()
            ->route('presses.index')
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
            'phone' => [
                'required',
                'numeric'
            ],
            'email' => [
                'required',
                'string',
                'email'
            ],
            'address' => [
                'required',
                'string'
            ],

            'active' => [],

            'user_id' => []
        ]);
    }
}
