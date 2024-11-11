<?php
// tests/Unit/UserTest.php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Appointment;
use App\Models\Timeslot;

class DoctorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Add specializations for foreign key constraint
        Specialization::factory(20)->create();
    }


    public function test_doctor_creation()
    {
        $doctor = Doctor::factory()->create();
        $this->assertInstanceOf(Doctor::class, $doctor);
    }

    public function test_doctor_has_many_appointments()
    {
        // Add doctor
        $doctor = Doctor::factory()->create();

        // Add appointments that are related to the doctor
        $appointments = Appointment::factory()->count(3)->create([
            'doctor_id' => $doctor->id,
        ]);

        // Überprüfe, ob die Beziehung korrekt ist
        $this->assertInstanceOf(Appointment::class, $doctor->appointments->first());
        $this->assertCount(3, $doctor->appointments);
        $this->assertTrue($doctor->appointments->contains($appointments->first()));
    }

    public function test_doctor_belongs_to_specialization()
    {
        // Add doctor
        $doctor = Doctor::factory()->create();

        // Check if doctor belongs to a specialization
        $this->assertInstanceOf(Specialization::class, $doctor->specialization->first());
    }
}