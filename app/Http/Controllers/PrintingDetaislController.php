<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintingResource;
use App\Models\Author;
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

class PrintingDetaislController extends Controller
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
        $cost_categories =  CostCategory::where('active', 1)->pluck('name', 'id');
        $presses = Press::where('active', 1)->pluck('name', 'id');
        $printing_details_category_keys = PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']);

        return Inertia::render('Printing/Create', [
            'printing'                         => new PrintingDetailsCategoryValue(),
            'printing_details_category_keys'   => $printing_details_category_keys,
            'costCategories'                   => $cost_categories,
            'presses'                          => $presses,
            'authors'                          => Author::pluck('name', 'id'),
            'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),
            'version'                          => $version
        ]);
    }
    public function create()
    {
        $cost_categories =  CostCategory::where('active', 1)->pluck('name', 'id');
        $presses = Press::where('active', 1)->pluck('name', 'id');
        $printing_details_category_keys = PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']);

        return Inertia::render('Printing/Create', [
            'printing'                         => new PrintingDetailsCategoryValue(),
            'printing_details_category_keys'   => $printing_details_category_keys,
            'costCategories'                   => $cost_categories,
            'presses'                          => $presses,
            'authors'                          => Author::pluck('name', 'id'),
            'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),
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
            ]);


            if (is_array($request->category_value_id)) {
                foreach ($request->category_value_id as $value) {
                    if ($value != Null) {
                        $printing_details_id = PrintingDetail::create([
                            'category_value_id' => $value,
                            'printing_id'   => $printing->id,
                        ]);
                    }
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
                        'author_id' => $contributor['authorId'],
                        'moderator_type_id' => $contributor['moderatorType']
                    ]);
                }
            }
        }



        return back();

        // $printing = Printing::create($this->validateData($request));

        // return redirect()
        //     ->route('collections.show', $printing->id)
        //     ->with('status', 'The record has been added successfully.');
    }

    public function show(Printing $printing)
    {
        PrintingResource::withoutWrapping();

        return Inertia::render('Printing/Show', [
            'printing' => new PrintingResource($printing),
        ]);
    }

    public function edit($id)
    {
        // return
        $printing = Printing::with([
            'press:id,name',
            'buinding_type',
            'version_cost.cost_category',
            'printing_details:id,name,printing_details_category_key_id',
            'printing_contributors.contributor:id,name',
            'printing_contributors.contribution:id,name'
        ])->find($id);

        return Inertia::render('Printing/Edit', [
            'data' => [
                'printing'                         =>  $printing,
                'printing_details_category_keys'   =>  PrintingDetailsCategoryKey::with('values:id,name,printing_details_category_key_id')->get(['id', 'name']),
                'costCategories'                   => CostCategory::where('active', 1)->pluck('name', 'id'),
                'presses'                          => Press::where('active', 1)->pluck('name', 'id'),
                'authors'                          => Author::pluck('name', 'id'),
                'moderatorTypes'                   => ModeratorType::pluck('name', 'id'),

            ]
        ]);
    }




    public function update(Request $request, Printing $printing)
    {
        return 2134;
        $printing->update($this->validateData($request, $printing->id));

        return redirect()
            ->route('collections.show', $printing->id)
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
