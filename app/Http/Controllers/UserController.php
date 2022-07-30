<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\Models\Outlet;
use App\Models\User;
use App\Traits\ActiveFilter;
use App\Traits\ActiveTrait;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use DateFilter, ActiveFilter;

    // public function __construct()
    // {
    //     $this->middleware('can:Admin List')->only('index', 'show');
    //     $this->middleware('can:Admin Create')->only('create', 'store');
    //     $this->middleware('can:Admin Edit')->only('edit', 'update');
    //     $this->middleware('can:Admin Download')->only('exportExcel');
    //     $this->middleware('can:Admin Delete')->only('destroy');
    // }
    public function __construct()
    {
        $this->middleware('role:Super Admin|Administrator');
    }

    public function index()
    {
        // return in_array('Super Admin' , Auth::user()->roles->pluck('name')->toArray());
        $users = User::query()
            ->filter()
            ->dateFilter()
            ->search(['id', 'name', 'email', 'phone'], ['medical_college:name'])
            ->sort(request()->sort ?? 'created_at', request()->order ?? 'desc')
            ->isAdmin(1);


        return Inertia::render('User/Index', [
            'users' => UserResource::collection($users->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            "data" => [
                'user'      => new User(),
                'userType'  => User::getTypes(),
                'roles'     => Role::pluck('name', 'id'),
                'outlets'     => Outlet::pluck('name', 'id'),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $user = User::create($this->validateData($request) + [
            'password'  => Hash::make($request->password),
        ]);

        // $user->assignRole($user, $request->roles);

        $user->outlets()->sync($request->outlets);

        if (($request->roles == 1 && Auth::user()->hasRole('Super Admin')) || $request->roles != 1
        ) {
            $user->syncRoles($request->roles);
        }

        return redirect()
            ->route('users.show', $user->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(User $user)
    {
        // return
        $user->load('roles','outlets');
        UserResource::withoutWrapping();

        return Inertia::render('User/Show', [
            'user' => new UserResource($user),
        ]);
    }

    public function edit(User $user)
    {
        $user->load('roles:id','outlets:id');
        // $assignedRoles = [];
        // foreach ($user->roles as $key => $value) {
        //     $assignedRoles[] = (string) $value->id;
        // }
        // return $user->roles->pluck('id');
        // return $user->outlets->pluck('id');
        return Inertia::render('User/Edit', [
            "data" => [
                'user'          => $user,
                'userType'      => User::getTypes(),
                'roles'         => Role::pluck('name', 'id'),
                'outlets'         => Outlet::pluck('name', 'id'),
                // 'assignedRoles' => $assignedRoles,
                'assignedRoles' => $user->roles->pluck('id') ?? [],
                'assignedOutlets' => $user->outlets->pluck('id') ?? [],

            ]
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validateData($request, $user->id) + [
            'password'  => Hash::make($request->password),
        ]);

        // $user->outlets()->sync([1]);
        $user->outlets()->sync($request->outlets);

        // $user->assignRole($user,$request->roles);
        if (($request->roles == 1 && Auth::user()->hasRole('Super Admin')) || $request->roles != 1
        ) {
            $user->syncRoles($request->roles);
        }

        return redirect()
            ->route('users.show', $user->id)
            ->with('status', 'The record has been update successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()
            ->with('status', 'The record has been delete successfully.');
    }

    protected function search()
    {
        $this->getQuery()
            ->when(request()->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'regexp', $search)
                        ->orWhere('email', 'regexp', $search);
                });
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            'type' => User::getTypes(),
            'active' => User::getActiveProperties(),
        ];
    }

    private function validateData($request, $id = '')
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(User::class, 'email')->ignore($id),
            ],
            'phone' => [
                'required',
                'string',
                Rule::unique(User::class, 'phone')->ignore($id),
            ],
            // 'password' => [
            //     'required',
            //     'string',
            //     Rule::unique(User::class, 'password')->ignore($id),
            // ],
            'type' => [
                'required',
                'numeric',
            ],
            'active' => ['required'],
        ]);
    }
    private function assignRole($admin, $role)
    {
        return $admin;
        if (($role == 1 && Auth::user()->hasRole('Super Admin')) || $role != 1) {
            $admin->syncRoles($role);
        }
    }

}
