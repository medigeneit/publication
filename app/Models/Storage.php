<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use tidy;

class Storage extends Model
{
    use HasFactory, SoftDeletes, ScopeDateFilter, ScopeSort;

    protected $guarded = [];

    // public $timestamps = false;

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function ($query) {
                $query->where('active', request()->active);
            });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // public function getQuantityAttribute()
    // {
    //     return $this->quantity == NULL ? 0 : $this->quantity;
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
                    ->whereHas('product', function ($query) use ($search_by_name, $search_by_edition, $search_by_vol) {
                        $query
                            ->where(function ($query) use ($search_by_name) {
                                $query
                                    ->whereHasMorph('productable', Version::class, function ($query) use ($search_by_name) {
                                        $query
                                            ->whereHas('production', function ($query) use ($search_by_name) {
                                                $query->where('name', 'like', "%{$search_by_name}%");
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
                    ->orWhereHas('outlet', function ($query) use ($search_by_name) {
                        $query
                            ->Where('name', 'regexp',   $search_by_name);
                    });
            });
    }

    public function circulations()
    {
        return $this->hasMany(Circulation::class);
    }

    public function productRequests()
    {
        return $this->hasMany(ProductRequest::class, 'storage_id', 'id');
    }
}
