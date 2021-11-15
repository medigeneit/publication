<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\DateFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    use DateFilter;

    public function index()
    {
        $users = $this->setQuery(User::query())
            ->search()->filter()
            ->dateFilter()
            ->getQuery();

        return Inertia::render('User/Index', [
            'users' => UserResource::collection($users->paginate(request()->perpage ?? 100)->onEachSide(1)->appends(request()->input())),
            'filters' => $this->getFilterProperty(),
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Create', [
            'user'      => new User(),
            'userType'  => User::$type,
        ]);
    }

    public function store(Request $request)
    {
        $user = User::create($this->validateData($request) + [
            'password'  => Hash::make(123456),
        ]);

        return redirect()
            ->route('users.show', $user->id)
            ->with('status', 'The record has been added successfully.');
    }

    public function show(User $user)
    {
        UserResource::withoutWrapping();

        return Inertia::render('User/Show', [
            'user' => new UserResource($user),
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'user'      => $user,
            'userType'  => User::$type,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validateData($request, $user->id));

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

    protected function filter()
    {
        $this->getQuery()
            ->when(isset(request()->type), function ($query) {
                $query->where('type', request()->type);
            });

        return $this;
    }

    protected function getFilterProperty()
    {
        return [
            'type' => User::$type,
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
            'type' => [
                'required',
                'numeric',
            ]
        ]);
    }
}
