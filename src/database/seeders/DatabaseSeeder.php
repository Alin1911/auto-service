<?php

namespace Database\Seeders;

use App\Models\Service;
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
        $service = Service::create(['name' => 'Service Slatina']);
        Service::create(['name' => 'Service Cluj']);
        Service::create(['name' => 'Service Bucuresti']);

        $user = new User();
        $user->name = "Test User";
        $user->email = "test@example.com";
        $user->password = "test";
        $user->is_active = 1;
        $user->service_id = $service->id;
        $user->save();

        Role::create(['name' => 'client']);
        Role::create(['name' => 'responsabil_service']);
        Role::create(['name' => 'admin']);


        Permission::create(['name' => 'modify_user_status']);
        Permission::create(['name' => 'manage_appointments']);

        $user->assignRole('admin');
    }
}
