<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintingDetailsCategoryKey extends Model
{
    use HasFactory,SoftDeletes;

    public function values()
    {
        return $this->hasMany(PrintingDetailsCategoryValue::class);
    }
}