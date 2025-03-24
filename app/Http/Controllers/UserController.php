<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    public function debook(User $user, string $id)
    {
        $flight = $user->flights()->where("plane_id", $id)->first();
    
        if ($flight->available_places === $flight->airplane->max_capacity
            || $flight->status === false || $flight->date < now())
        {
            return (Redirect::to(route("show", $flight->id)));
        }
        $user->flights()->detach($id);
        $flight->update([
            "available_places" => $flight->available_places + 1
        ]);
    }

    public function bookings(Request $request)
    {
        $user = Auth::user();

        if ($request->action == "debook" && $request->id)
        {
            $this->debook($user, $request->id);
            return Redirect::to(route("userBookings"));
        }
        return view("bookings", compact("user"));
    }

    public function users(Request $request)
    {
        $users = User::all();

        return (view("admin.users.users", compact("users")));
    }
}
