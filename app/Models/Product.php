<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static $type = [
        1 => 'Package',
        2 => 'Book',
        3 => 'Lecture',
    ];

    protected static function getTypes(){
        return [
            1 => 'Package',
            2 => 'Book',
            3 => 'Lecture',
        ];
    }


    public function getTypeNameAttribute()
    {
        return (Self::$type)[$this->type] ?? '';
    }

    public function publisher() 
    {
        return $this->belongsTo(Publisher::class);
    }
}
