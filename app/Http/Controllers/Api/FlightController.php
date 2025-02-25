<?php

namespace App\Http\Controllers;

use App\Models\flightModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    // Mostrar lista de vuelos disponibles
    public function index()
    {
        $flights = flightModel::where('is_available', true)
            ->where('departure_time', '>', now())
            ->orderBy('departure_time', 'asc')
            ->get();

        return view('flights.index', compact('flights'));
    }

    // Mostrar lista de vuelos pasados
    public function pastFlights()
    {
        $flights = flightModel::where('departure_time', '<', now())
            ->orderBy('departure_time', 'desc')
            ->get();

        return view('flights.past', compact('flights'));
    }

    // Mostrar formulario de creación de vuelo
    public function create()
    {
        return view('flights.create');
    }

    // Guardar un nuevo vuelo
    public function store(Request $request)
    {
        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
        ]);

        flightModel::create([
            'departure_time' => $request->departure_time,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'plane_id' => $request->plane_id,
            'is_available' => true,
        ]);

        return redirect()->route('flights.index')->with('success', 'Vuelo creado correctamente.');
    }

    public function show($id)
    {
        $flight = flightModel::findOrFail($id);
        return view('flights.show', compact('flight'));
    }

    public function edit($id)
    {
        $flight = flightModel::findOrFail($id);
        return view('flights.edit', compact('flight'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'plane_id' => 'required|exists:planes,id',
        ]);

        $flight = flightModel::findOrFail($id);
        $flight->update($request->all());

        return redirect()->route('flights.index')->with('success', 'Vuelo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $flight = flightModel::findOrFail($id);
        $flight->delete();

        return redirect()->route('flights.index')->with('success', 'Vuelo eliminado correctamente.');
    }
}