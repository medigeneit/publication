<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenesisCustomerInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function sale(Type $var = null)
    {
        return $this->belongsTo(Sale::class);
    }

}
