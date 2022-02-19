<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CirculationResource;
use App\Models\Circulation;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CirculationController extends Controller
{
    use DateFilter;

    public function index()
    {
        $collections = $this->setQuery(Circulation::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Circulation/Index', [
            'collections' => CirculationResource::collection($collections->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Circulation/Create', [
            'circulation' => new Circulation(),
        ]);
    }

    public function store(Request $request)
    {
        return $request;
        if(Circulation::TYPE[$request->type]== 'In'){
            $quantity = $request->quantity;
        }
        elseif(Circulation::TYPE[$request->type]== 'Out'){
            $quantity = $request->quantity*-1;
        }
return $quantity;

        $circulation = Circulation::create($this->validateData($request));

        return redirect()
            ->route('collections.show', $circulation->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Circulation $circulation)
    {
        CirculationResource::withoutWrapping();

        return Inertia::render('Circulation/Show', [
            'circulation' => new CirculationResource($circulation),
        ]);
    }

    public function edit(Circulation $circulation)
    {
        return Inertia::render('Circulation/Edit', [
            'circulation' => $circulation,
        ]);
    }

    public function update(Request $request, Circulation $circulation)
    {
        $circulation->update($this->validateData($request, $circulation->id));

        return redirect()
            ->route('collections.show', $circulation->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Circulation $circulation)
    {
        $circulation->delete();

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
