<?php

namespace App\Http\Controllers;

use App\Models\flightModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function index()
    {
        $flights = flightModel::with('plane')->get();
        return response()->json($flights);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Crear el vuelo
        $flight = flightModel::create([
            'departure_time' => $request->departure_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'is_available' => true,
        ]);

        return response()->json($flight, 201);
    }


    public function show($id)
    {
        $flight = flightModel::with('plane')->find($id);

        if (!$flight) {
            return response()->json(['error' => 'Vuelo no encontrado'], 404);
        }

        return response()->json($flight);
    }

    public function update(Request $request, $id)
    {
        $flight = flightModel::find($id);

        if (!$flight) {
            return response()->json(['error' => 'Vuelo no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'departure_time' => 'sometimes|date',
            'origin' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'plane_id' => 'sometimes|exists:planes,id',
            'is_available' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $flight->update($request->all());

        return response()->json($flight);
    }

    public function destroy($id)
    {
        $flight = flightModel::find($id);

        if (!$flight) {
            return response()->json(['error' => 'Vuelo no encontrado'], 404);
        }

        $flight->delete();

        return response()->json(null, 204);
    }
}
