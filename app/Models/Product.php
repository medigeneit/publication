<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use App\Traits\TypeProperty;
use App\Traits\WithProductRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty, ScopeDateFilter, ScopeSort,WithProductRelations;

    protected $guarded = [];

    protected $appends = ['product_name'];

    const types = [
        1 => 'Package',
        2 => 'Book',
        3 => 'Lecture',
    ];


    protected static function getTypes()
    {
        return self::types;
    }

    public function scopeNameRelations($query)
    {
        return $query
            ->with(['productable' => function (MorphTo $morphTo) {
                $morphTo->constrain([
                    Volume::class => function ($query) {
                        $query->with([
                            'version.production',
                            // 'version.volumes:id,version_id',
                        ]);
                    },
                    Version::class => function ($query) {
                        $query->with([
                            'volumes',
                            'production'
                        ]);
                    },
                ]);
            }]);
    }

    // public function scopeWithMorphTo($query, $relation, array $constrains)
    // {
    //     $query->with($relation, function (MorphTo $morphTo) use ($constrains) {

    //         array_walk($constrains, function (&$constrain) {
    //             $constrain = function ($query) use ($constrain) {
    //                 $query->with($constrain);
    //             };
    //         });

    //         $morphTo->constrain($constrains);
    //     });

    // }

    public function getProductNameAttribute()
    {
        if ($this->productable_type == Version::class) {
            $vol_name = '(';
            foreach ($this->productable->volumes as $volume) {
                $vol_name = $vol_name . ($vol_name == '(' ? '' : '-') . $volume->name;
            }
            $vol_name = $vol_name . ')';

            return  $this->productable->production->name . ', ' . $this->productable->edition . ' edition' . ($vol_name != '()' ? ', Vol' . $vol_name : '') ?? 'Version';
        } elseif ($this->productable_type == Volume::class) {
            return $this->productable->version->production->name . ', ' .  $this->productable->version->edition . ' edition, Vol (' .  $this->productable->name . ')' ?? 'Volume';
        } elseif ($this->productable_type == Package::class) {
            return  $this->productable->name ?? 'Package';
        }
    }

    public function scopeSearch($query, $req_search)
    {

        $search = preg_replace('/ /', '%', $req_search);
        // return
        $search = $req_search ? explode(',', $search) : NULL;
        $search_by_name = $search[0] ?? '';
        $search_by_edition = $search[1] ?? '';
        $search_by_vol = $search[2] ?? '';

        return $query

            ->when($req_search, function ($query) use ($search_by_name, $search_by_edition, $search_by_vol) {
                $query
                    ->where(function ($query) use ($search_by_name, $search_by_edition, $search_by_vol) {
                        $query
                            ->where(function ($query) use ($search_by_name) {
                                $query
                                    ->whereHasMorph('productable', Version::class, function ($query) use ($search_by_name) {
                                        $query
                                            ->whereHas('production', function ($query) use ($search_by_name) {
                                                $query->where('name', 'like', "%{$search_by_name}%");
                                            })
                                            ->orWhereHas('production.publisher', function ($query) use ($search_by_name) {
                                                $query->where('name', 'like', "%{$search_by_name}%");
                                            })
                                            ->orWhereHas('moderators', function ($query) use ($search_by_name) {
                                                $query->WhereHas('author', function ($query) use ($search_by_name) {
                                                    $query->where('name', 'like', "%{$search_by_name}%");
                                                });
                                            });
                                    })
                                    ->orWhereHasMorph('productable', Volume::class, function ($query) use ($search_by_name) {
                                        $query->WhereHas('version.production', function ($query) use ($search_by_name) {
                                            $query->where('name', 'like', "%{$search_by_name}%");
                                        });
                                    });
                            })
                            ->where(function ($query) use ($search_by_edition) {
                                $query->whereHasMorph('productable', Version::class, function ($query) use ($search_by_edition) {
                                    $query
                                        ->Where('edition', 'regexp',   $search_by_edition);
                                })
                                    ->orWhereHasMorph('productable', Volume::class, function ($query) use ($search_by_edition) {
                                        $query
                                            ->WhereHas('version', function ($query) use ($search_by_edition) {
                                                $query->where('edition', 'regexp',   $search_by_edition);
                                            });
                                    });
                            })
                            ->when($search_by_vol != '', function ($query) use ($search_by_vol) {

                                $query->where(function ($query) use ($search_by_vol) {
                                    $query->whereHasMorph('productable', Version::class, function ($query) use ($search_by_vol) {
                                        $query
                                            ->whereHas('volumes', function ($query) use ($search_by_vol) {
                                                $query->where('name', 'like', "%{$search_by_vol}%");
                                            });
                                    })
                                        ->orWhereHasMorph('productable', Volume::class, function ($query) use ($search_by_vol) {
                                            $query
                                                ->Where('name', 'regexp',   $search_by_vol);
                                        });
                                });
                            });
                    })
                    ->orWhereHas('categories', function ($query) use ($search_by_name) {
                        $query
                            ->Where('name', 'regexp',   $search_by_name);
                    });
            });
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
        return $this->belongsToMany(PackageProduct::class, 'package_products', 'package_id', 'product_id')->whereNull('package_products.deleted_at');
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
