<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Tool\TypeTrait;

class Version extends Model
{
    use HasFactory, TypeProperty, ActiveProperty, ScopeDateFilter, ScopeSearch, ScopeSort;

    protected $guarded = [];

    const types = [
        1 => 'Book',
        2 => 'Lecture',
        3 => 'Volume',
    ];

    protected static function getTypes()
    {
        return self::types;
    }

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function ($query) {
                $query->where("active", request()->active);
            });
    }

    public function production()
    {
        return $this->belongsTo(Production::class);
    }


    public function volumes()
    {
        return $this->hasMany(Volume::class);
    }

    public function moderators()
    {
        return $this->hasMany(Moderator::class);
    }

    // public function moderators_types()
    // {
    //     return $this->hasMany(Moderator::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->morphMany(Product::class, 'productable');
    }

    public function printings()
    {
        return $this->hasMany(Printing::class);
    }
    public function last_printing()
    {
        return $this->hasOne(Printing::class)->orderBy('id','desc');
    }
}
