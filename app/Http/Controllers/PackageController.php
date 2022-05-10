<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageResource;
use App\Models\Package;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PackageController extends Controller
{
    use DateFilter;

    public function index()
    {
        DB::enableQueryLog();

        $packages = Package::query()
            ->with('package_products.product')
            // ->whereHas('package_products.product',function($query){
            //     $query->nameRelations();
            // })
            
            // ->filter()
            ->dateFilter();
            return [$packages->get(),
            DB::getQueryLog()];

        return Inertia::render('Package/Index', [
            'packages' => PackageResource::collection($packages->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }
 
    public function create()
    {
        return Inertia::render('Package/Create', [
            'package' => new Package(),
        ]);
    }

    public function store(Request $request)
    {
        $package = Package::create($this->validateData($request));

        return redirect()
            ->route('packages.show', $package->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Package $package)
    {
        PackageResource::withoutWrapping();

        return Inertia::render('Package/Show', [
            'package' => new PackageResource($package),
        ]);
    }

    public function edit(Package $package)
    {
        return Inertia::render('Package/Edit', [
            'package' => $package,
        ]);
    }

    public function update(Request $request, Package $package)
    {
        $package->update($this->validateData($request, $package->id));

        return redirect()
            ->route('packages.show', $package->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()
            ->route('packages.index')
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
