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
    use HasFactory, TypeProperty, ActiveProperty,ScopeDateFilter,ScopeSearch,ScopeSort;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 => 'Package',
            2 => 'Book',
            3 => 'Lecture',
        ];
    }
}
