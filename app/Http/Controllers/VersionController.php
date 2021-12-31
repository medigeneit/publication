<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use App\Models\Product;
use App\Models\Production;
use App\Models\Version;
use App\Models\PackageProduct;
use App\Models\Volume;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VersionController extends Controller
{
    use DateFilter;

    public function index()
    {
        $versions = Version::query()
            ->filter()
            ->dateFilter()
            ->search(['id'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        return Inertia::render('Version/Index', [
            'versions' => VersionResource::collection($versions->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $products =Product::query()
            ->when(isset(request()->search), function ($query) {
                $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                    ->orWhere('id', request()->search)
                    ->orWhereIn('id', explode(',', request()->selected));
            })
            ->get();

        return Inertia::render('Version/Create', [
            'version'           => new Version(),
            'productionList'    => Production::pluck('name', 'id'),
            'productList'       => $products,
            'versionType'       => Version::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        return $request;
        $version = Version::create($this->validateData($request) + [
            'user_id' => Auth::id()
        ]);
        if(is_array($request->product_ids)) {
            $this->packageInsert($request, $version);
        }

        if(($request->volumeNo)) {
            $this->volumeInsert($request, $version);
        }
        
        return redirect()
            ->route('versions.show', $version->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Version $version)
    {
        VersionResource::withoutWrapping();

        return Inertia::render('Version/Show', [
            'version' => new VersionResource($version),
        ]);
    }

    public function edit(Version $version)
    {
        $products =Product::query()
                ->when(isset(request()->search), function ($query) {
                    $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                        ->orWhere('id', request()->search)
                        ->orWhereIn('id', explode(',', request()->selected));
                })
                ->get(['id', 'name', 'production_cost', 'mrp']);

        return Inertia::render('Version/Edit', [
            'productionList'    => Production::pluck('name', 'id'),
            'productList'       => $products,
            'versionType'       => Version::getTypes(),
            'version'           => $version,
        ]);
    }

    public function update(Request $request, Version $version)
    {
        $version->update($this->validateData($request, $version->id));

        return redirect()
            ->route('versions.show', $version->id)
            ->with('status', 'The record has been update successfully.');
    }

    protected function packageInsert($request, $version)
    {
        PackageProduct::where(['package_id' => $version->id])->delete();
        
        foreach($request->product_ids as $package_id) {
            $package= PackageProduct::onlyTrashed()->updateOrCreate(
                ['package_id' => $version->id],
                ['product_id' => $package_id, 'deleted_at' => null]
            );

            if(is_array($request->packageProductPrice)) {
                foreach($request->packageProductPrice as $id => $packageProductPrice) {
                    PackageProduct::where(['product_id'=> $id, 'id' => $package->id])->update([
                        'price' => $packageProductPrice
                    ]);
                }
            }
        }
    }

    protected function volumeInsert($request, $version)
    {
        Volume::where(['version_id' => $version->id])->delete();
        
        
        Volume::onlyTrashed()->updateOrCreate(
            ['version_id'    => $version->id],
            ['name'          => $request->volumeName, 
                'volume_no'     => $request->volumeNo, 
                'link'          => $request->volumeLink,
                'cost'          => $request->volumeCost,
                'user_id'       => Auth::id(),
                'active'        => $request->volumeActive,
                'deleted_at'    => null
            ]);
    }


    public function destroy(Version $version)
    {
        $version->delete();

        return redirect()
            ->route('versions.index')
            ->with('status', 'The record has been delete successfully.');
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
            'type'              => 'required',
            'production_id'     => 'required',
            'edition'           => '',
            'isbn'              => '',
            'crl'               => '',
            'link'              => '',
            'production_cost'   => '',
            'active'            => '',
        ]);
    }

}
