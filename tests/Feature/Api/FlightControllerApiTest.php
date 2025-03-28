<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Flight;
use App\Models\Plane;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightControllerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_flights()
    {
        Plane::factory(9)->create();
        Flight::factory(3)->create();

        $response = $this->getJson('/api/flights');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_it_can_create_a_flight()
    {
        $plane = Plane::factory(9)->create();

        $data = [
            'date' => '2025-06-15',
            'origin' => 'Málaga',
            'destination' => 'Marruecos',
            'plane_id' => $plane[0]->id,
            'reserved' => 10,
            'available' => 100,
        ];

        $response = $this->postJson('/api/flights/store', $data);

        $response->assertStatus(200)
                 ->assertJsonFragment(['origin' => 'Málaga']);
    }

    public function test_it_can_show_a_single_flight()
    {
        $plane = Plane::factory(9)->create();
        $flight = Flight::factory()->create();

        $response = $this->getJson("/api/flights/show/{$flight->id}");

        $response->assertStatus(200)
                 ->assertJson(['id' => $flight->id]);
    }

    public function test_it_can_update_a_flight()
    {
        $plane = Plane::factory(9)->create();
        $flight = Flight::factory()->create();
        $newData = [
            'date' => '2025-07-20',
            'origin' => 'Barcelona',
            'destination' => 'Bruselas',
            'plane_id' => 1,
            'reserved' => 50,
            'available' => 80,
        ];

        $response = $this->putJson("/api/flights/update/{$flight->id}", $newData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['origin' => 'Barcelona']);
    }

    public function test_it_can_delete_a_flight()
    {
        $plane = Plane::factory(9)->create();
        $flight = Flight::factory()->create();

        $response = $this->deleteJson("/api/flights/destroy/{$flight->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('flights', ['id' => $flight->id]);
    }
}
