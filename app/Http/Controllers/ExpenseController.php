<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Models\Account;
use App\Models\AccountCategory;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    use DateFilter;

    public function index()
    {
        $expenses = Account::query()
            ->with('publisher')
            ->where('type', 2)
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Expense/Index', [
            'expenses' => ExpenseResource::collection($expenses->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Expense/Create', [
            'expense' => new Account(),
            'publishers'  => Publisher::active()->pluck('name', 'id'),
            'accountType'  => Account::getTypes(),
            'expenseCategoryList' => AccountCategory::where('type', 2)->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $publisher = Publisher::findOrFail($request->publisher_id);

        $expense = $publisher->accounts()->create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('expenses.show', $expense->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Account $expense)
    {
        ExpenseResource::withoutWrapping();

        return Inertia::render('Expense/Show', [
            'expense' => new ExpenseResource($expense),
        ]);
    }

    public function edit(Account $expense)
    {
        return Inertia::render('Expense/Edit', [
            'expense' => $expense,
            'publishers'  => Publisher::active()->pluck('name', 'id'),
            'accountType'  => Account::getTypes(),
            'expenseCategoryList' => AccountCategory::where('type', 2)->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Account $expense)
    {
        $expense->update($this->validateData($request, $expense->id) + [
            'accountable_id' => $request->publisher_id
        ]);

        return redirect()
            ->route('expenses.show', $expense->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Account $expense)
    {
        $expense->delete();

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
