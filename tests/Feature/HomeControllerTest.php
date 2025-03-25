<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users(){
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('flights'));

        $response->assertStatus(500) 
                 ->assertViewIs('flights.flights');
    }
}