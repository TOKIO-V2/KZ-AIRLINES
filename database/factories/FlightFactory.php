<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "destination" => fake()->country(),
            "date" => fake()->date(),
            "origin" => fake()->country(),
            "plane_id" => fake()->randomDigitNot(0),
            "reserved" => 0,
            "available_places" => fake()->unsignedInteger(),
            "available"=>fake()->boolean()
        ];
    }
}
