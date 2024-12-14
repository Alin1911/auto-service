<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_appointment()
    {
        // Crearea unui utilizator
        $user = User::factory()->create();
        $user->is_active = 1;
        $user->save();
    
        $modifyUserPermission = Permission::create(['name' => 'modify_user_status']);
    
        $user->givePermissionTo('modify_user_status');

        $service = Service::factory()->create();

        $vehicle = Vehicle::factory()->create();

        $response = $this->actingAs($user)->post(route('appointments.store'), [
            'service_id' => $service->id,
            'appointment_type' => 'ITP', 
            'vehicle_id' => $vehicle->id,
            'appointment_time' => now()->addDays(1),
            'cost' => 150,
            'status' => 'registered',
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'chassis_series' => 'ABC12345',
            'manufacture_year' => 2015,
            'engine' => '1.6L',
            'observations' => 'Observație test',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('appointments', [
            'service_id' => $service->id,
            'user_id' => $user->id,
            'appointment_type' => 'ITP',
            'status' => 'registered',
        ]);
    }
}
