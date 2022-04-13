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
use App\Models\PrintingDetailsCategoryKey;
use App\Models\PrintingDetailsCategoryValue;
use App\Models\Version;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use phpDocumentor\Reflection\Types\Null_;

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
        return $request->moderators;

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

    public function edit(Printing $printing)
    {
        return Inertia::render('Printing/Edit', [
            'printing' => $printing,
        ]);
    }

    public function update(Request $request, Printing $printing)
    {
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
            //
        ]);
    }
}
