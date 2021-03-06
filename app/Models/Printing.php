<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printing extends Model
{
    use HasFactory, SoftDeletes, ScopeSearch, ScopeDateFilter;

    protected $guarded = [];

    protected $casts = [
        'order_date' => 'date',
    ];

    public function plate_store()
    {
        return $this->belongsTo(PrintingContributor::class);
    }
    public function scopeFilter($query) 
    {
        return $query
            ->when(request()->active, function($query) {
            $query->where('active',(request()->active ?? 1));
        });
    }

    public function press()
    {
        return $this->hasOne(Press::class, 'id', 'press_id');
    }
    public function stored_at()
    {
        return $this->belongsTo(Press::class, 'plate_stored_at', 'id');
    }
    public function buinding_type()
    {
        return $this->hasOne(BindingType::class, 'id', 'binding_type_id');
    }
    public function version_cost()
    {
        return $this->hasMany(VersionCost::class, 'printing_id', 'id');
    }
    public function printing_details()
    {
        return $this->belongsToMany(PrintingDetailsCategoryValue::class, 'printing_details', 'printing_id', 'category_value_id',)->whereNull('printing_details.deleted_at');
    }
    public function print_details()
    {
        return $this->hasMany(PrintingDetail::class);
    }

    public function printing_contributors()
    {
        return $this->hasMany(PrintingContributor::class, 'printing_id', 'id');
    }

    public function version()
    {
        return $this->belongsTo(Version::class);
    }
    public function circulations()
    {
        return $this->morphMany(Circulation::class,'requestable');
    }
}
