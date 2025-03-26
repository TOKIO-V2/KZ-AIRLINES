<?php

namespace App\Http\Controllers;

use App\Models\Plane;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->action === 'delete') {
            $this->destroy($request->id);
            return redirect()->route('planes');
        }

        $planes = Plane::All();

        return view('planes.planes', compact('planes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if( Auth::user()->Admin=true){

            return view('planes.createPlaneForm');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plane = Plane::create([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity,
        ]);
        $plane->save();

        return redirect()->route('planes');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plane = Plane::findOrFail($id);
        return view('planes.planeShow', compact('plane'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if( Auth::user()->Admin=true){

            $plane = Plane::find($id);
            return view('planes.editPlaneForm', compact('plane'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plane = Plane::find($id);

        $plane->update([
            'name' => $request->name,
            'max_capacity' => $request->max_capacity,
        ]);

        $plane->save();
        return redirect()->route('planes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if( Auth::user()->Admin=true){

            $plane = Plane::find($id);
            $plane->delete();

        }
    }

    
}