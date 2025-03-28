<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plane;
use App\Models\Flight;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Plane::factory(9)->create();
        Flight::factory(3)->create(['date'=>'2025-05-15']);
        Flight::factory(3)->create(['date'=>'2025-05-27']);
        Flight::factory(3)->create(['date'=>'2025-06-06']);
        Flight::factory(3)->create(['date'=>'2025-05-13']);
        Flight::factory(3)->create(['date'=>'2025-04-23']);
    }

}
