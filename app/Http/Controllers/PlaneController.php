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

        return view('planes.plane', compact('planes'));
    }

    public function destroy(string $id)
    {
        if( Auth::user()->Admin=true){

            $plane = Plane::find($id);
            $plane->delete();

        }
    }

    
}