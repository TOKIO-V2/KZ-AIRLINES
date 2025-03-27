<?php

namespace Tests\Feature;

use App\Models\Plane;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaneControllerApiTest extends TestCase
{
    use RefreshDatabase;


    public function test_it_can_list_planes()
    {
        Plane::factory(3)->create(); 

        $response = $this->getJson('/api/planes');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_it_can_create_a_plane()
    {
        $planeData = [
            'name' => 'Boeing 747',
            'max_capacity' => 120,
        ];

        $response = $this->postJson('/api/planes', $planeData);

        $response->assertStatus(200)
                 ->assertJsonFragment($planeData);

        $this->assertDatabaseHas('planes', $planeData);
    }

    public function test_it_can_show_a_plane()
    {
        $plane = Plane::factory()->create();

        $response = $this->getJson("/api/planes/{$plane->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $plane->id,
                     'name' => $plane->name,
                 ]);
    }

    public function test_it_can_update_a_plane()
    {
        $plane = Plane::factory()->create();

        $updatedData = [
            'name' => 'Airbus A380',
            'max_capacity' => 180,
        ];

        $response = $this->putJson("/api/planes/{$plane->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('planes', $updatedData);
    }

    public function test_it_can_delete_a_plane()
    {
        $plane = Plane::factory()->create();

        $response = $this->deleteJson("/api/planes/{$plane->id}");

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}