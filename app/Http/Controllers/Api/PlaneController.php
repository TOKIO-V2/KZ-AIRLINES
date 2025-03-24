<?php

namespace App\Http\Controllers;

use App\Models\planeModel;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    public function index()
    {
        return (response()->json(planeModel::All(), 200));
    }

    public function show(string $id)
    {
        return response()->json(planeModel::find($id), 200);
    }

    public function store(Request $request)
    {
        if ($request->maxPlaces < 0 || $request->maxPlaces > 200)
            return (response()->json(["message" => "Invalid parameters."], 400));
        $plane = planeModel::create([
            "name" => $request->name,
            "max_capacity" => $request->maxCapacity
        ]);
        
        return (response()->json($plane, 200));
    }

    public function update(Request $request, string $id)
    {
        $plane = planeModel::find($id);

        $plane->update([
            "name" => $request->name,
            "max_capacity" => $request->maxCapacity
        ]);
        foreach ($plane->flights as $flight)
        {
            if ($flight->available_places > $plane->max_capacity)
            {
                $flight->update([
                    "available_places" => $plane->max_capacity
                ]);
            }
        }
        return (response()->json($plane, 200));
    }

    public function destroy(string $id)
    {
        planeModel::find($id)->delete();
    }
}
