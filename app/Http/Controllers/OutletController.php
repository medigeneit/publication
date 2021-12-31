<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OutletResource;
use App\Models\Outlet;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OutletController extends Controller
{
    use DateFilter;

    public function index()
    {
        $outlets = Outlet::query()
            ->with('accounts')
            ->filter()
            ->dateFilter()
            ->search(['id', 'name', 'address', 'phone'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Outlet/Index', [
            'outlets' => OutletResource::collection($outlets->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Outlet/Create', [
            'outlet' => new Outlet(),
            'outletType'  => Outlet::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        $outlet = Outlet::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('outlets.show', $outlet->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Outlet $outlet)
    {
        OutletResource::withoutWrapping();

        return Inertia::render('Outlet/Show', [
            'outlet' => new OutletResource($outlet),
        ]);
    }

    public function edit(Outlet $outlet)
    {
        return Inertia::render('Outlet/Edit', [
            'outlet' => $outlet,
            'outletType'  => Outlet::getTypes(),
        ]);
    }

    public function update(Request $request, Outlet $outlet)
    {
        $outlet->update($this->validateData($request, $outlet->id));

        return redirect()
            ->route('outlets.show', $outlet->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Outlet $outlet)
    {
        $outlet->delete();

        return redirect()
            ->route('outlets.index')
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
            'active' => Outlet::getActiveProperties()
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name'      => ['required'],
            'address'   => '',
            'phone'     => '',
            'email'     => '',
            'type'      => ['required'],
            'active'    => ['required'],
        ]);
    }
}
