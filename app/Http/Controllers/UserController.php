<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function index()
    // {
    //     $userFlights = Auth::user()->flights()->where('date', '>=', now())->orderBy('date', 'desc')->get();

    //     $userPastFlights = Auth::user()->flights()->where('date', '<', now())->orderBy('date', 'desc')->get();

    //     return view('', compact('userFlights', 'userPastFlights'));
    // }
}