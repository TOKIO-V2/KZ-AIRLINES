@extends('layouts.app2')
@section('content')
    <div class="container-home">
        
            <div class="container-button">
                <a href="{{ Auth::check() && Auth::user()->isAdmin ? route('adminReservations') : route('flights') }}" class="btn-home">¡EMPEZAR!</a>
            </div>
        
    </div>
@endsection