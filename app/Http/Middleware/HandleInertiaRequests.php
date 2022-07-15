<?php

namespace App\Http\Middleware;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $roles =  $request->user()->getRoleNames()->toArray();

        $outlets = in_array("Super Admin", $roles) ? Outlet::pluck('name', 'id') : $request->user()->outlets->pluck('name', 'id');

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'outlet_id' => $outlets->keys()->first(),
            'request' => $request,
            'permissions' => auth()->user()
                ? json_encode($request->user()->allPermissions, true)
                : [],
        ]);
    }
}
