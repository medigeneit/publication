<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Moderator extends Model
{
    use HasFactory, SoftDeletes, ScopeSort, ScopeSearch, ScopeDateFilter;

    protected $guarded = [];

    static $name = false;

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function ($query) {
                $query->where('active', request()->active);
            });
    }

    // static $appends ['product_name'];
    // protected $appends = ['mentor_type_name','Contributor_name'];




    public function getMentorTypeNameAttribute()
    {
        return $this->contributions_type->name ?? '';
    }
    public function getContributorNameAttribute()
    {
        return $this->Contributor->name ?? '';
    }

    public function contributions_type()
    {
        return $this->belongsTo(ContributionType::class, 'contribution_type');
    }
    public function Contributor()
    {
        return $this->belongsTo(Contributor::class,);
    }
}
