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

class Product extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty, ScopeDateFilter, ScopeSearch, ScopeSort;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 => 'Package',
            2 => 'Book',
            3 => 'Lecture',
        ];
    }

    public function scopeFilter($query)
    {
        return $query
            ->when(request()->type, function ($query) {
                $query->where('type', request()->type);
            })
            ->when(isset(request()->active), function ($query) {
                $query->where('active', request()->active);
            });
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    public function category_product()
    {
        return $this->hasOne(CategoryProduct::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id')
            ->whereNull('category_products.deleted_at');
    }

    public function package_products()
    {
        return $this->belongsToMany(Product::class, 'package_product', 'package_id', 'product_id')->whereNull('package_product.deleted_at');
    }

    public function price_categories()
    {
        return $this->belongsToMany(PriceCategory::class, 'pricings', 'product_id', 'price_category_id');
    }

    public function prices()
    {
        return $this->hasMany(Pricing::class, 'product_id', 'id');
    }

    public function productable()
    {
        return $this->morphTo();
    }

    

}
