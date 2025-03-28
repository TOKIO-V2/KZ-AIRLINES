@extends('layouts.app2')

@section('content')
    <div class="body">

        <div class="flights-container">
            <h2 class="table-title">Flights List</h2>
            @foreach ($flights as $flight)
                <div class="flight-card" id="{{ $flight->id }}">
                    <div class="flight-row">
                        <div class="flight-origin">
                            {{ $flight->origin }}
                        </div>
                        <div class="flight-destination">
                            {{ $flight->destination }}
                        </div>
                        <div class="flight-date">
                            {{ $flight->date }}
                        </div>
                        <div class="flight-seats">
                            seats: {{ $flight->reserved }}/{{ $flight->plane->max_capacity }}
                        </div>
                        <div class="flight-price">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="reservationModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeReservationModal()">&times;</span>
            <h2>Reserved Users</h2>
            <table id="reservationTable">
                <thead>
                    <tr>
                        <th>User's ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Aquí puedes añadir los datos de los usuarios reservados --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection