<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class flightModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 
        'origin', 
        'destination', 
        'plane_id', 
        'available_places',
        'reserved'
    ];

    protected $casts = [
        'date' => 'datetime',
        'avaible_places' => 'unsignedInteger',
    ];

    public function planes()
    {
        return $this->belongsTo(planeModel::class);
    }

    public function bookings()
    {
        return $this->hasMany(bookingModel::class);
    }

    public function hasAvailableSeats()
    {
        return $this->bookings->count() < $this->planes->max_capacity;
    }
}
