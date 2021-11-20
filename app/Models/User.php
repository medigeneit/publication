<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\TypeProperty;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, ActiveProperty, TypeProperty;

    protected $guarded = [];

    protected static function getTypes(){
        return [
            1 => 'Admin',
            2 => 'User',
        ];
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['email_verified'];

    public function getEmailVerifiedAttribute()
    {
        return $this->email_verified_at
            ? $this->email_verified_at->diffForHumans()
            : '';
    }
}
