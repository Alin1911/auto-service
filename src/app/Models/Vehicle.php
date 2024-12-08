<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'chassis_series',
        'manufacture_year',
        'engine',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
