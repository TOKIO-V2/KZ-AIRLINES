<?php

namespace App\Http\Controllers\Api;

use App\Models\flightModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    public function index()
    {
        $flights = flightModel::all();

        return response()->json($flights, 200);
    }

    public function store(Request $request)
    {
        $flight = flightModel::create([
            'date' => $request->date,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'reserved' => $request->reserved,
            'available' => $request->available
        ]);

        $flight->save();

        return response()->json($flight, 200);
    }
    public function show(string $id)
    {
        $flight = flightModel::findOrFail($id);

        return response()->json($flight, 200);
    }

    public function update(Request $request, string $id)
    {
        $flight = flightModel::findOrFail($id);

        $flight->update([
            'date' => $request->date,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'reserved' => $request->reserved,
            'available' => $request->available
        ]);
        
        $flight->save();

        return response()->json($flight, 200);
    }

    public function destroy(string $id)
    {
        $flight = flightModel::findOrFail($id);
        $flight->delete();
    }
}