<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Plane;
use App\Models\Flight;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaneTest extends TestCase
{
    use RefreshDatabase; 

    public function test_it_can_create_a_plane()
    {
        $planes = Plane::create([
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
        $planes = Plane::create([
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
        $planes = Plane::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        $planes->delete();

        $this->assertDatabaseMissing('planes', [
            'name' => 'Boeing 737',
        ]);
    }

    public function test_it_has_relation()
    {
        $plane = Plane::create([
            'name' => 'Boeing 737',
            'max_capacity' => 160,
        ]);

        Flight:: create([
            'date'=> '2025-27-03', 
            'origin'=> 'Málaga', 
            'destination'=> 'Stuttgart', 
            'plane_id'=> '1',
            'reserved'=> '20',
            'available'=> true
        ]);

        $this->assertInstanceOf(Flight::class, $plane->flights[0]);
    }
}
