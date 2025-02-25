<?php

namespace App\Http\Controllers\Api;

use App\Models\flightModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function index()
    {
        $flights = flightModel::where('is_available', true)
            ->where('date', '>', now())
            ->orderBy('date', 'asc')
            ->get();

        return view('flightIndex', compact('flights'));
    }

    public function pastFlights()
    {
        $flights = flightModel::where('date', '<', now())
            ->orderBy('date', 'desc')
            ->get();

        return view('flightsPast', compact('flight'));
    }

    public function create()
    {
        return view('flightsCreate');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
        ]);

        flightModel::create([
            'date' => $request->departure_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'is_available' => true,
            'reservation' => 0
        ]);

        return redirect()->route('flightsIndex')->with('success', 'Vuelo creado correctamente.');
    }

    public function show($id)
    {
        $flight = flightModel::findOrFail($id);
        return view('flightsShow', compact('flight'));
    }

    public function edit($id)
    {
        $flight = flightModel::findOrFail($id);
        return view('flightsEdit', compact('flight'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
        ]);

        $flight = flightModel::findOrFail($id);
        $flight->update($request->all());

        return redirect()->route('flightsIndex')->with('success', 'Vuelo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $flight = flightModel::findOrFail($id);
        $flight->delete();

        return redirect()->route('flightsIndex')->with('success', 'Vuelo eliminado correctamente.');
    }
}