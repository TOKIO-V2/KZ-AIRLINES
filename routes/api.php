<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlaneController;
use App\Http\Controllers\Api\FlightController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [FlightController::class, 'index'])->name('flightsIndex');
Route::get('/flights/past', [FlightController::class, 'pastFlights'])->name('flightsPast');
Route::get('/flights/{id}', [FlightController::class, 'show'])->name('flightsShow');
Route::middleware(['auth', 'role:admin'])->group(function () {
Route::get('/flights/create', [FlightController::class, 'create'])->name('flightsCreate');
Route::post('/flights/store', [FlightController::class, 'store'])->name('flightsStore');
Route::get('/flights/{id}/edit', [FlightController::class, 'edit'])->name('flightsEdit');
Route::put('/flights/update/{id}', [FlightController::class, 'update'])->name('flightsUpdate');
Route::delete('/flights/destroy/{id}', [FlightController::class, 'destroy'])->name('flightsDestroy');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/planes', [PlaneController::class, 'index'])->name('planesIndex');
    Route::get('/planes/create', [PlaneController::class, 'create'])->name('planesCreate');
    Route::post('/planes/store', [PlaneController::class, 'store'])->name('planesStore');
    Route::get('/planes/{id}', [PlaneController::class, 'show'])->name('planesShow');
    Route::get('/planes/{id}/edit', [PlaneController::class, 'edit'])->name('planesEdit');
    Route::put('/planes/update/{id}', [PlaneController::class, 'update'])->name('planesUpdate');
    Route::delete('/planes/destroy/{id}', [PlaneController::class, 'destroy'])->name('planesDestroy');
});