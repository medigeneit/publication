<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    use DateFilter;

    public function index()
    {
        $authors = $this->setQuery(Author::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Author/Index', [
            'authors' => AuthorResource::collection($authors->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Author/Create', [
            'author' => new Author(),
        ]);
    }

    public function store(Request $request)
    {
        $author = Author::create($this->validateData($request));

        return redirect()
            ->route('authors.show', $author->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Author $author)
    {
        AuthorResource::withoutWrapping();

        return Inertia::render('Author/Show', [
            'author' => new AuthorResource($author),
        ]);
    }

    public function edit(Author $author)
    {
        return Inertia::render('Author/Edit', [
            'author' => $author,
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $author->update($this->validateData($request, $author->id));

        return redirect()
            ->route('authors.show', $author->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()
            ->route('authors.index')
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
            'name' => ['required'],
            'active' => ['required'],
        ]);
    }
}
