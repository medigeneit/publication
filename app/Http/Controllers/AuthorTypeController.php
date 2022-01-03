<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorTypeResource;
use App\Models\AuthorType;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthorTypeController extends Controller
{
    use DateFilter;

    public function index()
    {
        $authorTypes = AuthorType::query()
                ->filter()
                ->dateFilter()
                ->search(['id', 'name'])
                ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('AuthorType/Index', [
            'authorTypes' => AuthorTypeResource::collection($authorTypes->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('AuthorType/Create', [
            'authorType' => new AuthorType(),
        ]);
    }

    public function store(Request $request)
    {
        $authorType = AuthorType::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('author-types.show', $authorType->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(AuthorType $authorType)
    {
        AuthorTypeResource::withoutWrapping();

        return Inertia::render('AuthorType/Show', [
            'authorType' => new AuthorTypeResource($authorType),
        ]);
    }

    public function edit(AuthorType $authorType)
    {
        return Inertia::render('AuthorType/Edit', [
            'authorType' => $authorType,
        ]);
    }

    public function update(Request $request, AuthorType $authorType)
    {
        $authorType->update($this->validateData($request, $authorType->id) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('author-types.show', $authorType->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(AuthorType $authorType)
    {
        $authorType->delete();

        return redirect()
            ->route('author-types.index')
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
