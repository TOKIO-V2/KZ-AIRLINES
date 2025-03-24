<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\FlightController;
use App\Http\Controllers\Api\PlaneController;
use App\Http\Middleware\Admin;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::post("/planes", [PlaneController::class, "store"])->middleware(['auth:api', Admin::class.":api"])->name("apiairplanestore");
Route::get("/planes", [PlaneController::class, "index"])->middleware('auth:api')->name("apiairplaneindex");
Route::get("/planes/{id}", [PlaneController::class, "show"])->middleware('auth:api')->name("apiairplaneshow");
Route::put("/planes/{id}", [PlaneController::class, "update"])->middleware(['auth:api', Admin::class.":api"])->name("apiplaneupdate");
Route::delete("/planes/{id}", [PlaneController::class, "destroy"])->middleware(['auth:api', Admin::class.":api"])->name("apiplanedestroy");

Route::post("/flights", [FlightController::class, "store"])->middleware(['auth:api', Admin::class.":api"])->name("flightstore");
Route::get("/flights", [FlightController::class, "index"])->middleware('auth:api')->name("apiflightindex");
Route::get("/flights/{id}", [FlightController::class, "show"])->middleware('auth:api')->name("apiflightshow");
Route::put("/flights/{id}", [FlightController::class, "update"])->middleware(['auth:api', Admin::class.":api"])->name("flightupdate");
Route::delete("/flights/{id}", [FlightController::class, "destroy"])->middleware(['auth:api', Admin::class.":api"])->name("flightdestroy");