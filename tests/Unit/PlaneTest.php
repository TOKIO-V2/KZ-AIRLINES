<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\planeModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneTest extends TestCase
{
    use RefreshDatabase; 

    public function test_it_can_create_a_plane()
    {
        $plane = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $this->assertDatabaseHas('plane', [
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);
    }

    public function test_it_can_update_a_plane()
    {
        $plane = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $plane->update(['max_capacity' => 160]);

        $this->assertDatabaseHas('plane', [
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);
    }

    public function test_it_can_delete_a_plane()
    {
        $plane = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $plane->delete();

        $this->assertDatabaseMissing('plane', [
            'name' => 'Boeing 737',
        ]);
    }
}
