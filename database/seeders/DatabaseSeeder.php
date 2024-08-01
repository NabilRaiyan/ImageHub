<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Package;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Nabil',
            'email' => 'nabil@example.com',
            'password' => bcrypt('qwerty123'),
        ]);

        

        Feature::create([
            'image' => 'https://media.istockphoto.com/id/1069705330/vector/medical-cross-icon-medicine-healthcare-concept-thin-line-design-vector-icon.jpg?s=1024x1024&w=is&k=20&c=gl6ni2OdF9zE3TJfJclT0z0wCrRuffb_JRQI3gc9wZ4=',
            'route_name' => 'feature1.index',
            'name' => 'Calculate Sum',
            'description' => 'Calculate sum of 2 numbers',
            'required_credits' => 1,
            'active' => true,
        ]);


        Feature::create([
            'image' => 'https://media.istockphoto.com/id/1605395715/vector/zoom-out-icon.jpg?s=1024x1024&w=is&k=20&c=RPjSmeK5SDdrgGsEsYxYMgg7yvKaK1OPA7VQ5u4SICk=',
            'route_name' => 'feature2.index',
            'name' => 'Calculate Subtraction',
            'description' => 'Calculate Subtraction of 2 numbers',
            'required_credits' => 3,
            'active' => true,
        ]);

        Package::create([
            'name' => 'Basic',
            'price' => 5,
            'credits' => 20,
        ]);

        Package::create([
            'name' => 'Silver',
            'price' => 20,
            'credits' => 100,
        ]);

        Package::create([
            'name' => 'Gold',
            'price' => 50,
            'credits' => 500,
        ]);
    }
}
