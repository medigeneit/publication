<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintingDetailsCategoryValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function printing_category_keys()
    {
        return $this->belongsTo(PrintingDetailsCategoryKey::class,'printing_details_category_key_id','id');
    }
}
