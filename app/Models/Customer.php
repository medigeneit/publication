<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, Timestamp;

    protected $guarded = [];

    public function address()
    {
        return $this->hasOne(AddressesOf::class, 'customer_id');
    }

    public function genesis_info()
    {
        // if ($this->memo_type == 3)
        return $this->hasOne(GenesisCustomerInfo::class, 'customer_id');
    }
}
