<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PrintingDetailsCategoryKeyResource;
use App\Models\PrintingDetailsCategoryKey;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrintingDetailsCategoryKeyController extends Controller
{
    use DateFilter;

    public function create()
    {
        return Inertia::render('PrintingDetailsCategoryKey/Create', [
            'printingDetailsCategoryKey' => new PrintingDetailsCategoryKey(),
        ]);
    }

    public function store(Request $request)
    {
        $printingDetailsCategoryKey = PrintingDetailsCategoryKey::create($this->validateData($request));

        return redirect()
            ->route('collections.show', $printingDetailsCategoryKey->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(PrintingDetailsCategoryKey $printingDetailsCategoryKey)
    {
        PrintingDetailsCategoryKeyResource::withoutWrapping();

        return Inertia::render('PrintingDetailsCategoryKey/Show', [
            'printingDetailsCategoryKey' => new PrintingDetailsCategoryKeyResource($printingDetailsCategoryKey),
        ]);
    }

    public function edit(PrintingDetailsCategoryKey $printingDetailsCategoryKey)
    {
        return Inertia::render('VersionVariable/KeyEdit', [
            'printingDetailsCategoryKey' => $printingDetailsCategoryKey,s
        ]);
    }

    public function update(Request $request, PrintingDetailsCategoryKey $printingDetailsCategoryKey)
    {
        $printingDetailsCategoryKey->update($this->validateData($request, $printingDetailsCategoryKey->id));

        return redirect()
            ->route('collections.show', $printingDetailsCategoryKey->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(PrintingDetailsCategoryKey $printingDetailsCategoryKey)
    {
        $printingDetailsCategoryKey->delete();

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
