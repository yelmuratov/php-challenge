<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

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

        $role1 = Role::create(['name' => 'Hr']);
        $role2 = Role::create(['name' => 'accountant']);
        $role3 = Role::create(['name' => 'Moderator']);
        $role4 = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id')->toArray();

        $role1->permissions()->attach($permissions);
        $role2->permissions()->attach($permissions);
        $role3->permissions()->attach($permissions);
        $role4->permissions()->attach($permissions);

        for($i = 1; $i <= 10; $i++) {
            $user = User::create([ 
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password')
            ]);

            $rand = rand(1, 3);
            for($j = 1; $j <= $rand; $j++) {
                $user->roles()->attach(rand(1, 3));
            }
        }
    }
}
