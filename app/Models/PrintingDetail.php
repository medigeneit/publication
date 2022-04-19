<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintingDetail extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function printing_details_category_value()
    {
        return $this->belongsTo(PrintingDetailsCategoryValue::class,'category_value_id','id');
    }
}
