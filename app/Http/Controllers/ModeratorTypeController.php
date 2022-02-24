<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModeratorTypeResource;
use App\Models\ModeratorType;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ModeratorTypeController extends Controller
{
    use DateFilter;

    public function index()
    {
        $moderatorTypes = ModeratorType::query()
                ->filter()
                ->dateFilter()
                ->search(['id', 'name'])
                ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

                // return $moderatorTypes->get() ;

        return Inertia::render('ModeratorType/Index', [
            'ModeratorTypes' => ModeratorTypeResource::collection($moderatorTypes->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('ModeratorType/Create', [
            'ModeratorType' => new ModeratorType(),
        ]);
    }

    public function store(Request $request)
    {
        $ModeratorType = ModeratorType::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('moderator-types.show', $ModeratorType->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(ModeratorType $ModeratorType)
    {
        ModeratorTypeResource::withoutWrapping();

        return Inertia::render('ModeratorType/Show', [
            'ModeratorType' => new ModeratorTypeResource($ModeratorType),
        ]);
    }

    public function edit(ModeratorType $ModeratorType)
    {
        return Inertia::render('ModeratorType/Edit', [
            'ModeratorType' => $ModeratorType,
        ]);
    }

    public function update(Request $request, ModeratorType $ModeratorType)
    {
        $ModeratorType->update($this->validateData($request, $ModeratorType->id) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('moderator-types.show', $ModeratorType->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(ModeratorType $ModeratorType)
    {
        $ModeratorType->delete();

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
