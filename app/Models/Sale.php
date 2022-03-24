<?php

namespace App\Models;

use App\Traits\ScopeDateFilter;
use App\Traits\ScopeSearch;
use App\Traits\ScopeSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes, ScopeDateFilter, ScopeSearch, ScopeSort;

    protected $guarded = [];

    // protected $appends = ['paid','due'];

    public function scopeFilter($query)
    {
        return $query;
        // ->when(isset(request()->active), function($query) {
        //     $query->where('active', request()->active);
        // });
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genesis_info()
    {
        return $this->hasOne(GenesisCustomerInfo::class);
    }

    public function sale_details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    // public function getPaidAttribute()
    // {
    //     $paid_ammount = 0;
    //     foreach( $this->payments as $payment){
    //         $paid_ammount += $payment->amount;
    //     }
    //     return $paid_ammount;
    // }

    // public function getDueAttribute()
    // {
    //     return $this->payable - $this->payment_history;
    // }


}
