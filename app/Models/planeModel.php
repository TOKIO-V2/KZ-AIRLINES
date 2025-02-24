<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class planeModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'max_capacity'
    ];

    public function flight()
    {
        return $this->hasMany(flightModel::class);
    }
}
