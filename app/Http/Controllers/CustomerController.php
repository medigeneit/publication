<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CustomerController extends Controller
{
    use DateFilter;

    public function index()
    {
        $customers = $this->setQuery(Customer::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Customer/Index', [
            'customers' => CustomerResource::collection($customers->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Customer/Create', [
            'customer' => new Customer(),
        ]);
    }

    public function store(Request $request)
    {
        $customer = Customer::create($this->validateData($request));

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Customer $customer)
    {
        CustomerResource::withoutWrapping();

        return Inertia::render('Customer/Show', [
            'customer' => new CustomerResource($customer),
        ]);
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($this->validateData($request, $customer->id));

        return redirect()
            ->route('customers.show', $customer->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
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

    public function customer_list(Request $request)
    {
        if ($request->memo_type == 3) {
            # code...22107001
            return Http::get('https://api.genesisedu.info/publication/doctor-course-info?reg_no='. $request->text);
        }

        return 
        Customer::query()
        ->when($request->text, function($query) use($request) {
            $query->where('phone', 'regexp', $request->text);
        })
        ->get();
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
