<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductRequestResource;
use App\Models\Circulation;
use App\Models\Outlet;
use App\Models\ProductRequest;
use App\Models\RequestResponse;
use App\Models\Storage;
use App\Traits\DateFilter;
use App\Traits\WithProductRelations;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductRequestController extends Controller
{
    use DateFilter;

    public function index(Request $request)
    {
        $roles =  Auth::user()->getRoleNames()->toArray();

        $outlets = in_array("Super Admin", $roles) ? Outlet::pluck('name', 'id') : Auth::user()->outlets->pluck('name', 'id');
        // return array_keys ($outlets->toArray());

        if (!$request->outlet_id) {
            // return
            $request->outlet_id = $outlets->keys()->first();
        } elseif (!in_array($request->outlet_id, array_keys($outlets->toArray()))) {
            return [
                'message' => 'You are not allowed',
                'success' => false,
            ];
        }

        // return
        $productRequests = ProductRequest::query()
            ->with([
                'storage.outlet',
                'storage.product.productable' => function (MorphTo $morphTo) {
                    $morphTo->constrain([
                        Volume::class => function ($query) {
                            $query->with([
                                'version.production',
                                // 'version.volumes:id,version_id',
                            ]);
                        },
                        Version::class => function ($query) {
                            $query->with([
                                'volumes',
                                'production'
                            ]);
                        },
                    ]);
                },

                'storage.product.storages' => function ($query) use ($request) {
                    $query->where('outlet_id', $request->outlet_id);
                },


                'outlet',
                'responses.user',
                'responses.outlet',
                'circulations' => function ($query) {
                    $query->whereNull('circulation_id')->with('circulations');
                }
            ])
            ->when(request()->product, function($query) {
                $query->whereHas('storage.product' , function($query) {
                    $query->where('id', request()->product);
                });
            })
            ->orderBy('expected_date', 'desc');
        // ->search()->filter();

        // return $roles->toArray();
        // return $productRequests->get();
        ProductRequestResource::withoutWrapping();

        ProductRequestResource::$YourOutlet = $request->outlet_id;

        // return
        // [
        //     'your_outlets' =>  $outlets,
        //     'productRequests' => ProductRequestResource::collection($productRequests->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
        //     'filters' => $this->getFilterProperty(),
        // ];

        return Inertia::render('ProductRequest/Index', [
            'your_outlets' =>  in_array("Super Admin", $roles) ? Outlet::pluck('name', 'id') : Auth::user()->outlets->pluck('name', 'id'),
            'productRequests' => ProductRequestResource::collection($productRequests->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
            'types' => ProductRequest::$Type,
            'outlets' => Outlet::where('id','!=',$request->outlet_id)->pluck('name','id'),
        ]);
    }

    public function create()
    {
        return Inertia::render('ProductRequest/Create', [
            'productRequest' => new ProductRequest(),
        ]);
    }
    public function request_page()
    {
        return Inertia::render('ProductRequest/Page', [
            'productRequest' => new ProductRequest(),
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->storage_id) {

            if ($request->type == 1) {
                $product_id = $request->product_id;
                $outlet_id = $request->request_from;
            }
            elseif ($request->type == 2) {
                $product_id = $request->product_id;
                $outlet_id = $request->request_to;
            }

            $storage = Storage::firstOrCreate(
                [
                    'product_id' => $product_id,
                    'outlet_id' => $outlet_id,
                ],
                [
                    'quantity' => 0,
                    'alert_quantity' => 0,
                    'user_id' => Auth::id()
                ]
            );
            $request->storage_id = $storage->id;
        }
         

        // return $request;
        $productRequest = ProductRequest::create([
            'storage_id' => $request->storage_id,
            'request_quantity' => $request->request_quantity,
            'expected_date' => $request->expected_date,
            'type' => $request->request_type ?? 1,
            'is_closed' => 0,
            'outlet_id' => $request->request_to ?? null,
            // 'user_id'     => Auth::user()->id
        ]);
        // return $productRequest;

        $responce_outlet = Storage::find($request->storage_id)->outlet;
        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 1,
                'note' => $request->note ?? null,
                'quantity' => $request->request_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $responce_outlet->id,
            ]);
        }

        return back();

        return redirect()

            ->route('product-requests.index')
            ->with('status', 'The record has been added successfully.');
    }
    
        public function show(ProductRequest $productRequest)
        {
        // return
        // $productRequestShow = ProductRequest::query()
        //     ->with(['storage.outlet', 'storage.user:id,name', 'circulations.storage.outlet', 'circulations.destinationable', 'circulations.storage.product.productable' => function (MorphTo $morphTo) {
        //         $morphTo->constrain([
        //             Volume::class => function ($query) {
        //                 $query->with('version.production');
        //             },
        //             Version::class => function ($query) {
        //                 $query->with('volumes', 'production');
        //             },
        //             Circulation::class => function ($query, $productRequest) {
        //                 $query->where('requestable_id', $productRequest->id);
        //             }
        //         ]);
        //     }])
        //     ->find($productRequest->id);

        // return  $productRequestShow->;

        ProductRequestResource::withoutWrapping();

        return Inertia::render('ProductRequest/Show', [
            'productRequest' => new ProductRequestResource($productRequest),
        ]);
    }

    public function edit(ProductRequest $productRequest)
    {
        return Inertia::render('ProductRequest/Edit', [
            'productRequest' => $productRequest,
        ]);
    }

    public function update(Request $request, ProductRequest $productRequest)
    {
        // return $request;
        $responce_outlet = $productRequest->load('storage');
        // return $request;
        // $productRequest->update($this->validateData($request, $productRequest->id));
        $note = '';
        if ($productRequest->request_quantity != $request->request_quantity) {
            $note .= "<b>Quantity</b> From <b>" . $productRequest->request_quantity . "</b> to <b>" . $request->request_quantity . "</b>";
        }
        if ($productRequest->expected_date != $request->expected_date) {
            if ($note != '') {
                $note .= ' and ';
            }
            $note .= "<b>Expected Date</b> From <b>" . $productRequest->expected_date . "</b> to <b>" . $request->expected_date . "</b>";
        }
        if ($productRequest->requested_to != $request->requested_to) {
            if ($note != '') {
                $note .= ' and ';
            }
            $outlet_before = $productRequest->requested_to ?  $productRequest->outlet->name : 'All';
            $outlet_after = $request->requested_to ? Outlet::find($request->requested_to)->name : 'All';
            $note .= "<b>Outlet</b> From <b>" . $outlet_before . "</b> to <b>" . $outlet_after . "</b>";
        }

        if ($productRequest->type != $request->type) {
            if ($note != '') {
                $note .= ' and ';
            }
            $type_before = ProductRequest::$Type[$productRequest->type];
            $type_after = ProductRequest::$Type[$request->type];
            $note .= "<b>Type</b> From <b>" . $type_before . "</b> to <b>" . $type_after . "</b>";
            // $note .= "<b>Date</b> From <b>" . $productRequest->expected_date. "</b> to <b>".$request->expected_date."</b>";
        }
        if ($request->note ) {
            if ($note != '') {
                $note .= ' with a note, ';
            }
            $note .= "\"" . $request->note . "\"";
            // $note .= "<b>Date</b> From <b>" . $productRequest->expected_date. "</b> to <b>".$request->expected_date."</b>";
        }


        $productRequest->Update([
            // 'storage_id' => $request->storage_id,
            'request_quantity' => $request->request_quantity,
            'expected_date' => $request->expected_date,
            'type' => $request->type ?? 1,
            'is_closed' => 0,
            'outlet_id' => $request->requested_to ?? null,
            // 'user_id'     => Auth::user()->id
        ]);
        // return $productRequest;


        if ($productRequest) {
            $RequestResponse = RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 2,
                'note' =>  $note ?? null,
                'quantity' => $request->request_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $responce_outlet->storage->outlet_id,
            ]);
        }

        // return back();
        // return[
        //     '$productRequest'=>$productRequest,
        //     '$RequestResponse'=>$RequestResponse
        // ];

        return redirect()
            ->route('product-requests.index', $productRequest->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function close(Request $request, ProductRequest $productRequest)
    {
        // $productRequest->update($this->validateData($request, $productRequest->id));
        // $note = '';
        // $note .= 'Closed with the note of';


        $productRequest->Update([
            'is_closed' => 1,
            // 'user_id'     => Auth::user()->id
        ]);
        // return $productRequest;


        $responce_outlet = $productRequest->load('storage');

        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 5,
                'note' =>  $request->note ?? null,
                'quantity' => $request->request_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $responce_outlet->storage->outlet_id,
            ]);
        }
        $responce_outlet->update([
            'is_closed'=>1
        ]);

        return back();

        return redirect()
            ->route('collections.show', $productRequest->id)
            ->with('status', 'The record has been update successfully.');
    }
    public function accept_response(Request $request, ProductRequest $productRequest)
    {
        // $productRequest->update($this->validateData($request, $productRequest->id));
        // $note = '';
        // $note .= 'Closed with the note of';

        // $outlet = Storage::find($request->storage_id)->outlet;
        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 3,
                'note' =>  $request->note ?? null,
                'quantity' => $request->accept_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $request->from,
            ]);
        }

        return back();

        return redirect()
            ->route('collections.show', $productRequest->id)
            ->with('status', 'The record has been update successfully.');
    }
    public function deny_response(Request $request, ProductRequest $productRequest)
    {
        // $productRequest->update($this->validateData($request, $productRequest->id));
        // $note = '';
        // $note .= 'Closed with the note of';

        // $outlet = Storage::find($request->storage_id)->outlet;
        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 4,
                'note' =>  $request->note ?? null,
                'quantity' => 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $request->from,
            ]);
        }

        return back();

        return redirect()
            ->route('collections.show', $productRequest->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(ProductRequest $productRequest)
    {
        $productRequest->delete();

        return redirect()
            ->route('collections.index')
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
            'request_quantity' => ['required', 'numeric'],
            'expected_date' => ['required', 'date'],
            'outlet_id' => ['required', 'numeric']
        ]);
    }
}
