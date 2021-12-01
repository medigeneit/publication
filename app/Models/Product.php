<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty;

    protected $guarded = [];

    protected static function getTypes(){
        return [
            1 => 'Package',
            2 => 'Book',
            3 => 'Lecture',
        ];
    }

    public function publisher() 
    {
        return $this->belongsTo(Publisher::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    public function category_product()
    {
        return $this->hasOne(CategoryProduct::class, 'product_id');
    }
}
