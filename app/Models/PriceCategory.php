<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceCategory extends Model
{
    use HasFactory, SoftDeletes, ScopeDateFilter, ScopeSearch, ScopeSort;

    protected $guarded = [];

    public function pricings()
    {
        return $this->hasMany(Pricing::class);
    }
    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function ($query) {
                $query->where("active", request()->active);
            });
    }
}
