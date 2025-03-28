<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class myReservationsController extends Controller
{
    public function indexUser()
    {
        return view('users.reservations', compact('futureReservations', 'pastReservations'));
    }
}
