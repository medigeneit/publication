<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty, ScopeDateFilter, ScopeSearch, ScopeSort;

    public $timestamps = false;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 =>'Godown', 
            2 =>'Sale point'
        ];
    }

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function($query) {
                $query->where('active', request()->active);
            });

    }

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
