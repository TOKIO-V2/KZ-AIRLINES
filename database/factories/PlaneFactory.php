<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plane;   

class PlaneFactory extends Factory
{
    protected $model = Plane::class;

    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "max_capacity" => $this->faker->numberBetween(100, 300),
        ];
    }
}