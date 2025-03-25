<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\planeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaneController extends Controller
{
    public function index()
    {
        $planes = planeModel::all();

        return response()->json($planes, 200);
    }

    public function store(Request $request)
    {
        $plane = planeModel::create([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity
        ]);

        $plane->save();

        return response()->json($plane, 200);
    }
    public function show(string $id)
    {
        $plane = planeModel::findOrFail($id);

        return response()->json($plane, 200);
    }

    public function update(Request $request, string $id)
    {
        $plane = planeModel::findOrFail($id);

        $plane->update([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity
        ]);
        
        $plane->save();

        return response()->json($plane, 200);
    }

    public function destroy(string $id)
    {
        $plane = planeModel::findOrFail($id);
        $plane->delete();
    }
}
