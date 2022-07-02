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

        $outlets = in_array("Super Admin", $roles) ? Outlet::pluck('name','id') :Auth::user()->outlets->pluck('name','id');
        // return array_keys ($outlets->toArray());

        if(!$request->outlet_id){
            // return
            $request->outlet_id = $outlets->keys()->first();
        }

        elseif(!in_array($request->outlet_id, array_keys ($outlets->toArray()))){
            return [
                'message'=> 'You are not allowed',
                'success'=> false,
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
                'outlet',
                'responses.user',
                'responses.outlet',
                'circulations' => function ($query) {
                    $query->whereNull('circulation_id')->with('circulations');
                }
            ])
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
            'your_outlets' =>  in_array("Super Admin", $roles) ? Outlet::pluck('name','id') :Auth::user()->outlets->pluck('name','id'),
            'productRequests' => ProductRequestResource::collection($productRequests->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
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
        // return $request;
        $productRequest = ProductRequest::create([
            'storage_id' => $request->storage_id,
            'request_quantity' => $request->request_quantity,
            'expected_date' => $request->expected_date,
            'type' => $request->type ?? 1,
            'is_closed' => 0,
            'outlet_id' => $request->outlet_id ?? null,
            // 'user_id'     => Auth::user()->id
        ]);
        // return $productRequest;

        $outlet = Storage::find( $request->storage_id)->outlet;
        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 1,
                'note' => $request->note ?? null,
                'quantity' => $request->request_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $outlet->id ,
            ]);
        }

        return back();

        return redirect()
            ->route('collections.show', $productRequest->id)
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
        // $productRequest->update($this->validateData($request, $productRequest->id));
        $note = '';
        if($productRequest->request_quantity != $request->request_quantity ){
            $note .= "<b>Quantity</b> From <b>" . $productRequest->request_quantity. "</b> to <b>".$request->request_quantity."</b>";
        }
        if($productRequest->expected_date != $request->expected_date ){
            if($note ==''){
                $note .= ' and ';
            }
            $note .= "<b>Expected Date</b> From <b>" . $productRequest->expected_date. "</b> to <b>".$request->expected_date."</b>";
        }
        if($productRequest->outlet_id != $request->outlet_id ){
            if($note ==''){
                $note .= ' and ';
            }
            $note .= "<b>Date</b> From <b>" . $productRequest->expected_date. "</b> to <b>".$request->expected_date."</b>";
        }

        $productRequest->Update([
            // 'storage_id' => $request->storage_id,
            'request_quantity' => $request->request_quantity,
            'expected_date' => $request->expected_date,
            'type' => $request->type ?? 1,
            'is_closed' => 0,
            'outlet_id' => $request->outlet_id ?? null,
            // 'user_id'     => Auth::user()->id
        ]);
        // return $productRequest;


        $outlet = Storage::find( $request->storage_id)->outlet;
        if ($productRequest) {
            RequestResponse::create([
                'product_request_id' => $productRequest->id,
                'status' => 1,
                'note' => $request->note ?? null,
                'quantity' => $request->request_quantity ?? 0,
                'user_id' => Auth::user()->id,
                'outlet_id' =>  $outlet->id ,
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
