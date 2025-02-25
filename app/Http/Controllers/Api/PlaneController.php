<?php

namespace App\Http\Controllers\Api;

use App\Models\planeModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaneController extends Controller
{
    public function index()
    {
        return planeModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'max_capacity' => 'required|integer',
        ]);

        return planeModel::create($request->all());
    }

    public function show(planeModel $plane)
    {
        return $plane;
    }

    public function update(Request $request, planeModel $plane)
    {
        $plane->update($request->all());
        return $plane;
    }

    public function destroy(planeModel $plane)
    {
        $plane->delete();
        return response()->noContent();
    }
}
