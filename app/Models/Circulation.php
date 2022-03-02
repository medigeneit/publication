<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circulation extends Model
{
    use HasFactory, SoftDeletes, ScopeSort, ScopeDateFilter;

    protected $guarded = [];

    const TYPE = [
        1   => "In",
        2   => "Out"
    ];

    public function scopeFilter($query)
    {
        return $query
            ->when(isset(request()->active), function ($query) {
                $query->where('storage_id', request()->active);
            });
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }



    public function destinationable()
    {
        return $this->morphTo();
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
            ->orWhereHas('storage.outlet', function ($query) use ($search_by_name) {
                $query
                    ->Where('name', 'regexp',   $search_by_name);
            });
    }
}
