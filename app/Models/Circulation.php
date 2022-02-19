<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Circulation extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE = [
        1   => "In",
        2   => "Out"
    ];
}
