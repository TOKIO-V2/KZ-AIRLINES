<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('home');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/flights/myFlights',[UserController::class, 'index'])->middleware('auth:web', Admin::class.':web')->name('userFlights');
Route::get('/flights', [FlightController::class, 'index'])->name('flights');
Route::get('/flights/past', [FlightController::class, 'pastFlights'])->name('pastFlights');
Route::get('/flights/create', [FlightController::class, 'create'])->middleware('auth:web', Admin::class.':web')->name('createFlightForm');
Route::post('/flights/store', [FlightController::class, 'store'])->middleware('auth:web', Admin::class.':web')->name('flightStore');
Route::get('/flights/{id}', [FlightController::class, 'edit'])->middleware('auth:web', Admin::class.':web')->name('editFlightForm');
Route::post('/flights/update/{id}', [FlightController::class, 'update'])->middleware('auth:web', Admin::class.':web')->name('flightUpdate');
Route::delete('/flights/destroy/{id}', [FlightController::class, 'destroy'])->middleware('auth:web', Admin::class.':web')->name('flightDestroy');
Route::get('/flights/show/{id}',[FlightController::class, 'show'])->name('flightShow');
Route::get('/flights/{id}/reservations', [FlightController::class, 'getReservations'])->middleware('auth:web', Admin::class.':web')->name('userReservations');


Route::get('/planes', [PlaneController::class, 'index'])->middleware('auth:web', Admin::class.':web')->name('planes');
Route::get('/planes/create', [PlaneController::class, 'create'])->middleware('auth:web', Admin::class.':web')->name('createPlaneForm');
Route::post('/planes/store', [PlaneController::class, 'store'])->middleware('auth:web', Admin::class.':web')->name('planeStore');
Route::get('/planes/{id}', [PlaneController::class, 'edit'])->middleware('auth:web', Admin::class.':web')->name('editPlaneForm');
Route::post('/planes/update/{id}', [PlaneController::class, 'update'])->middleware('auth:web', Admin::class.':web')->name('planeUpdate');
Route::delete('/planes/destroy/{id}', [PlaneController::class, 'destroy'])->middleware('auth:web', Admin::class.':web')->name('planeDestroy');
Route::get('/planes/show/{id}',[PlaneController::class, 'show'])->middleware('auth:web', Admin::class.':web')->name('planeShow');
