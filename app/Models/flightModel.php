<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class flightModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'departure_time', 
        'origin', 
        'destination', 
        'plane_id', 
        'is_available'
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'is_available' => 'boolean',
    ];

    public function plane()
    {
        return $this->belongsTo(planeModel::class);
    }

    public function bookings()
    {
        return $this->hasMany(bookingModel::class);
    }

    public function hasAvailableSeats()
    {
        return $this->bookings->count() < $this->plane->max_seats;
    }
}
