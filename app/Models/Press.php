<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Press extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function circulations()
    {
        return $this->morphMany(Circulation::class, 'destinationable');
    }
}
