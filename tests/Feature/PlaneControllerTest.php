<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\planeModel;
use Database\Factories\PlaneFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_index_shows_all_planes()
    {
        $user = User::factory()->create(['Admin' => true]);
        PlaneFactory::factory()->count(3)->create();

        $this->actingAs($user)
            ->get(route('planes'))
            ->assertOk()
            ->assertViewHas('planes');
    }

    public function test_if_create_shows_create_form_for_admin()
    {
        $admin = User::factory()->create(['Admin' => true]);

        $this->actingAs($admin)
            ->get(route('createPlaneForm'))
            ->assertOk()
            ->assertViewIs('planes.createPlaneForm');
    }

    public function test_if_store_creates_a_new_plane()
    {
        $admin = User::factory()->create(['Admin' => true]);

        $data = [
            'name' => 'AIRBUS Plane',
            'max_capacity' => 180,
        ];

        $this->actingAs($admin)
            ->post(route('planeStore'), $data)
            ->assertRedirect(route('planes'));

        $this->assertDatabaseHas('planes', $data);
    }

    public function test_if_show_displays_plane_info()
    {
        $user = User::factory()->create(['Admin' => true]);
        $plane = planeModel::factory()->create();
    
        $this->actingAs($user)
            ->get(route('planeShow', $plane->id))
            ->assertOk()
            ->assertViewIs('planes.planeShow')
            ->assertViewHas('plane', function ($viewPlane) use ($plane) {
                return $viewPlane->id === $plane->id;
            });
    }

    public function test_if_edit_shows_edit_form_for_admin()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = planeModel::factory()->create();

        $this->actingAs($admin)
            ->get(route('editPlaneForm', $plane->id))
            ->assertOk()
            ->assertViewIs('planes.editPlaneForm')
            ->assertViewHas('plane', $plane);
    }

    public function test_if_update_changes_plane_data()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = planeModel::factory()->create();

        $data = [
            'name' => 'Updated Plane',
            'max_capacity' => 160,
        ];

        $this->actingAs($admin)
            ->post(route('planeUpdate', $plane->id), $data)
            ->assertRedirect(route('planes'));

        $this->assertDatabaseHas('planes', $data);
    }

    public function test_if_destroy_deletes_plane()
    {
        $admin = User::factory()->create(['Admin' => true]);
        $plane = planeModel::factory()->create();

        $this->actingAs($admin)
            ->get(route('planes', ['action' => 'delete', 'id' => $plane->id]))
            ->assertRedirect(route('planes'));

        $this->assertDatabaseMissing('planes', ['id' => $plane->id]);
    }
}