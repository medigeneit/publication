<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintingOrderResource;
use App\Http\Resources\PrintingResource;
use App\Models\Outlet;
use App\Models\Printing;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PrintingOrdersController extends Controller
{
    use DateFilter;

    public function index(Request $request)
    {

        $roles =  Auth::user()->getRoleNames()->toArray();

        $outlets = in_array("Super Admin", $roles) ? Outlet::pluck('name', 'id') : Auth::user()->outlets->pluck('name', 'id');

        $printing_orders = Printing::query()
        ->with([
            'circulations.storage.outlet',
            'circulations.user',
            'version.volumes',
            'version.production',
            'press',

        ])
        ->search(['id'])
        ->filter();

        // $printing_orders = $printing_orders->get();
        // return
        // PrintingOrderResource::collection($printing_orders);


            // PrintingResource::collection($collections->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input()))

        return Inertia::render('PrintingOrders/Index', [
            // 'your_outlets' =>  $outlets,

            'printingOrders' => PrintingOrderResource::collection($printing_orders->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('PrintingOrders/Create', [
            'printing' => new Printing(),
        ]);
    }

    public function store(Request $request)
    {
        $printing = Printing::create($this->validateData($request));

        return redirect()
            ->route('collections.show', $printing->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Printing $printing)
    {
        PrintingResource::withoutWrapping();

        return Inertia::render('PrintingOrders/Show', [
            'printing' => new PrintingResource($printing),
        ]);
    }

    public function edit(Printing $printing)
    {
        return Inertia::render('PrintingOrders/Edit', [
            'printing' => $printing,
        ]);
    }

    public function update(Request $request, Printing $printing)
    {
        $printing->update($this->validateData($request, $printing->id));

        return redirect()
            ->route('collections.show', $printing->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Printing $printing)
    {
        $printing->delete();

        return redirect()
            ->route('collections.index')
            ->with('status', 'The record has been delete successfully.');
    }
    public function close (Printing $printing)
    {
        $printing->update([
            'active' => 0
        ]);

        return redirect()
            ->route('printing-orders.index')
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
