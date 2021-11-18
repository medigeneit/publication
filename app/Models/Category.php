<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty;
    
    protected $guarded = [];
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
