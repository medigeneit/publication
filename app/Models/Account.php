<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes, TypeProperty, ScopeDateFilter, ScopeSearch, ScopeSort;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 => 'Income',
            2 => 'Expense',
        ];
    }

    public function scopeFilter($query)
    {
        return $query;
            // ->when(isset(request()->active), function($query) {
            //     $query->where('active', request()->active);
            // });
    }

    public function accountable()
    {
        return $this->morphTo();
    }

    public function scopeOnlyPublisher($query)
    {
        return $query->where('accountable_type', 'App\Models\Publisher');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'accountable_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
