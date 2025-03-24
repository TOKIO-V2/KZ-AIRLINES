<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\BookingAllowed;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\AirplaneController;

Route::get('/', [FlightController::class, "index"])->name("index");
Route::get('/search', [FlightController::class, "search"])->name("search");
Route::get("/flight/{id}", [FlightController::class, "show"])->name("show")->middleware(BookingAllowed::class.":index");

Auth::routes();

Route::get("/flights", [FlightController::class, "flights"])->middleware("auth", Admin::class.":web")->name("flights");
Route::get("/flights/create", [FlightController::class, "create"])->middleware("auth", Admin::class.":web")->name("flightsCreate");
Route::post("/flights/create", [FlightController::class, "create"])->middleware("auth", Admin::class.":web")->name("flightsCreate");
Route::get("/flights/{id}/edit", [FlightController::class, "edit"])->middleware("auth", Admin::class.":web")->name("flightsEdit");
Route::post("/flights/{id}/edit", [FlightController::class, "edit"])->middleware("auth", Admin::class.":web")->name("flightsEdit");

Route::get("/users", [UserController::class, "users"])->middleware("auth", Admin::class.":web")->name("users");
Route::get("/user/bookings", [UserController::class, "bookings"])->middleware(BookingAllowed::class.":index")->name("userBookings");

Route::get("/planes", [AirplaneController::class, "index"])->middleware("auth", Admin::class.":web")->name("planes");
Route::get("/planes/create", [AirplaneController::class, "create"])->middleware("auth", Admin::class.":web")->name("planesCreate");
Route::post("/planes/create", [AirplaneController::class, "create"])->middleware("auth", Admin::class.":web")->name("planesCreate");
Route::get("/planes/{id}/edit", [AirplaneController::class, "edit"])->middleware("auth", Admin::class.":web")->name("planesEdit");
Route::post("/planes/{id}/edit", [AirplaneController::class, "edit"])->middleware("auth", Admin::class.":web")->name("planesEdit");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware("auth", Admin::class.":web")->name('home');
