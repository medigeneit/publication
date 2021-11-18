<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Outlet;
use App\Models\Publisher;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AccountController extends Controller
{
    use DateFilter;

    public function index()
    {
        $accounts = $this->setQuery(Account::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Account/Index', [
            'accounts' => AccountResource::collection($accounts->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Account/Create', [
            'account'  => new Account(),
            'publishers'  => Publisher::pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {
        // return $request;

        $publisher = Publisher::findOrFail($request->publisher_id);

        $account = $publisher->accounts()->create($this->validateData($request));

        // $account = Account::create($this->validateData($request, $publisher));

        return redirect()
            ->route('accounts.show', $account->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Account $account)
    {
        AccountResource::withoutWrapping();

        return Inertia::render('Account/Show', [
            'account' => new AccountResource($account),
        ]);
    }

    public function edit(Account $account)
    {
        return Inertia::render('Account/Edit', [
            'account' => $account,
            'publishers'  => Publisher::pluck('name', 'id')
        ]);
    }

    public function update(Request $request, Account $account)
    {
        $publisher = Publisher::findOrFail($request->publisher_id);

        $account = $publisher->accounts()->create($this->validateData($request));

        // $account->update($this->validateData($request, $account->id));

        return redirect()
            ->route('accounts.show', $account->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()
            ->route('accounts.index')
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
            'purpose'       => ['required'],
            'amount'        => ['required'],
            'type'          => ['required']
        ]);
    }
}
