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

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->whereNull('category_product.deleted_at');
    }
}
