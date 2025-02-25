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
        'is_available',
        'reserved'
    ];

    protected $casts = [
        'date' => 'date',
        'is_available' => 'boolean',
    ];

    protected $table = 'flight' ;

    protected $factory = 'flightFactory';

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
