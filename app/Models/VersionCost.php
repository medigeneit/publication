<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VersionCost extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function cost_category()
    {
        return $this->belongsTo(CostCategory::class);
    }
}
