<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRequest extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    // protected $guraded = [];
    protected $guarded = [];

    // protected $fillable = [
    //     'storage_id',
    //     'request_quantity',
    //     'expected_date',
    //     'type',
    // ];

    static $Type = [
        1 => 'Requested',
        2 => 'Asked to send'
    ];


    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
    public function circulations()
    {
        return $this->morphMany(Circulation::class,'requestable');
    }
    public function responses ()
    {
        return $this->hasMany(RequestResponse::class);
    }
}
