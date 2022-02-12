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
use League\CommonMark\Util\ArrayCollection;

class VersionController extends Controller
{
    use DateFilter;

    public function index()
    {
        $versions = Version::query()
            ->filter()
            ->dateFilter()
            ->with('volumes')
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
        $validate = $this->validateData($request) + [
            'user_id' => Auth::id()
        ];

        $count = 0;

        foreach ($request->volumes as  $volume) {
            
            if($volume['name'] &&( $volume['isbn'] || $volume['crl'])){
                $count ++;
            }
            if($count==2){
                break;
            }
        }

        if($count==2){
            $validate['type'] = $validate['type'] == 1 ? 3 : $validate['type'] ;
        }

        $version = Version::create($validate);

        // if(is_array($request->product_ids)) {
        //     $this->packageInsert($request, $version);
        // }

        if(($request->volumes)) {
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
            'volumes' => Volume::where('version_id', $version->id)->get()
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
                ->get();

        return Inertia::render('Version/Edit', [
            'data' => [
                'productionList'    => Production::pluck('name', 'id'),
                'productList'       => $products,
                'versionType'       => Version::getTypes(),
                'version'           => $version,
                'volumes'           => $version->volumes()->get(),
            ]
        ]);
    }

    public function update(Request $request, Version $version)
    {
        $validate = $this->validateData($request, $version->id);
        
        $count = 0;

        foreach ($request->volumes as  $volume) {
            
            if($volume['name'] &&( $volume['isbn'] || $volume['crl'])){
                $count ++;
            }
            if($count==2){
                break;
            }
        }

        if($count==2){
            $validate['type'] = $validate['type'] == 1 ? 3 : $validate['type'] ;
        }
        else{
            $validate['type'] = 1 ;
        }
        
        $version->update($validate);

        if(($request->volumes)) {
            $this->volumeInsert($request, $version);
        }

        return redirect()
            ->route('versions.show', $version->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Version $version)
    {
        $version->delete();

        return redirect()
            ->route('versions.index')
            ->with('status', 'The record has been delete successfully.');
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
        
        foreach ($request->volumes as $volume)
        {
            // return $volume;
            if($volume['name']) {
                $volume = Volume::onlyTrashed()->updateOrCreate(
                    ['version_id'       => $version->id],
                    [   'name'          => $volume['name'], 
                        'isbn'          => $volume['isbn'], 
                        'crl'           => $volume['crl'], 
                        'user_id'       => Auth::id(),
                        'deleted_at'    => null
                    ]);

                $volume->products()->updateorCreate(
                [
                    'productable_type'  => 'App\Models\Volume',
                    'productable_id'    => $volume->id
                ],
                [
                    'active' => 0
                ]
            );
            }
            
        }
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
            'release_date'      => '',
            'edition'           => '',
            'isbn'              => '',
            'crl'               => '',
            'link'              => '',
            'production_cost'   => '',
            'active'            => '',
        ]);
    }

}
