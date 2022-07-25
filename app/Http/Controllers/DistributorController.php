<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\DistributorResource;
use App\Models\Area;
use App\Models\Distributor;
use App\Models\District;
use App\Models\Division;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DistributorController extends Controller
{
    use DateFilter;

    public function index()
    {
        $distributors = Distributor::query()
                ->filter()
                ->dateFilter()
                ->search(['id', 'name', 'address', 'phone'])
                ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Distributor/Index', [
            'distributors' => DistributorResource::collection($distributors->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Distributor/Create', [
            "data" => [
                'distributor' => new Distributor(),
                'distributorType'  => Distributor::getTypes(),
                'areas' => Area::get(),
                'divisions' => Division::with('districts.areas')->get(),
                'districts' => District::pluck('name', 'id'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $distributor = Distributor::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);

        return redirect()
            ->route('distributors.show', $distributor->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Distributor $distributor)
    {
        DistributorResource::withoutWrapping();

        return Inertia::render('Distributor/Show', [
            'distributor' => new DistributorResource($distributor),
        ]);
    }

    public function edit(Distributor $distributor)
    {
        return Inertia::render('Distributor/Edit', [
            'distributor' => $distributor,
            'distributorType'  => Distributor::getTypes(),
        ]);
    }

    public function update(Request $request, Distributor $distributor)
    {
        $distributor->update($this->validateData($request, $distributor->id));

        return redirect()
            ->route('distributors.show', $distributor->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Distributor $distributor)
    {
        $distributor->delete();

        return redirect()
            ->route('distributors.index')
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
        $this->getQuery()
            ->when(request()->type, function($query) {
                $query->where('type', request()->type);
            })
            ->when(isset(request()->active), function($query) {
                $query->where('active', request()->active);
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            'type'      => Distributor::getTypes(),
            'active'    => Distributor::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name'      => ['required'],
            'address'   => '',
            'phone'     => '',
            'email'     => '',
            'type'     => ['required'],
            'active'    => ['required'],
        ]);
    }

}
