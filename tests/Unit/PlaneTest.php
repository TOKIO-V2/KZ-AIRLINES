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
        $planes = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $this->assertDatabaseHas('planes', [
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);
    }

    public function test_it_can_update_a_plane()
    {
        $planes = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $planes->update(['max_capacity' => 160]);

        $this->assertDatabaseHas('planes', [
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);
    }

    public function test_it_can_delete_a_plane()
    {
        $planes = planeModel::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $planes->delete();

        $this->assertDatabaseMissing('planes', [
            'name' => 'Boeing 737',
        ]);
    }
}
