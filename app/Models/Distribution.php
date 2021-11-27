<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Distribution extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty;

    protected $guarded = [];

    protected static function getTypes(){
        return [
            1 => 'Online',
            2 => 'Inside Dhaka',
            3 => 'Outside Dhaka',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
