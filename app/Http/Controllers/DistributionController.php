<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistributionResource;
use App\Models\Distribution;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DistributionController extends Controller
{
    use DateFilter;

    public function index()
    {
        $distributions = $this->setQuery(Distribution::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Distribution/Index', [
            'distributions' => DistributionResource::collection($distributions->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Distribution/Create', [
            'distribution' => new Distribution(),
            'distributionType'  => Distribution::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $distribution = Distribution::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('distributions.show', $distribution->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Distribution $distribution)
    {
        DistributionResource::withoutWrapping();

        return Inertia::render('Distribution/Show', [
            'distribution' => new DistributionResource($distribution),
        ]);
    }

    public function edit(Distribution $distribution)
    {
        return Inertia::render('Distribution/Edit', [
            'distribution' => $distribution,
            'distributionType'  => Distribution::getTypes(),
        ]);
    }

    public function update(Request $request, Distribution $distribution)
    {
        $distribution->update($this->validateData($request, $distribution->id));

        return redirect()
            ->route('distributions.show', $distribution->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()
            ->route('distributions.index')
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
            'name'      => ['required'],
            'address'   => ['required'],
            'phone'     => ['required'],
            'email'     => ['required'],
            'type'     => ['required'],
            'active'    => ['required'],
        ]);
    }

}
