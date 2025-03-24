<?php

namespace App\Http\Controllers;

use App\Models\flightModel;
use App\Models\planeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FlightController extends Controller
{
    public function index()
    {
        $flights = flightModel::where("status", "1")
                            ->where("date", ">=", now())
                            ->orderBy("date", "asc")->get();

        return (view("index", compact("flights")));
    }

    public function search(Request $request)
    {
        $departure = '%'.$request->departure.'%';
        $arrival = '%'.$request->arrival.'%';
        $date = '%'.$request->date.'%';

        if (!$request->departure && !$request->arrival && !$request->date)
        {
            return Redirect::to(route("index"));
        }
        $flights = flightModel::where("departure", "like", $departure)
                            ->where("arrival", "like", $arrival)
                            ->where("date", "like", $date)->get();

        return (view("search", compact("flights")));
    }

    public function book(flightModel $flight, int $userId)
    {
        if ($flight->available_places === 0 || $flight->status === false || $flight->date < now())
        {
            return (Redirect::to(route("show", $flight->id)));
        } 
        $flight->users()->attach($userId);
        $flight->update([
            "available_places" => $flight->available_places - 1
        ]);
    }

    public function debook(flightModel $flight, int $userId)
    {
        if ($flight->available_places === $flight->airplane->max_places 
            || $flight->status === false || $flight->date < now())
        {
            return (Redirect::to(route("show", $flight->id)));
        } 
        $flight->users()->detach($userId);
        $flight->update([
            "available_places" => $flight->available_places + 1
        ]);
    }

    public function show(Request $request, string $id)
    {
        $flight = flightModel::find($id);
        $isBooked = count($flight->users()->where("user_id", Auth::id())->get());

        if ($request->action === "book" && !$isBooked)
        {
            $this->book($flight, Auth::id());
            return (Redirect::to(route("show", $flight->id)));
        }
        if ($request->action == "debook" && $isBooked)
        {
            $this->debook($flight, Auth::id());
            return (Redirect::to(route("show", $flight->id)));
        }
        return (view("show", compact("flight", "isBooked")));
    }

    public function store(Request $request)
    {
        $airplane = planeModel::find($request->airplane);
        $flight = flightModel::create([
            "date" => $request->date,
            "origin" => $request->origin,
            "destination" => $request->destination,
            "plane_id" => $airplane->id,
            "available_places" => $airplane->max_capacity,
            "reserved" => $request->reserved
        ]);

        return ($flight);
    }

    public function create(Request $request)
    {
        $airplanes = planeModel::all();

        if ($request->method() === "POST")
        {
            $this->store($request);
            return (Redirect::to(route("flights")));
        }
        return (view("admin.flights.flightsCreate", compact("airplanes")));
    }

    public function update(Request $request, flightModel $flight)
    {
        $airplane = planeModel::find($request->airplane);

        $flight->update([
            "date" => $request->date,
            "origin" => $request->origin,
            "destination" => $request->destination,
            "plane_id" => $airplane->id,
            "available_places" => $airplane->max_capacity,
            "reserved" => $request->reserved
        ]);
        return ($flight);
    }

    public function edit(Request $request, string $id)
    {
        $flight = flightModel::find($id);
        $airplanes = planeModel::all();

        if ($request->method() === "POST")
        {
            $this->update($request, $flight);
            return (Redirect::to(route("flights")));
        }
        return (view("admin.flights.flightsEdit", compact("flight", "airplanes")));
    }

    public function destroy(string $id)
    {
        flightModel::find($id)->delete();
    }

    public function flights(Request $request)
    {
        $flights = flightModel::all();

        if ($request->action == "delete")
        {
            $this->destroy($request->id);
            return (Redirect::to("flights"));
        }
        return (view("admin.flights.flights", compact("flights")));
    }
}
