<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintingResource;
use App\Models\Author;
use App\Models\BindingType;
use App\Models\CostCategory;
use App\Models\Moderator;
use App\Models\ModeratorType;
use App\Models\Press;
use App\Models\Printing;
use App\Models\PrintingContributor;
use App\Models\PrintingDetail;
use App\Models\PrintingDetailsCategoryKey;
use App\Models\PrintingDetailsCategoryValue;
use App\Models\Version;
use App\Models\VersionCost;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Util\Printer;

class PrintingCostController extends Controller
{
    use DateFilter;

    public function index()
    {
        $printings = $this->setQuery(PrintingDetailsCategoryValue::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Printing/Index', [
            'printings' => PrintingResource::collection($printings->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function createWithVerion($version)
    {
        // return $version;
        $cost_categories =  CostCategory::where('active', 1)->pluck('name', 'id');
        $printing_details_category_keys = PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']);

        return Inertia::render('Printing/Create', [
            'printing'                         => new PrintingDetailsCategoryValue(),
            'printing_details_category_keys'   => $printing_details_category_keys,
            'costCategories'                   => $cost_categories,
            'presses'                          => Press::where('active', 1)->get(),
            'authors'                          => Author::pluck('name', 'id'),
            'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),
            'bindingTypes'                     => BindingType::get(),
            'version'                          => $version
        ]);
    }
    public function create()
    {
        // return BindingType::get();

        $cost_categories =  CostCategory::where('active', 1)->pluck('name', 'id');
        $printing_details_category_keys = PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']);

        return Inertia::render('Printing/Create', [
            'printing'                         => new PrintingDetailsCategoryValue(),
            'printing_details_category_keys'   => $printing_details_category_keys,
            'costCategories'                   => $cost_categories,
            'presses'                          => Press::where('active', 1)->get(),
            'authors'                          => Author::pluck('name', 'id'),
            'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),
            'bindingTypes'                     => BindingType::get()
        ]);
    }

    public function store(Request $request)
    {

        if ($request->key) {
            $keyId = PrintingDetailsCategoryKey::create([
                'name' => $request->key
            ]);
        }
        if (is_array($request->values)) {
            foreach ($request->values as $value) {
                if ($value != Null)
                    PrintingDetailsCategoryValue::create([
                        'name' => $value,
                        'printing_details_category_key_id' => $keyId->id
                    ]);
            }
        };

        if ($request->copy_quantity && $request->version_id && $request->press) {
            $printing =  Printing::create([
                'version_id' => $request->version_id,
                'press_id'   => $request->press,
                'copy_quantity' => $request->copy_quantity,
                'page_amount' => $request->page_amount,
                'order_date' => $request->order_date,
                'plate_stored_at' => $request->plate_stored_at,
                'alert_quantity'    => $request->alert_quantity,
            ]);


            $category_value_ids = collect($request->printing_details)->pluck('category_value_id');
            $temp = [];
            foreach ($category_value_ids as $value) {
                if ($value != Null) {
                    $temp[] = PrintingDetail::create([
                        'category_value_id' => $value,
                        'printing_id'   => $printing->id,
                    ]);
                }
            }

            foreach ($request->cost_details as $cost_detail) {
                if ($cost_detail != Null) {
                    VersionCost::create([
                        'cost_category_id'    => $cost_detail['cost_category_id'],
                        'quantity'            => $cost_detail['quantity'],
                        'rate'                => $cost_detail['rate'],
                        'subtotal'            => $cost_detail['subtotal'],
                        'printing_id'         => $printing->id,
                    ]);
                }
            }

            foreach ($request->contributors as $contributor) {
                if ($contributor != Null) {
                    PrintingContributor::create([
                        'printing_id' => $printing->id,
                        'author_id' => $contributor['author_id'],
                        'moderator_type_id' => $contributor['moderator_type_id']
                    ]);
                }
            }
        }



        return redirect()
            ->route('printing-costs.show', $printing->id,)
            ->with('status', 'The record has been added successfully.');

        // $printing = Printing::create($this->validateData($request));

        // return redirect()
        //     ->route('collections.show', $printing->id)
        //     ->with('status', 'The record has been added successfully.');
    }

    public function show($id)
    {
        // return
        $printing_cost = Printing::class::with([
            'plate_store:id,name',
            'press:id,name',
            'buinding_type',
            'version.production',
            'version_cost.cost_category',
            'print_details.printing_details_category_value.printing_category_keys:id,name',
            'printing_contributors.contributor:id,name',
            'printing_contributors.contribution:id,name'
        ])->find($id);

        PrintingResource::withoutWrapping();

        return Inertia::render('Printing/Show', [
            'printing_cost' => new PrintingResource($printing_cost),
        ]);
    }

    public function edit($id)
    {
        // return $printing_cost;
        // return  
        $printing = Printing::with([
            'press:id,name',
            'buinding_type',
            'version_cost',
            'printing_details:id,name,printing_details_category_key_id',
            'printing_contributors'
        ])->find($id);
        // return $printing->printing_details->printing_details_category_key_id;

        return Inertia::render('Printing/Edit', [
            'data' => [
                'printing'                         => $printing,
                'printing_details_category_keys'   => PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']),
                'costCategories'                   => CostCategory::where('active', 1)->pluck('name', 'id'),
                'presses'                          => Press::where('active', 1)->get(),
                'authors'                          => Author::pluck('name', 'id'),
                'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),
                'bindingTypes'                     => BindingType::get()

            ]
        ]);
    }




    public function update(Request $request, Printing $printingCost)
    {
        // return $request->alert_quentity;
        $printingCost->version_cost()->delete();
        $printingCost->print_details()->delete();
        $printingCost->printing_contributors()->delete();
        //  $printingCost->delete();

        if ($request->copy_quantity  && $request->press) {
            $printingCost->update([
                'press_id'          => $request->press,
                'copy_quantity'     => $request->copy_quantity,
                'page_amount'       => $request->page_amount,
                'order_date'        => $request->order_date,
                'plate_stored_at'   => $request->plate_stored_at,
                'binding_type_id'   => $request->binding_type_id,
                'alert_quantity'    => $request->alert_quantity,
            ]);
        }

        // return  collect($request->printing_details)->pluck('category_value_id');
        // return
        $category_value_ids = collect($request->printing_details)->pluck('category_value_id');

        $temp = [];
        foreach ($category_value_ids as $value) {
            if ($value != Null) {
                $temp[] = PrintingDetail::withTrashed()
                    ->updateOrCreate([
                        'printing_id'   => $printingCost->id,
                        'category_value_id' => $value,
                    ], [
                        'deleted_at' => NULL,
                    ]);
            }
        }


        foreach ($request->cost_details as $cost_detail) {
            if ($cost_detail != Null) {
                VersionCost::withTrashed()
                    ->updateOrCreate([
                        'cost_category_id'    => $cost_detail['cost_category_id'],
                        'printing_id'         => $printingCost->id,
                    ], [
                        'quantity'            => $cost_detail['quantity'],
                        'rate'                => $cost_detail['rate'],
                        'subtotal'            => $cost_detail['subtotal'],
                        'deleted_at' => NULL,
                    ]);
            }
        }

        foreach ($request->contributors as $contributor) {
            if ($contributor != Null && $contributor['author_id'] != null && $contributor['moderator_type_id'] != null) {
                PrintingContributor::withTrashed()
                    ->updateOrCreate([
                        'printing_id' => $printingCost->id,
                        'author_id' => $contributor['author_id'],
                        'moderator_type_id' => $contributor['moderator_type_id'],
                    ], [
                        'deleted_at' => NULL,
                    ]);
            }
        }

        return redirect()
            ->route('printing-costs.show', $printingCost->id,)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Printing $printing)
    {
        $printing->delete();

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
            'version_id'                  => [''],
            'press_id'                    => [''],
            'copy_quantity'               => [''],
            'page_amount'                 => [''],
            'plate_stored_at'             => [''],
            'order_date'                  => [''],
        ]);
    }
}
