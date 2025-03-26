<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Plane;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_index_shows_future_flights()
    {
        $admin = User::factory()->create(['admin' => true]);
        $plane = Plane::factory()->create();

        Flight::factory()->count(2)->create([
            'plane_id' => $plane->id,
            'date' => now()->addDays(3),
        ]);

        $this->actingAs($admin)
            ->get(route('flights'))
            ->assertOk()
            ->assertViewHas('flights');
    }

    public function test_if_show_displays_flight()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($user)
            ->get(route('flightShow', $flight->id))
            ->assertOk()
            ->assertViewIs('flights.show')
            ->assertViewHas('flights');
    }

    public function test_if_past_flights_updates_reserved_and_returns_view()
    {
        $admin = User::factory()->create(['admin' => true]);
        $plane = Plane::factory()->create(['max_capacity' => 200]);
        $flight = Flight::factory()->create([
            'date' => now()->subDays(3),
            'reserved' => 0,
            'plane_id' => $plane->id
        ]);

        $this->actingAs($admin)
            ->get(route('pastFlights'))
            ->assertOk()
            ->assertViewIs('flights.pastFlights')
            ->assertViewHas('pastFlights');

        $this->assertEquals(200, $flight->fresh()->reserved);
    }

    public function test_if_flight_can_be_booked_and_unbooked()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create(['max_capacity' => 2]);
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'reserved' => 0
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'book']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseHas('Bookings', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'unbook']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseMissing('Bookings', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_if_booking_fails_when_flight_is_full()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create(['max_capacity' => 1]);
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'reserved' => 1
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'book']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseMissing('Bookings', [
            'flight_id' => $flight->id,
            'user_id' => $user->id
        ]);
    }

    public function test_if_unbook_does_nothing_when_reserved_is_zero()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'reserved' => 0
        ]);



        $flight->users()->attach($user->id);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'unbook']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseHas('Bookings', [
            'flight_id' => $flight->id,
            'user_id' => $user->id
        ]);

        $this->assertEquals(0, $flight->fresh()->reserved);
    }

    public function test_if_non_admin_cannot_access_get_reservations()
    {
        $user = User::factory()->create(['admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($user)
            ->get(route('flightReservations', $flight->id))
            ->assertStatus(302)
            ->assertRedirect(route('flights'));
    }

    public function test_if_guest_cannot_access_get_reservations()
    {
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->get(route('flightReservations', $flight->id))
            ->assertRedirect('/login');
    }

    public function test_if_user_can_book_flight_with_available_capacity()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create(['max_capacity' => 2]);
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'reserved' => 1,
            'available' => 0
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'book']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseHas('Bookings', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals(2, $flight->fresh()->reserved);
    }


}