<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printing extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function storeBy()
    {
        return $this->hasOne(Author::class, 'id', 'plate_stored_at');
    }
}
