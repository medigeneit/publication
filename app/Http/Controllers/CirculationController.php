<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CirculationResource;
use App\Models\Circulation;
use App\Models\Outlet;
use App\Models\Storage;
use App\Models\Version;
use App\Models\Volume;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CirculationController extends Controller
{
    use DateFilter;

    public function index()
    {
        $circulations = Circulation::query()
            ->with(['storage', 'destinationable', 'storage.product.productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with('version.production');
                    },
                    Version::class => function ($query) {
                        $query->with('volumes', 'production');
                    },
                ]);
            }])
            ->filter()
            ->dateFilter()
            ->search(['id'], ['product:name', 'outlet:name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc');

        // $circulation_demo = $circulations->get();
        // return $circulation_demo;

        // return  CirculationResource::collection($circulations->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input()));
        return Inertia::render('Circulation/Index', [
            'circulations' => CirculationResource::collection($circulations->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Circulation/Create', [
            'circulation' => new Circulation(),
        ]);
    }

    public function store(Request $request)
    {

        if (!in_array($request->type, array_keys(Circulation::TYPE))) {
            // return  array_keys(Circulation::TYPE);
            // return $request;
            return redirect()
                ->route('storages.index')
                ->with('status', 'Unsuccessfull attempt, because of wrong type.');
        }

        if (Circulation::TYPE[$request->type] == 'In') {
            $quantity = $request->quantity;
            $storage_outlet_id = $request->to;
            $destination = $request->from;
        } elseif (Circulation::TYPE[$request->type] == 'Out') {
            $quantity = $request->quantity * -1;
            $storage_outlet_id = $request->from;
            $destination = $request->to;
        }
        $storage = Storage::query()
            ->where([
                'outlet_id' => $storage_outlet_id,
                'product_id' => $request->product_id,
            ])->first();

        if (Circulation::TYPE[$request->type] == 'In' &&  !$storage) {
            $storage = new Storage;
            $storage->user_id  = Auth::id();
            $storage->outlet_id  = $storage_outlet_id;
            $storage->product_id = $request->product_id;
            $storage->alert_quantity = $request->alert_quantity;
            $updated_quantity = $quantity;
        } else {
            $updated_quantity = $storage->quantity + $quantity;
        }
        // return [$storage, $updated_quantity];

        if ($updated_quantity >= 0) {
            $storage->quantity = $updated_quantity;
            $updated = $storage->save();

            if ($updated) {
                $outlet = Outlet::findOrFail($destination);

                $data = [
                    'storage_id' => $storage->id,
                    'quantity' => $quantity,
                ];

                $outlet->circulations()->create($data);
            }
        } else {
            $data = [
                'message' => 'Sory, you dont have enough quantity'
            ];
        }

        return redirect()
            ->route('storages.index')
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Circulation $circulation)
    {
        CirculationResource::withoutWrapping();

        return Inertia::render('Circulation/Show', [
            'circulation' => new CirculationResource($circulation),
        ]);
    }

    public function edit(Circulation $circulation)
    {
        return Inertia::render('Circulation/Edit', [
            'circulation' => $circulation,
        ]);
    }

    public function update(Request $request, Circulation $circulation)
    {
        $circulation->update($this->validateData($request, $circulation->id));

        return redirect()
            ->route('circulations.show', $circulation->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Circulation $circulation)
    {
        $circulation->delete();

        return redirect()
            ->route('circulations.index')
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
