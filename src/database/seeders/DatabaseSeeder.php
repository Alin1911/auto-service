<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            "name" => "Test User",
            "email" => "test2@example.com",
        ]);

        Role::create(['name' => 'client']);
        Role::create(['name' => 'responsabil_service']);
        Role::create(['name' => 'admin']);
    
        Permission::create(['name' => 'modify_user_status']);
        Permission::create(['name' => 'manage_appointments']);

        $user->assignRole('admin');
    }
}
