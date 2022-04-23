<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintingDetailsCategoryValueResource;
use App\Models\PrintingDetail;
use App\Models\PrintingDetailsCategoryValue;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintingDetailsCategoryValueController extends Controller
{
    use DateFilter;

    public function create()
    {
        return PrintingDetailsCategoryValue::where('id', request()->printing_details_category_key_id)->first() ?? [];

        return Inertia::render('VersionVariable/Create', [
            'printingDetailsCategoryValue'  => new PrintingDetailsCategoryValue(),
            'parent'    => PrintingDetailsCategoryValue::where('id', request()->printing_details_category_key_id)->first() ?? [],
        ]);
    }

    public function store(Request $request)
    {
        PrintingDetailsCategoryValue::create($this->validateData($request));
        return back();
    }


    public function edit($id)
    {
        // return PrintingDetailsCategoryValue::find($id);

        return Inertia::render('VersionVariable/Edit', [
            'printingDetailsCategoryValue' => PrintingDetailsCategoryValue::find($id),
            'parent'    => PrintingDetailsCategoryValue::where('id', request()->printing_details_category_key_id)->first() ?? [],
        ]);
    }

    public function update(Request $request, PrintingDetailsCategoryValue $printing_detail_category)
    {
        // return $printing_detail_category;

        $printing_detail_category->update($this->validateData($request, $printing_detail_category->id));

        // return back();

        return redirect()
            ->route('version-variables.index', $printing_detail_category->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy($id)
    {
        return 123;
        PrintingDetailsCategoryValue::find($id)->delete();
        return back();
    }


    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string'
            ],
            'printing_details_category_key_id' => [],
            'active' => []
        ]);
    }
}
