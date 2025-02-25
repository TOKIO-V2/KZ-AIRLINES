<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\planeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class PlaneControllerTest extends TestCase
{
    use RefreshDatabase; 

    public function test_it_can_list_planes()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($user);

        planeModel::factory()->count(3)->create();

        $response = $this->getJson('/api/plane');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_it_can_create_a_plane()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($user); 

        $data = [
            'name' => 'Boeing 737',
            'max_capacity' => 150,
        ];

        $response = $this->postJson('/api/plane', $data);

        $response->assertStatus(201)
                 ->assertJson(['data' => $data]);

        $this->assertDatabaseHas('plane', $data);
    }

    public function test_it_can_update_a_plane()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($user);

        $plane = planeModel::factory()->create();

        $data = [
            'name' => 'Airbus A320',
            'max_capacity' => 160,
        ];

        $response = $this->putJson("/api/plane/{$plane->id}", $data);

        $response->assertStatus(200)
                 ->assertJson(['data' => $data]);

        $this->assertDatabaseHas('plane', $data);
    }

    public function test_it_can_delete_a_plane()
    {
        $user = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($user); 

        $plane = planeModel::factory()->create();

        $response = $this->deleteJson("/api/plane/{$plane->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('plane', ['id' => $plane->id]);
    }
}
