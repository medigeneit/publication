<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty;

    public $timestamps = false;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 =>'Godown', 
            2 =>'Sale point'
        ];
    }

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
