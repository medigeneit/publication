<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestResponse extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];


    static $Status = [
        1 => 'Created',
        2 => 'Edited',
        3 => 'Accepted',
        4 => 'Denied',
        5 => 'Closed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
