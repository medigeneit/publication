<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModeratorResource;
use App\Models\Contributor;
use App\Models\ContributionType;
use App\Models\Moderator;
use App\Models\Version;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModeratorController extends Controller
{
    use DateFilter;

    public function index()
    {
        $moderators = $this->setQuery(Moderator::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Moderator/Index', [
            'moderators' => ModeratorResource::collection($moderators->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Moderator/Create', [
            "data" => [
                'moderator'     => new Moderator(),
                'versions'      => Version::pluck('edition', 'id'),
                'contributors'       => Contributor::pluck('name', 'id'),
                'ContributionType' => ContributionType::pluck('name', 'id')
            ]
        ]);
    }

    public function store(Request $request)
    {
        $moderator = Moderator::create($this->validateData($request));

        return redirect()
            ->route('moderators.show', $moderator->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Moderator $moderator)
    {
        ModeratorResource::withoutWrapping();

        return Inertia::render('Moderator/Show', [
            'moderator' => new ModeratorResource($moderator),
        ]);
    }

    public function edit(Moderator $moderator)
    {
        return Inertia::render('Moderator/Edit', [
            'moderator' => $moderator,
        ]);
    }

    public function update(Request $request, Moderator $moderator)
    {
        $moderator->update($this->validateData($request, $moderator->id));

        return redirect()
            ->route('moderators.show', $moderator->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Moderator $moderator)
    {
        $moderator->delete();

        return redirect()
            ->route('moderators.index')
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
