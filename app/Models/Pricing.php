<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    public function product()
    {
        $this->belongsTo(Product::class);
    }

    public function price_categroy()
    {
        $this->belongsTo(PriceCategory::class, 'price_category_id');
    }
}
