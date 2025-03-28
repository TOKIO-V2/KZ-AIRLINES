@extends('layouts.app2')

@section('content')
    <div class="body">

        @if (Auth::check() && Auth::user()->Admin)
            <div class="addBtn" id="flightAdd">
                <a href="{{ route('createFlightForm') }}" class="crudBtn">
                    <img src="{{ asset('img/add.png') }}" alt="add-Button" class="add">
                </a>
            </div>
        @endif

        <div class="tableFlight">
            <h2 class="table-title">New Flights List</h2>
            <table class="table">
                <thead>
                    <tr>
                        @if (Auth::check() && Auth::user()->Admin)
                            <th>Id</th>
                            <th>Plane ID</th>
                        @endif
                        <th>Date</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Total Places</th>
                        <th>Places Reserved</th>
                        <th>Availability</th>
                        @if (Auth::check() && Auth::user()->Admin)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flights as $flight)
                        <tr class="row" id="{{ $flight->id }}">
                            @if (Auth::check() && Auth::user()->Admin)
                                <td>{{ $flight->id }}</td>
                                <td>{{ $flight->plane_id }}</td>
                            @endif
                            <td>{{ $flight->date }}</td>
                            <td>{{ $flight->origin }}</td>
                            <td>{{ $flight->destination }}</td>
                            <td>{{ $flight->plane->max_capacity }}</td>
                            <td>{{ $flight->reserved }}</td>
                            <td>{{ $flight->plane->max_capacity - $flight->reserved }}</td>
                            <td>
                                @if ($flight->reserved >= 0 && $flight->reserved < $flight->plane->max_capacity)
                                    <span class="active">Available</span>
                                @else
                                    <span class="inactive">Not Available</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

                </tbody>
            </table>
        </div>
    </div>
@endsection
