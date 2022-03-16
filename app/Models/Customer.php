<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes,Timestamp;

    protected $guarded = [];

    public function adress()
    {
        return $this->hasOne(AddressesOf::class,'customer_id');
    }
}
