<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function getCostAttribute()
    {

        switch ($this->name) {
            case 'ITP':
                return 150;
            case 'Reparații':
                return 300;
            default:
                return 100;
        }
    }
}
