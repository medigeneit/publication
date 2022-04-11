<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContributorResource;
use App\Models\Contributor;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContributorController extends Controller
{
    use DateFilter;

    public function index()
    {
        $contributors = Contributor::query()
            ->filter()
            ->dateFilter()
            ->search(['id', 'name',])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Contributor/Index', [
            'contributors' => ContributorResource::collection($contributors->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Contributor/Create', [
            'Contributor' => new Contributor(),
        ]);
    }

    public function store(Request $request)
    {
        $Contributor = Contributor::create($this->validateData($request) + [
            'user_id'  => Auth::id(),
        ]);

        return redirect()
            ->route('contributors.show', $Contributor->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Contributor $Contributor)
    {
        ContributorResource::withoutWrapping();

        return Inertia::render('Contributor/Show', [
            'Contributor' => new ContributorResource($Contributor),
        ]);
    }

    public function edit(Contributor $Contributor)
    {
        return Inertia::render('Contributor/Edit', [
            'Contributor' => $Contributor,
        ]);
    }

    public function update(Request $request, Contributor $Contributor)
    {
        $Contributor->update($this->validateData($request, $Contributor->id));

        return redirect()
            ->route('contributors.show', $Contributor->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Contributor $Contributor)
    {
        $Contributor->delete();

        return redirect()
            ->route('contributors.index')
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
            "active" => Contributor::getActiveProperties()
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => ['required'],
            'active' => ['required'],
        ]);
    }
}
