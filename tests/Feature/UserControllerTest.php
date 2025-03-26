<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Plane;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    public function test_if_shows_reservations_for_uthenticated_user(): void
    {
        $user = User::factory()->create();

        $plane = Plane::factory()->create();

        $futureFlight =Flight::factory()->create([
            'date' => Carbon::now()->addDays(2),
            'plane_id' => $plane->id,
        ]);

        $pastFlight = Flight::factory()->create([
            'date' => Carbon::now()->subDays(3),
            'plane_id' => $plane->id,
        ]);

        $user->flights()->attach($futureFlight);
        $user->flights()->attach($pastFlight);

        $response = $this->actingAs($user)->get(route('flightReservations', $user->id)); 

        $response->assertStatus(200);
        $response->assertViewIs('users.reservations');
    }
}