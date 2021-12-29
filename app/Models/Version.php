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
            // 1 => 'Package',
            1 => 'Book',
            2 => 'Lecture',
            3 => 'Volume',
        ];
    }

    public function package_products()
    {
        return $this->belongsToMany(Product::class, 'package_product', 'package_id', 'product_id')->whereNull('package_product.deleted_at');
    }
}
