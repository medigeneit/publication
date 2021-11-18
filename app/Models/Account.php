<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function accountable()
    {
        return $this->morphTo();
    }

    public function scopeOnlyPublisher($query)
    {
        return $query->where('accountable_type', 'App\Models\Publisher');
    }
}
