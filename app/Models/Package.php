<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, ScopeSort, ScopeSearch, ScopeDateFilter,SoftDeletes;
    protected $guarded = [];

    public function package_products() {
       return $this->hasMany(PackageProduct::class);
    }
    
}
