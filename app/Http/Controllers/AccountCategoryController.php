<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountCategoryResource;
use App\Models\AccountCategory;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AccountCategoryController extends Controller
{
    use DateFilter;

    public function index()
    {
        $accountCategories = AccountCategory::query()
                        ->filter()
                        ->dateFilter()
                        ->search(['id', 'name'])
                        ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');
        
        return Inertia::render('AccountCategory/Index', [
            'accountCategories' => AccountCategoryResource::collection($accountCategories->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('AccountCategory/Create', [
            'accountCategory' => new AccountCategory(),
            'accountCategoryType' => AccountCategory::getTypes()
        ]);
    }

    public function store(Request $request)
    {
        $accountCategory = AccountCategory::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('account-categories.show', $accountCategory->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(AccountCategory $accountCategory)
    {
        AccountCategoryResource::withoutWrapping();

        return Inertia::render('AccountCategory/Show', [
            'accountCategory' => new AccountCategoryResource($accountCategory),
        ]);
    }

    public function edit(AccountCategory $accountCategory)
    {
        return Inertia::render('AccountCategory/Edit', [
            'accountCategory' => $accountCategory,
            'accountCategoryType' => AccountCategory::getTypes()
        ]);
    }

    public function update(Request $request, AccountCategory $accountCategory)
    {
        $accountCategory->update($this->validateData($request, $accountCategory->id));

        return redirect()
            ->route('account-categories.show', $accountCategory->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(AccountCategory $accountCategory)
    {
        $accountCategory->delete();

        return redirect()
            ->route('account-categories.index')
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
            "type" => AccountCategory::getTypes(),
            "active" => AccountCategory::getActiveProperties()
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            "name" => "required",
            "type" => "required",
            "active" => "required",
        ]);
    }

}
