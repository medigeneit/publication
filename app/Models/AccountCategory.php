<?php

namespace App\Models;

use App\Traits\ActiveProperty;
use App\Traits\TypeProperty;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountCategory extends Model
{
    use HasFactory, SoftDeletes, ActiveProperty, TypeProperty;

    protected $guarded = [];

    protected static function getTypes()
    {
        return [
            1 => "Income",
            2 => "Expense"
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
