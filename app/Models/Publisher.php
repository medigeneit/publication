<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function accounts()
    {
        return $this->morphMany(Account::class, 'accountable');
    }

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
