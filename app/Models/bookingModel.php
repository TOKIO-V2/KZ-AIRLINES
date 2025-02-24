<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bookingModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'flight_id'
    ];

    // Relación con el usuario (una reserva pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el vuelo (una reserva pertenece a un vuelo)
    public function flight()
    {
        return $this->belongsTo(flightModel::class);
    }
}
