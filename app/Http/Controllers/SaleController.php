<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use App\Models\Outlet;
use App\Models\Sale;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::query()
            ->filter()
            ->dateFilter()
            ->search(['id', 'name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Sale/Index', [
            'sales' => SaleResource::collection($sales->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Sale/SaleMemo');
        
        return Inertia::render('Sale/Create', [
            'sale' => new Sale(),
            'outlets' => Outlet::active()->pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {

        $sale = Sale::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('sales.show', $sale->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Sale $sale)
    {
        SaleResource::withoutWrapping();

        return Inertia::render('Sale/Show', [
            'sale' => new SaleResource($sale),
        ]);
    }

    public function edit(Sale $sale)
    {
        return Inertia::render('Sale/Edit', [
            'sale' => $sale,
            'outlets' => Outlet::active()->pluck('name', 'id')
        ]);
    }

    public function update(Request $request, Sale $sale)
    {
        $sale->update($this->validateData($request, $sale->id));

        return redirect()
            ->route('sales.show', $sale->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()
            ->route('sales.index')
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
            //
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'outlet_id'         => [''],
            'customer_name'     => ['required'],
            'customer_phone'    => ['required'],
            'customer_address'  => ['required'],
            'subtotal'          => ['required'],
            'discount'          => ['required'],
            'discount_purpose'  => ['required'],
            'amount'            => ['required']
        ]);
    }
}
