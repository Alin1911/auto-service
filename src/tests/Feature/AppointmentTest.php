<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_appointment()
    {
        $user = User::factory()->create();
        $user->is_active = 1;
        $user->save();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)->post(route('appointments.store'), [
            'service_id' => $service->id,
            'appointment_type' => 'ITP',
            'vehicle_id' => null,
            'appointment_time' => now(),
            'cost' => 150,
            'status' => "registered"
        ]);

        $response->assertStatus(302);

        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'service_id' => $service->id,
            'user_id' => $user->id,
        ]);
    }
}
