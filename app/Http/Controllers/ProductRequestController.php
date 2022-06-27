<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductRequestResource;
use App\Models\Circulation;
use App\Models\ProductRequest;
use App\Traits\DateFilter;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductRequestController extends Controller
{
    use DateFilter;

    public function index()
    {

        $productRequests = $this->setQuery(ProductRequest::query()
            ->with('storage.outlet'))
            ->search()->filter()
            ->getQuery();

        // return $productRequests->get();
        return Inertia::render('ProductRequest/Index', [
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
        $productRequest = ProductRequest::insert([
            'storage_id' => $request->storage_id,
            'request_quantity' => $request->request_quantity,
            'expected_date' => $request->expected_date,
            'user_id'     => Auth::user()->id
        ]);

        return back();

        return redirect()
            ->route('collections.show', $productRequest->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(ProductRequest $productRequest)
    {
        // return 
        $productRequestShow = ProductRequest::query()
            ->with(['storage.outlet', 'storage.user:id,name', 'circulations.storage.outlet', 'circulations.destinationable', 'circulations.storage.product.productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with('version.production');
                    },
                    Version::class => function ($query) {
                        $query->with('volumes', 'production');
                    },
                    Circulation::class => function ($query, $productRequest) {
                        $query->where('requestable_id', $productRequest->id);
                    }
                ]);
            }])
            ->find($productRequest->id);

        // return  $productRequestShow->;

        ProductRequestResource::withoutWrapping();

        return Inertia::render('ProductRequest/Show', [
            'productRequest' => new ProductRequestResource($productRequestShow),
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
        $productRequest->update($this->validateData($request, $productRequest->id));

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
