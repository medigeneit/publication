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
            'printingDetailCategory'  => new PrintingDetailsCategoryValue(),
            'parent'    => PrintingDetailsCategoryValue::where('id', request()->printing_details_category_key_id)->first() ?? [],
        ]);
    }

    public function store(Request $request)
    {
        return 123;
    }


    public function edit($id)
    {
        return 123;

        return Inertia::render('VersionVariable/ValueEdit', [
            'printingDetailsCategoryValue' => PrintingDetailsCategoryValue::find($id),
        ]);
    }

    public function update(Request $request, PrintingDetailsCategoryValue $printingDetailsCategoryValue)
    {
        // $printingDetailsCategoryValue->update($this->validateData($request, $printingDetailsCategoryValue->id));

        return redirect()
            ->route('collections.show', $printingDetailsCategoryValue->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy($id)
    {
        PrintingDetailsCategoryValue::find($id)->delete();
        return back();
    }


    private function validateData($request, $id = '')
    {
        return $request->validate([
            //
        ]);
    }
}
