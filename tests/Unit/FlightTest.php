<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Plane;
use App\Models\Flight;
use App\Models\flightModel;
use App\Models\planeModel;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FlightTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    public function test_if_can_create_a_flight_with_fillable_fields()
    {
        $plane = planeModel::factory()->create();

        $flight = flightModel::create([
            'date' => now()->addDays(2),
            'departure' => 'Málaga',
            'arrival' => 'Stuttgart',
            'plane_id' => $plane->id,
            'reserved' => 5,
            'aviable' => 1,
        ]);

        $this->assertDatabaseHas('flights', [
            'departure' => 'Málaga',
            'arrival' => 'Stuttgart',
            'plane_id' => $plane->id,
        ]);
    }

    public function test_if_belongs_to_a_plane()
    {
        $plane = planemodel::factory()->create();
        $flight = flightModel::factory()->create(['plane_id' => $plane->id]);

        $this->assertInstanceOf(planeModel::class, $flight->plane);
        $this->assertEquals($plane->id, $flight->plane->id);
    }

    public function test_if_has_many_users()
    {
        $plane = planeModel::factory()->create();

        $flight = flightModel::factory()->create(['plane_id' => $plane->id,]);
        
        $users = User::factory()->count(3)->create();

        $flight->users()->attach($users->pluck('id'));

        $this->assertCount(3, $flight->users);
        $this->assertTrue($flight->users->contains($users[0]));
    }
}