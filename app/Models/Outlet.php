<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty;

    public $timestamps = false;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function accounts()
    {
        return $this->morphMany('App\Account', 'accountable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
