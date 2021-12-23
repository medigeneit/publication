<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = $this->setQuery(Category::query())
            ->search()->filter()
            ->getQuery();

        $categories = Category::query()
        ->with('subcategories.subcategories.subcategories.subcategories')
        ->mainCategory()
        ->get();

        // CategoryResource::withoutWrapping();

        return Inertia::render('Category/Tree', [
            'categories' => CategoryResource::collection($categories),
        ]);

        if (request()->view == 'tree') {
            $categories = Category::query()
                ->with('subcategories.subcategories.subcategories.subcategories')
                ->mainCategory()
                ->get();

            // CategoryResource::withoutWrapping();

            return Inertia::render('Category/Tree', [
                'categories' => CategoryResource::collection($categories),
            ]);
        }

        return Inertia::render('Category/Index', [
            'categories' => CategoryResource::collection($categories->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    private function checkSubcategories($category)
    {
        return $category->subcategories->count();
    }

    public function create()
    {
        return Inertia::render('Category/Create', [
            'category'  => new Category(),
            'parent'    => Category::where('id', request()->parent_id)->first() ?? [],
        ]);
    }

    public function store(Request $request)
    {
        $category = Category::create($this->validateData($request) + [
            'user_id'  => Auth::id(),
        ]);

        return redirect()
            ->route('categories.index');

        return redirect()
            ->route('categories.show', $category->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Category $category)
    {
        CategoryResource::withoutWrapping();

        return Inertia::render('Category/Show', [
            'category' => new CategoryResource($category),
        ]);
    }

    public function edit(Category $category)
    {
        return Inertia::render('Category/Edit', [
            'category' => $category,
            'categoryList' => Category::active()->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validateData($request, $category->id));

        return redirect()
            ->route('categories.show', $category->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('collections.index')
            ->with('status', 'The record has been delete successfully.');
    }

    protected function search()
    {
        $this->getQuery()
            ->when(request()->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'regexp', $search)
                        ->orWhere('name', 'regexp', $search);
                });
            });

        return $this;
    }

    protected function filter()
    {
        $this->getQuery()
            ->when(isset(request()->active), function ($query) {
                $query->where('active', request()->active);
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            'active' => Category::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique(Category::class, 'name')
                    ->where(function ($query) use ($request) {
                        $query->where('parent_id', $request->parent_id);
                    })
                    ->ignore($id),
            ],
            'parent_id' => '',
            'active' => '',
        ]);
    }
}
