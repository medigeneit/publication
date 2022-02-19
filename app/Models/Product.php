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

    // protected $appends = ['product_name'];

    const types = [
        1 => 'Package',
        2 => 'Book',
        3 => 'Lecture',
    ];


    protected static function getTypes()
    {
        return self::types;
    }

    public function getProductNameAttribute()
    {
        if ($this->productable_type == Version::class) {
            $vol_name = '(';
            foreach ($this->productable->volumes as $volume) {
                $vol_name = $vol_name . ($vol_name == '(' ? '' : '-') . $volume->name;
            }
            $vol_name = $vol_name . ')';

            return  $this->productable->production->name . ', ' . $this->productable->edition . ' edition' . ($vol_name!='()'?', Vol'.$vol_name:'') ?? 'Version';
        } elseif ($this->productable_type == Volume::class) {
            return $this->productable->version->production->name . ', ' .  $this->productable->version->edition . ' edition, Vol (' .  $this->productable->name . ')' ?? 'Volume';
        }
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
