<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\IncomeResource;
use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IncomeController extends Controller
{
    use DateFilter;

    public function index()
    {
        $incomes = $this->setQuery(Account::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery()
            ->where('type', 1);

        return Inertia::render('Income/Index', [
            'incomes' => IncomeResource::collection($incomes->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Income/Create', [
            'income' => new Account(),
            'publishers'  => Publisher::active()->pluck('name', 'id'),
            'accountType'  => Account::getTypes(),
            'incomeCategoryList' => AccountCategory::where('type', 1)->pluck('name', 'id'),
            'expenseCategoryList' => AccountCategory::where('type', 2)->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $publisher = Publisher::findOrFail($request->publisher_id);

        $income = $publisher->accounts()->create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('incomes.show', $income->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Account $income)
    {
        IncomeResource::withoutWrapping();

        return Inertia::render('Income/Show', [
            'income' => new AccountResource($income),
        ]);
    }

    public function edit(Account $income)
    {
        return Inertia::render('Income/Edit', [
            'income' => $income,
            'publishers'  => Publisher::active()->pluck('name', 'id'),
            'accountType'  => Account::getTypes(),
            'incomeCategoryList' => AccountCategory::where('type', 1)->pluck('name', 'id'),
            'expenseCategoryList' => AccountCategory::where('type', 2)->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Account $income)
    {
        $income->update($this->validateData($request, $income->id) + [
            'accountable_id' => $request->publisher_id
        ]);

        return redirect()
            ->route('incomes.show', $income->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Account $income)
    {
        $income->delete();

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
            'purpose'               => ['required'],
            'amount'                => ['required'],
            'type'                  => ['required'],
            'account_category_id'   => ['required'],
        ]);
    }

}
