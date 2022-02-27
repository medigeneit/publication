<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circulation extends Model
{
    use HasFactory, SoftDeletes, ScopeSort, ScopeSearch, ScopeDateFilter;

    protected $guarded = [];

    const TYPE = [
        1   => "In",
        2   => "Out"
    ];

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function($query) {
                $query->where('storage_id', request()->active);
            });
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

   

    public function destinationable()
    {
        return $this->morphTo();
    }
}
