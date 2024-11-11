<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Add specializations
        Specialization::factory(20)->create();
        // Add doctors for foreign key constraint
        Doctor::factory(20)->create();
    }

    public function test_update_returns_successful_response()
    {
        // Create appointment
        $appointment = Appointment::factory()->create([
            'doctor_id' => 1,
            'patient_name' => 'John Doe',
            'patient_email' => 'john@example.com',
            'date_time' => now()->addDays(1),
            'status' => 'available',
        ]);

        // Update appointment
        $response = $this->putJson("/api/appointments/{$appointment->id}", [
            'status' => 'available',
        ]);

        // Check if response is successful
        $response->assertStatus(200);
        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'patient_name' => null,
            'patient_email' => null,
            'status' => 'available',
        ]);
    }
}