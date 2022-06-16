<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
// use Spatie\Permission\Contracts\Permission;

class RoleController extends Controller
{
    use DateFilter;

    public function index()
    {
        $roles = Role::query();
        return Inertia::render('Role/Index', [
            'roles' => RoleResource::collection($roles->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Role/Create', [
            'role' => new Role(),    
            'permissions' => Permission::pluck('name', 'id')
        ]);
    }

    public function store(Request $request)
    {
        $role = Role::create($this->validateData($request));
        $role->syncPermissions($request->permissions);;

        return redirect()
            ->route('roles.show', $role->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(Role $role)
    {
        $role->load('permissions:name');
        
        RoleResource::withoutWrapping();

        return Inertia::render('Role/Show', [
            'role' => new RoleResource($role),
        ]);
    }

    public function edit(Role $role)
    {
        return Inertia::render('Role/Edit', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $role->update($this->validateData($request, $role->id));

        return redirect()
            ->route('roles.show', $role->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
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
            'name' => 'required'
        ]);
    }

}
