<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;

Auth::routes();

Route::get('/flights/myFlights',[UserController::class, 'index'])->middleware('role:user')->name('userFlights');


Route::get('/', [FlightController::class, 'index'])->name('flights');
Route::get('/flights/past', [FlightController::class, 'pastFlights'])->name('pastFlights');
Route::get('/flights/create', [FlightController::class, 'create'])->middleware('role:admin')->name('createFlightForm');
Route::post('/flights/store', [FlightController::class, 'store'])->middleware('role:admin')->name('flightStore');
Route::get('/flights/{id}', [FlightController::class, 'edit'])->middleware('role:admin')->name('editFlightForm');
Route::post('/flights/update/{id}', [FlightController::class, 'update'])->middleware('role:admin')->name('flightUpdate');
Route::delete('/flights/destroy/{id}', [FlightController::class, 'destroy'])->middleware('role:admin')->name('flightDestroy');
Route::get('/flights/show/{id}',[FlightController::class, 'show'])->name('flightShow');
Route::get('/flights/{id}/reservations', [FlightController::class, 'getReservations'])->middleware('role:admin');


Route::get('/planes', [PlaneController::class, 'index'])->middleware('role:admin')->name('planes');
Route::get('/planes/create', [PlaneController::class, 'create'])->middleware('role:admin')->name('createPlaneForm');
Route::post('/planes/store', [PlaneController::class, 'store'])->middleware('role:admin')->name('planeStore');
Route::get('/planes/{id}', [PlaneController::class, 'edit'])->middleware('role:admin')->name('editPlaneForm');
Route::post('/planes/update/{id}', [PlaneController::class, 'update'])->middleware('role:admin')->name('planeUpdate');
Route::delete('/planes/destroy/{id}', [PlaneController::class, 'destroy'])->middleware('role:admin')->name('planeDestroy');
Route::get('/planes/show/{id}',[PlaneController::class, 'show'])->middleware('role:admin')->name('planeShow');