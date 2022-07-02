<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use App\Traits\TypeProperty;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ActiveProperty, TypeProperty, ScopeDateFilter, ScopeSearch, ScopeSort, HasRoles;

    protected $guarded = [];


    public function getAllPermissionsAttribute()
    {
        $permissions = [];
        // return Auth::user()->givePermissionTo('Product List');
        foreach (Permission::all() as $permission) {
            if (Auth::user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }

        return $permissions;
    }
    public function getAllRolesAttribute()
    {
        $roles = [];
        foreach (Auth::user()->roles as $role) {
            $roles[] = $role->id;
        }
        return $roles;
    }

    protected static function getTypes(){
        return [
            1 => 'Admin',
            // 2 => 'User',
        ];
    }

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->type), function ($query) {
                $query->where('type', request()->type);
            })
            ->when(isset(request()->active), function ($query) {
                $query->where('active', request()->active);
            });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeIsAdmin($query, $value = 1)
    {
        return $query->where('type', $value);
    }

    protected $appends = ['email_verified'];

    public function getEmailVerifiedAttribute()
    {
        return $this->email_verified_at
            ? $this->email_verified_at->diffForHumans()
            : '';
    }

    public function outlets()
    {
        // return $this->hasManyThrough(Outlet::class,UserOutlet::class,'user_id','id','id','outlet_id');
        return $this->belongsToMany(Outlet::class,'user_outlets');
    }
}
