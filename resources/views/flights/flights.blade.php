@extends('layouts.app2')

@section('content')
    <div class="body">

        @if (Auth::check() && Auth::user()->isAdmin)
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
                        @if (Auth::check() && Auth::user()->isAdmin)
                            <th>Id</th>
                            <th>Plane ID</th>
                        @endif
                        <th>Date</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Total Places</th>
                        <th>Places Reserved</th>
                        <th>Disponible Places</th>
                        <th>Availability</th>
                        @if (Auth::check() && Auth::user()->isAdmin)
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
                            <td>{{ $flight->departure }}</td>
                            <td>{{ $flight->arrival }}</td>
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
                            @if (Auth::check() && Auth::user()->isAdmin)
                                <td>
                                    <a href="#" class="crudBtn" data-flight-id="{{ $flight->id }}"
                                        onclick="event.stopPropagation(); openUserReservations({{ $flight->id }});">
                                        <img src="{{ asset('img/user.png') }}" alt="user-Button" class="crudBtn">
                                    </a>
                                    <a href="{{ route('editFlightForm', $flight->id) }}" class="crudBtn">
                                        <img src="{{ asset('img/edit.png') }}" alt="edit-Button" class="crudBtn">
                                    </a>
                                    <a href="?action=delete&id={{ $flight->id }}">
                                        <img src="{{ asset('img/delete.png') }}" alt="delete-Button" class="crudBtn">
                                    </a>
                                </td>
                            @endif
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
