<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CirculationResource;
use App\Models\Circulation;
use App\Models\Outlet;
use App\Models\Press;
use App\Models\Printing;
use App\Models\Product;
use App\Models\ProductRequest;
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
            ->with(['storage.outlet', 'destinationable', 'storage.product.productable' => function (MorphTo $morphTo) {
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
            ->when(request()->search, function ($query) {
                $query->search(request()->search);
            })
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
        return
        $request;
        $redirect_location = 'storages.index';
        if ($request->has('alert_quantity')) {
            $redirect_location = 'products.index';
            $parameters = [];
        }
        if ($request->has('request_id')) {
            $redirect_location = 'product-requests.index';
            $parameters= ["outlet_id=$request->from"];
        }
        $product_id = 0;
        if ($request->has('request_id')) {
            // return
            $request_storage = ProductRequest::find($request->request_id)->storage;
            $product_id = $request_storage->product_id;
            
        }
        
        // if (!in_array($request->type, array_keys(Circulation::TYPE)) && !in_array($request->type, array_values(Circulation::TYPE))) {
            //     return redirect()
            //         ->route($redirect_location)
            //         ->with('status', 'Unsuccessfull attempt, because of wrong type.');
            // }
            // return array_values(Circulation::TYPE);
            
            // return Circulation::TYPE[$request->type] == 'In';
            if (Circulation::TYPE[$request->type] == 'In') {
                // return 'in';
                $circulation = Circulation::find($request->circulation_id)->load('storage');
                $quantity = $request->quantity;
                $storage_outlet_id = $request->to ?? $request_storage->outlet_id;
                $destination = $request->from ?? $circulation->storage->outlet_id;
                if (Circulation::STORAGE_TYPE[$request->requastable_type] == 'Press')
                {
                    $requestable_type = Printing::class ?? null;
                }
                if (Circulation::STORAGE_TYPE[$request->requastable_type] == 'Outlet')
                {
                    $requestable_type = ProductRequest::class ?? null;
                }
                // return $requestable_type;
                $requestable_id =  $request->request_id ?? null;
            } elseif (Circulation::TYPE[$request->type] == 'Out') {
                $request->requastable_type = 2;
                $quantity = $request->quantity * -1;
                $storage_outlet_id = $request->from;
                $destination = $request->to ?? $request_storage->outlet_id;
                $requestable_type = ProductRequest::class ?? null;
                $requestable_id =  $request->request_id ?? null;
            }
            // return
            $storage = Storage::query()
            ->where([
                'outlet_id' => $storage_outlet_id,
                'product_id' => $request->product_id ?? $product_id,
                ])->first();
                
                if (Circulation::TYPE[$request->type] == 'In' &&  !$storage) {
                    $storage = new Storage;
                    $storage->user_id  = Auth::id();
                    $storage->outlet_id  = $storage_outlet_id;
                    $storage->product_id = $request->product_id;
                    $storage->alert_quantity = $request->alert_quantity;
                    $updated_quantity = $quantity;
                } else {
                    // return 
                    $updated_quantity = $storage->quantity + $quantity;
                }
                // return [$storage, $updated_quantity];
                
                if ($updated_quantity >= 0) {
                    $storage->quantity = $updated_quantity;
                    $updated = $storage->save();
                    
                    if ($updated) {
                        $data = [
                            'storage_id' => $storage->id,
                            'quantity' => $quantity,
                            'requestable_type' => $requestable_type,
                            'requestable_id' => $requestable_id,
                            'circulation_id' => $request->circulation_id,
                            'user_id' => Auth::id(),
                        ];
                        if (Circulation::STORAGE_TYPE[$request->requastable_type] == 'Press') {
                            $press = Press::findOrFail($destination);
                            $press->circulations()->create($data);
                        } elseif (Circulation::STORAGE_TYPE[$request->requastable_type] == 'Outlet') {
                            $outlet = Outlet::findOrFail($destination);
                            $outlet->circulations()->create($data);
                        }
                    }
                } else {
                    $data = [
                        'message' => 'Sory, you dont have enough quantity'
                    ];
                }

        return redirect()
            ->route($redirect_location,$parameters)
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
