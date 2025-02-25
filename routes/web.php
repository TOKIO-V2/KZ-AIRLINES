<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;

Auth::routes();


Route::get('/', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/past', [FlightController::class, 'pastFlights'])->name('flights.past');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flights.show');
Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/flights/create', [FlightController::class, 'create'])->name('flights.create');
Route::post('/flights/store', [FlightController::class, 'store'])->name('flights.store');
Route::get('/flights/{id}/edit', [FlightController::class, 'edit'])->name('flights.edit');
Route::put('/flights/update/{id}', [FlightController::class, 'update'])->name('flights.update');
Route::delete('/flights/destroy/{id}', [FlightController::class, 'destroy'])->name('flights.destroy');
});



