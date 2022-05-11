<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequest extends Model
{ 
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guraded = [];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
    public function circulations()
    {
        return $this->morphMany(Circulation::class,'requestable');
    }
}
