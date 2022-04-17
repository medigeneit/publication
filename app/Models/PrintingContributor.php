<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrintingContributor extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    public function contributor()
    {
        return $this->belongsTo(Author::class,'author_id','id');
    }
    public function contribution()
    {
        return $this->belongsTo(ModeratorType::class,'moderator_type_id','id');
    }
}
