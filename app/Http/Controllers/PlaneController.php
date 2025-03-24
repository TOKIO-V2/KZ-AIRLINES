<?php

namespace App\Http\Controllers;

use App\Models\planeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AirplaneController extends Controller
{
    public function store(Request $request)
    {
        $airplane = planeModel::create([
            "name" => $request->name,
            "max_capacity" => $request->max_capacity
        ]);

        return ($airplane);
    }

    public function create(Request $request)
    {
        if ($request->method() === "POST")
        {
            $this->store($request);
            return (Redirect::to(route("planes")));
        }
        return (view("admin.airplanes.airplanesCreate"));
    }

    public function update(Request $request, planeModel $plane)
    {
        $plane->update([
            "name" => $request->name,
            "max_capacity" => $request->max_capacity
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
        return ($plane);
    }

    public function edit(Request $request, string $id)
    {
        $plane = planeModel::find($id);

        if ($request->method() === "POST")
        {
            $this->update($request, $plane);
            return (Redirect::to(route("planes")));
        }
        return (view("admin.airplanes.airplanesEdit", compact("airplane")));
    }

    public function destroy(string $id)
    {
        planeModel::find($id)->delete();
    }

    public function index(Request $request)
    {
        $planes = planeModel::all();
        
        if ($request->action == "delete")
        {
            $this->destroy($request->id);
            return (Redirect::to(route("planes")));
        }
        return (view("admin.airplanes.airplanes", compact("airplanes")));
    }
}