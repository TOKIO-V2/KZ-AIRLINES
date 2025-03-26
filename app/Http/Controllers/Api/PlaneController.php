<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plane;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    public function index()
    {
        $planes = Plane::all();

        return response()->json($planes, 200);
    }

    public function store(Request $request)
    {
        $plane = Plane::create([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity
        ]);

        $plane->save();

        return response()->json($plane, 200);
    }
    public function show(string $id)
    {
        $plane = Plane::findOrFail($id);

        return response()->json($plane, 200);
    }

    public function update(Request $request, string $id)
    {
        $plane = Plane::findOrFail($id);

        $plane->update([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity
        ]);
        
        $plane->save();

        return response()->json($plane, 200);
    }

    public function destroy(string $id)
    {
        $plane = Plane::findOrFail($id);
        $plane->delete();
    }
}
