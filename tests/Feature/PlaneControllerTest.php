<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plane;
use Database\Factories\PlaneFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_index_shows_all_planes()
    {
        $user = User::factory()->create(['admin' => true]);
        Plane::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('planes'));

        $response->assertStatus(200)
                ->assertViewIs('planes.plane');
    }
    public function test_if_destroy_deletes_plane()
    {
        $admin = User::factory()->create(['admin' => true]);
        $plane = Plane::factory()->create();
        $this->be($admin);

        $this->get(route('planes', ['action' => 'delete', 'id' => $plane->id]))
            ->assertRedirect(route('planes'));

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}