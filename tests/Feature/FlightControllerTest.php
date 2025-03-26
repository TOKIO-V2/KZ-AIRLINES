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
        $admin = User::factory()->create(['Admin' => true]);
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

    public function test_if_create_shows_form_for_admin()
    {
        $admin = User::factory()->create(['Admin' => true]);

        $this->actingAs($admin)
            ->get(route('createFlightForm'))
            ->assertOk()
            ->assertViewIs('flights.createFlightForm');
    }

    public function test_if_store_creates_new_flight()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();

        $data = [
            'date' => now()->addDays(10),
            'departure' => 'Madrid',
            'arrival' => 'Stuttgart',
            'plane_id' => $plane->id,
            'reserved' => 0,
        ];

        $this->actingAs($admin)
            ->post(route('flightStore'), $data)
            ->assertRedirect(route('flights'));

        $this->assertDatabaseHas('flights', [
            'departure' => 'Madrid',
            'arrival' => 'Stuttgart',
            'plane_id' => $plane->id
        ]);
    }

    public function test_if_show_displays_flight()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($user)
            ->get(route('flightShow', $flight->id))
            ->assertOk()
            ->assertViewIs('flights.flightShow')
            ->assertViewHas('flights');
    }

    public function test_if_edit_shows_edit_form_for_admin()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($admin)
            ->get(route('editFlightForm', $flight->id))
            ->assertOk()
            ->assertViewIs('flights.editFlightForm');
    }

    public function test_if_update_changes_flight_data()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $data = [
            'date' => now()->addDays(5),
            'departure' => 'Málaga',
            'arrival' => 'Berlín',
            'plane_id' => $plane->id,
            'reserved' => 10
        ];

        $this->actingAs($admin)
            ->post(route('flightUpdate', $flight->id), $data)
            ->assertRedirect(route('flights'));

        $this->assertDatabaseHas('flights', [
            'departure' => 'Málaga',
            'arrival' => 'Berlín',
        ]);
    }

    public function test_if_destroy_deletes_flight()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($admin)
            ->get(route('flights', ['action' => 'delete', 'id' => $flight->id]))
            ->assertRedirect(route('flights'));

        $this->assertDatabaseMissing('flights', ['id' => $flight->id]);
    }

    public function test_if_past_flights_updates_reserved_and_returns_view()
    {
        $admin = User::factory()->create(['Admin' => true]);
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

        $this->assertDatabaseHas('flight_user', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'unbook']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseMissing('flight_user', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_if_get_reservations_returns_json_for_admin()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);
        $user = User::factory()->create();
        $flight->users()->attach($user->id);

        $this->actingAs($admin)
            ->getJson(route('flightReservations', $flight->id))
            ->assertOk()
            ->assertJsonFragment([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
            ]);
    }

    public function test_if_non_admin_cannot_delete_flight()
    {
        $user = User::factory()->create(['Admin' => false]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($user)
            ->delete(route('flightDestroy', $flight->id))
            ->assertRedirect('/');
        
        $this->assertDatabaseHas('flights', ['id' => $flight->id]);
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

        $this->assertDatabaseMissing('flight_user', [
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

        $this->assertDatabaseHas('flight_user', [
            'flight_id' => $flight->id,
            'user_id' => $user->id
        ]);

        $this->assertEquals(0, $flight->fresh()->reserved);
    }

    public function test_if_non_admin_cannot_access_get_reservations()
    {
        $user = User::factory()->create(['Admin' => false]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->actingAs($user)
            ->get(route('flightReservations', $flight->id))
            ->assertRedirect('/');
    }

    public function test_if_guest_cannot_access_get_reservations()
    {
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);

        $this->get(route('flightReservations', $flight->id))
            ->assertRedirect('/');
    }

    public function test_if_admin_can_delete_past_flight_from_action_param()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'date' => now()->subDays(5),
        ]);

        $this->actingAs($admin)
            ->get(route('pastFlights', ['action' => 'delete', 'id' => $flight->id]))
            ->assertRedirect(route('pastFlights'));

        $this->assertDatabaseMissing('flights', ['id' => $flight->id]);
    }

    public function test_if_user_can_book_flight_with_available_capacity()
    {
        $user = User::factory()->create();
        $plane = Plane::factory()->create(['max_capacity' => 2]);
        $flight = Flight::factory()->create([
            'plane_id' => $plane->id,
            'reserved' => 1,
            'aviable' => 0
        ]);

        $this->actingAs($user)
            ->get(route('flightShow', ['id' => $flight->id, 'action' => 'book']))
            ->assertRedirect(route('flightShow', $flight->id));

        $this->assertDatabaseHas('flight_user', [
            'flight_id' => $flight->id,
            'user_id' => $user->id,
        ]);

        $this->assertEquals(2, $flight->fresh()->reserved);
    }

    public function test_if_get_reservations_returns_valid_json()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);
        $user = User::factory()->create();
        $flight->users()->attach($user->id);

        $response = $this->actingAs($admin)
            ->getJson(route('flightReservations', $flight->id));

        $response->assertOk();
        $response->assertJsonStructure([
            [
                'user_id',
                'user_name',
                'user_email',
            ]
        ]);
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);
    }

    public function test_if_non_admin_get_reservations_aborts_with_403()
    {
        $user = User::factory()->create(['Admin' => false]);
        $plane = Plane::factory()->create();
        $flight = flight::factory()->create(['plane_id' => $plane->id]);
    
        $this->actingAs($user)
            ->get(route('flightReservations', $flight->id))
            ->assertRedirect('/')
            ->assertSessionHas('error', 'No tienes permiso para acceder a esta página.');
    }

    public function test_if_admin_get_reservations_returns_json_correctly()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = Plane::factory()->create();
        $flight = Flight::factory()->create(['plane_id' => $plane->id]);
        $user = User::factory()->create();
        $flight->users()->attach($user->id);

        $response = $this->actingAs($admin)
            ->getJson(route('flightReservations', $flight->id));

        $response->assertOk();
        $response->assertJsonFragment([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
        ]);
        $response->assertJsonStructure([
            [
                'user_id',
                'user_name',
                'user_email'
            ]
        ]);
    }
}