<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->action === 'delete') {
            $this->destroy($request->id);
            return redirect()->route('flights');
        }

        $flights = Flight::where('date', '>=', now())->orderBy('date', 'desc')->get();

        return view('flights.flights', compact('flights'));
    }

    public function pastFlights(Request $request)
    {
        if ($request->action === 'delete') {
            $this->destroy($request->id);
            return redirect()->route('pastFlights');
        }

        $pastFlights = Flight::where('date', '<', now())->orderBy('date', 'desc')->get();

        foreach($pastFlights as $flight){
            $flight->update(
                [
                    "reserved" => $flight->plane->max_capacity 
                ]
            );
        }

        return view('flights.pastFlights', compact('pastFlights'));
    }

    public function store(Request $request)
    {
        $flights = Flight::create([
            'date' => $request->date,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'reserved' => $request->reserved,
            'available' => 1
        ]);
        $flights->save();

        return redirect()->route('flights');
    }

    public function show(Request $request, string $id)
    {
        $flights = Flight::find($id);
        $booked = count($flights->users()->where("user_id", Auth::id())->get());

        if ($request->action === "book" && !$booked)
        {
            $this->book($flights, Auth::id());
            return (Redirect::to(route("flightShow", $flights->id)));
        }
        if ($request->action == "unbook" && $booked)
        {
            $this->unbook($flights, Auth::id());
            return (Redirect::to(route("flightShow", $flights->id)));
        }
        return (view("flights.show", compact("flights", "booked")));
        
    }


    public function book(Flight $flight, int $userId)
    {
        if ($flight->reserved == $flight->plane->max_capacity)
        {
            return;
        }
        $flight->users()->attach($userId);
        $flight->update(
            [
                "reserved" => $flight->reserved + 1
            ]
        );
        if ($flight->reserved == $flight->plane->max_capacity && !$flight->available)
        {
            $flight->update(
                [
                    "available" => 1
                ]
            );
        }
    }

    public function unbook(Flight $flight, int $userId)
    {
        if ($flight->reserved == 0) {
            return;
        }

        $flight->users()->detach($userId);

        $flight->update([
            "reserved" => $flight->reserved - 1
        ]);

        if ($flight->available) {
            $flight->update([
                "available" => 1
            ]);
        }
    }

    public function getReservations($id)
    {
        
        // if (!Auth::check() || Auth::user()->admin) {
        //     abort(403, 'No autorizado');
        // }

        $flight = Flight::with('users')->findOrFail($id);

        $reservations = $flight->users->map(function($user) {
            return [
                'user_id'   => $user->id,
                'user_name' => $user->name,
                'user_email'=> $user->email,
            ];
        });

        return view ('users.reservations');
    }
}