<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class flightModel extends Model
{
    use HasFactory;

    protected $table = 'flights';

    protected $fillable = [
        'date', 
        'origin', 
        'destination', 
        'plane_id', 
        'available_places',
        'reserved',
        'available'
    ];

    protected $casts = [
        'date' => 'datetime',
        'available_places' => 'unsignedInteger',
    ];

   
    public function plane(): BelongsTo
    {
        return $this->belongsTo(planeModel::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "flight_user");
    }
}
