<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\StorageResource;
use App\Models\Outlet;
use App\Models\PriceCategory;
use App\Models\Product;
use App\Models\Storage;
use App\Models\User;
use App\Models\Version;
use App\Models\Volume;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StorageController extends Controller
{
    use DateFilter;

    public function index()
    {
        $storages = Storage::query()
            ->with(['product.productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with('version.production');
                    },
                    Version::class => function ($query) {
                        $query->with('volumes', 'production');
                    },
                ]);
            }, 'outlet', 'user'])
            ->filter()
            ->dateFilter()
            ->search(['id'], ['product:name', 'outlet:name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

            // return $storages ->get();

        return Inertia::render('Storage/Index', [
            'storages' => StorageResource::collection($storages->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'outlets' => Outlet::pluck('name', 'id'),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        // foreach (Product::get() as $key => $product) {
        //    return  $product->product_name;
        // }
        return  Inertia::render('Storage/Create', [
            'storage'   => new Storage(),
            'outlets'   => Outlet::pluck('name', 'id'),
            'products'  => Product::with(['productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with('version.production');
                    },
                    Version::class => function ($query) {
                        $query->with('volumes', 'production');
                    },
                ]);
            }])->get()->pluck('product_name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $storage = Storage::create($this->validateData($request) + [
            'user_id' => Auth::id(),
        ]);

        return redirect()
            ->route('storages.show', $storage->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Storage $storage)
    {
        StorageResource::withoutWrapping();

        return Inertia::render('Storage/Show', [
            'storage' => new StorageResource($storage),
        ]);
    }

    public function edit(Storage $storage)
    {

        return Inertia::render('Storage/Edit', [
            'storage' => $storage,
            'outlets'   => Outlet::pluck('name', 'id'),
            'products'  => Product::with(['productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with('version.production');
                    },
                    Version::class => function ($query) {
                        $query->with('volumes', 'production');
                    },
                ]);
            }])->get()->pluck('product_name', 'id'),
        ]);
    }

    public function update(Request $request, Storage $storage)
    {
        $storage->update($this->validateData($request, $storage->id));

        return redirect()
            ->route('storages.show', $storage->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Storage $storage)
    {
        $storage->delete();

        return redirect()
            ->route('storages.index')
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
            'outlet_id' => ['required'],
            'product_id' => ['required'],
            'alert_quantity' => ['required'],
        ]);
    }
}
