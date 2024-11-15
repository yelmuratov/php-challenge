<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;

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
            'email' => fake()->unique()->safeEmail(),
        ]);

        $routes = Route::getRoutes();
        foreach($routes as $route) {
            
            $key = $route->getName();

            if($key && !str_starts_with($key,'generated::') && $key !== 'storage.local'){
                $name = ucfirst(str_replace('.', '-', $key));
                Permission::create([
                    'name' => $name,
                    'key' => $key
                ]);
            }
        }

        for($i = 0; $i < 5; $i++) {
            Category::create([
                'name' => fake()->unique()->word()
            ]);
        }

        for($i = 0; $i < 100; $i++) {
            Product::create([
                'category_id' => fake()->numberBetween(1, 5),
                'name' => fake()->unique()->word(),
                'description' => fake()->sentence(),
                'price' => fake()->randomFloat(2, 1, 100),
                'quantity' => fake()->numberBetween(1, 100)
            ]);
        }
    }
}
