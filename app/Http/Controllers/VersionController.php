<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use App\Models\Author;
use App\Models\Moderator;
use App\Models\ModeratorType;
use App\Models\Product;
use App\Models\Production;
use App\Models\Version;
use App\Models\PackageProduct;
use App\Models\Press;
use App\Models\Printing;
use App\Models\PrintingDetailsCategoryKey;
use App\Models\VersionCost;
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
            ->with('volumes', 'printings', 'printings.stored_at', 'user', 'production.publisher', 'moderators:id,author_id,moderator_type,version_id', 'moderators.moderators_type:id,name', 'moderators.author:id,name')
            ->search(['id'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        // return $versions->get();

        return Inertia::render('Version/Index', [
            'versions' => VersionResource::collection($versions->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        $products = Product::query()
            ->when(isset(request()->search), function ($query) {
                $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                    ->orWhere('id', request()->search)
                    ->orWhereIn('id', explode(',', request()->selected));
            })
            ->get();

        $printing_details_category_keys = PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']);


        return Inertia::render('Version/Create', [
            'version'           => new Version(),
            'productionList'    => Production::pluck('name', 'id'),
            'productList'       => $products,
            'authors'           => Author::pluck('name', 'id'),
            'moderatorTypes'    => ModeratorType::pluck('name', 'id'),
            'versionType'       => Version::getTypes(),
            'presses'           => Press::pluck('name', 'id'),
            'printing_details_category_keys' => $printing_details_category_keys
        ]);
    }

    // public function FunctionName(Type $var = null)
    // {
    //     # code...
    // }

    public function store(Request $request)
    {
        return $request;

        $validate = $this->validateData($request) + [
            'user_id' => Auth::id()
        ];


        $count = 0;

        foreach ($request->volumes as  $volume) {

            if ($volume['name'] && ($volume['isbn'] || $volume['crl'])) {
                $count++;
            }
            if ($count == 2) {
                break;
            }
        }

        if ($count == 2) {
            $validate['type'] = $validate['type'] == 1 ? 3 : $validate['type'];
        }

        $version = Version::create($validate);

        $version->products()->updateorCreate(
            [
                'productable_type'  => Version::class,
                'productable_id'    => $version->id
            ],
            [
                'active' => 0
            ]
        );

        if ($request->moderators) {
            foreach ($request->moderators as $moderator) {
                // return $moderator['authorId'];
                $data = [
                    'version_id' => $version->id,
                    'author_id' => $moderator['author_id'],
                    'moderator_type' => $moderator['moderator_type'],
                    'honorarium_type' => $moderator['honorarium_type'],
                    'honorarium' => $moderator['honorarium'],
                ];

                Moderator::create($data);

                // return $moderator;
            }
        }


        if (($request->volumes)) {
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
        // return Printing::where('version_id', $version->id)->with('storeBy:id,name')->get();

        $products = Product::query()
            ->when(isset(request()->search), function ($query) {
                $query->where('name', 'regexp', str_replace(" ", "|", request()->search))
                    ->orWhere('id', request()->search)
                    ->orWhereIn('id', explode(',', request()->selected));
            })
            ->get();
        // return $version->moderators()->get();

        return Inertia::render('Version/Edit', [
            'data' => [
                'productionList'            => Production::pluck('name', 'id'),
                'productList'               => $products,
                'versionType'               => Version::getTypes(),
                'version'                   => $version,
                'volumes'                   => $version->volumes()->get(),
                'authors'                   => Author::pluck('name', 'id'),
                'moderatorTypes'            => ModeratorType::pluck('name', 'id'),
                'selectedModerators'        => $version->moderators()->get(),
                'printingDetails'           => Printing::where('version_id', $version->id)->get(),
                // 'selectedModeratorTypes'    => $version->modera()->get(),
            ]
        ]);
    }

    public function update(Request $request, Version $version)
    {
        // return $request;
        $validate = $this->validateData($request, $version->id);

        $count = 0;

        foreach ($request->volumes as  $volume) {

            if ($volume['name'] && ($volume['isbn'] || $volume['crl'])) {
                $count++;
            }
            if ($count == 2) {
                break;
            }
        }

        if ($count == 2) {
            $validate['type'] = $validate['type'] == 1 ? 3 : $validate['type'];
        } else {
            $validate['type'] = 1;
        }

        $version->update($validate);

        if (($request->volumes)) {
            $this->volumeInsert($request, $version);
        }

        if ($request->moderators) {
            // return
            $this->moderatorInsert($request, $version);
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

        foreach ($request->product_ids as $package_id) {
            $package = PackageProduct::onlyTrashed()->updateOrCreate(
                ['package_id' => $version->id],
                ['product_id' => $package_id, 'deleted_at' => null]
            );

            if (is_array($request->packageProductPrice)) {
                foreach ($request->packageProductPrice as $id => $packageProductPrice) {
                    PackageProduct::where(['product_id' => $id, 'id' => $package->id])->update([
                        'price' => $packageProductPrice
                    ]);
                }
            }
        }
    }

    protected function volumeInsert($request, $version)
    {
        Volume::where(['version_id' => $version->id])->delete();

        foreach ($request->volumes as $volume) {
            // return $volume;
            if ($volume['name']) {
                $volume = Volume::onlyTrashed()->updateOrCreate(
                    ['version_id'       => $version->id],
                    [
                        'name'          => $volume['name'],
                        'isbn'          => $volume['isbn'],
                        'crl'           => $volume['crl'],
                        'user_id'       => Auth::id(),
                        'deleted_at'    => null
                    ]
                );
            }
        }
    }

    protected function moderatorInsert($request, $version)
    {
        Moderator::where(['version_id' => $version->id])->delete();

        foreach ($request->moderators as $moderator) {
            if ($moderator['author_id'] && $moderator['moderator_type'] && $moderator['honorarium_type'])
                // return $moderator['author_id'];
                $moderator = Moderator::onlyTrashed()->updateOrCreate(
                    [
                        'version_id' => $version->id,
                    ],
                    [
                        'author_id' => $moderator['author_id'],
                        'moderator_type' => $moderator['moderator_type'],
                        'honorarium_type' => $moderator['honorarium_type'],
                        'honorarium' => $moderator['honorarium'],
                        'deleted_at'    => null

                    ]
                );

            // return $moderator;
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
