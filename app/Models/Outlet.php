<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outlet extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function accounts()
    {
        return $this->morphMany('App\Account', 'accountable');
    }
}
