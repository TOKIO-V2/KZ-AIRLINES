<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\planeModel;
use App\Models\flightModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    public function index()
    {
        return (response()->json(flightModel::All(), 200));
    }

    public function show(string $id)
    {
        return (response()->json(flightModel::find($id), 200));
    }

    public function store(Request $request)
    {
        $airplane = planeModel::find($request->airplaneId);
        $places = $request->availablePlaces;
        $reserved = $request->reserved;

        if ($request->availablePlaces > $airplane->max_places)
        {
            $places = $airplane->max_places;
        }
        if (new DateTime($request->date) < now())
        {
            $status = 0;
        }
        $flight = flightModel::create([
            "date" => $request->date,
            "origin" => $request->origin,
            "destination" => $request->destination,
            "plane_id" => $request->planeId,
            "available_places" => $places,
            "reserved" => $request->reserved
        ]);
        return (response()->json($flight, 200));
    }

    public function update(Request $request, string $id)
    {
        $flight = flightModel::find($id);
        $places = $request->availablePlaces;

        if ($request->availablePlaces > $flight->airplane->max_places)
        {
            $places = $flight->airplane->max_places;
        }
        if (new DateTime($request->date) < now())
        {
            $status = 0;
        }
        $flight->update([
            "date" => $request->date,
            "origin" => $request->origin,
            "destination" => $request->destination,
            "plane_id" => $request->planeId,
            "available_places" => $places,
            "reserved" => $request->reserved
        ]);
        return (response()->json($flight, 200));
    }

    public function destroy(string $id)
    {
        flightModel::find($id)->delete();
    }
}