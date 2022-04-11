<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModeratorTypeResource;
use App\Models\ContributionType;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ModeratorTypeController extends Controller
{
    use DateFilter;

    public function index()
    {
        $moderatorTypes = ContributionType::query()
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        // return $moderatorTypes->get() ;

        return Inertia::render('ContributionType/Index', [
            'ModeratorTypes' => ModeratorTypeResource::collection($moderatorTypes->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('ContributionType/Create', [
            'ContributionType' => new ContributionType(),
        ]);
    }

    public function store(Request $request)
    {
        $ContributionType = ContributionType::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('moderator-types.show', $ContributionType->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(ContributionType $ContributionType)
    {
        ModeratorTypeResource::withoutWrapping();

        return Inertia::render('ContributionType/Show', [
            'ContributionType' => new ModeratorTypeResource($ContributionType),
        ]);
    }

    public function edit(ContributionType $ContributionType)
    {
        return Inertia::render('ContributionType/Edit', [
            'ContributionType' => $ContributionType,
        ]);
    }

    public function update(Request $request, ContributionType $ContributionType)
    {
        $ContributionType->update($this->validateData($request, $ContributionType->id) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('moderator-types.show', $ContributionType->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(ContributionType $ContributionType)
    {
        $ContributionType->delete();

        return redirect()
            ->route('moderator-types.index')
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
            'name' => 'required',
        ]);
    }
}
