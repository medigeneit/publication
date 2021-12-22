<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\VersionResource;
use App\Models\Product;
use App\Models\Production;
use App\Models\Version;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VersionController extends Controller
{
    use DateFilter;

    public function index()
    {
        $versions = $this->setQuery(Version::query())
            ->search()->filter()
            //->dateFilter()
            ->getQuery();

        return Inertia::render('Version/Index', [
            'versions' => VersionResource::collection($versions->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Version/Create', [
            'version' => new Version(),
            'productionList' => Production::pluck('name', 'id'),
            'productList' => Product::pluck('name', 'id'),
            'versionType'  => Version::getTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $version = Version::create($this->validateData($request));

        return redirect()
            ->route('versions.show', $version->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Version $version)
    {
        VersionResource::withoutWrapping();

        return Inertia::render('Version/Show', [
            'version' => new VersionResource($version),
        ]);
    }

    public function edit(Version $version)
    {
        return Inertia::render('Version/Edit', [
            'version' => $version,
        ]);
    }

    public function update(Request $request, Version $version)
    {
        $version->update($this->validateData($request, $version->id));

        return redirect()
            ->route('versions.show', $version->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Version $version)
    {
        $version->delete();

        return redirect()
            ->route('versions.index')
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
