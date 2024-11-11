<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Doctor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Specialization;
use App\Models\Timeslot;
use App\Models\Appointment;

class DoctorApiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Add specializations for foreign key constraint
        Specialization::factory(20)->create();
    }

    public function test_index_returns_successful_response()
    {
        $response = $this->get('api/doctors/');
        $response->assertStatus(200);
    }

    public function test_show_returns_data_response()
    {
        $this->createDoctorWithTimeslotsAndAppointments();

        $response = $this->get('api/doctors/1');
        // Assert json structure
        $response->assertJsonStructure([
            'id',
            'name',
            'specialization_id',
            'created_at',
            'updated_at',
            'timeslots' => [
                '*' => [
                    'id',
                    'doctor_id',
                    'start_time',
                    'end_time',
                    'is_available',
                    'created_at',
                    'updated_at',
                ],
            ],
            'appointments' => [
                '*' => [
                    'id',
                    'doctor_id',
                    'patient_name',
                    'patient_email',
                    'date_time',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    public function test_store_creates_doctor()
    {
        $response = $this->post('api/doctors/', [
            'name' => 'Dr. John Doe',
            'specialization_id' => 1,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('doctors', ['name' => 'Dr. John Doe']);
    }

    private function createDoctorWithTimeslotsAndAppointments()
    {
        $doctor = new Doctor();
        $doctor->name = 'Dr. John Doe';
        $doctor->specialization_id = 1;
        $doctor->save();

        $appointment = new Appointment();
        $appointment->doctor_id = $doctor->id;
        $appointment->date_time = '2021-01-01 10:00:00';
        $appointment->status = 'avalable';
        $doctor->appointments()->save($appointment);

        $timeSlot = new TimeSlot();
        $timeSlot->doctor_id = $doctor->id;
        $timeSlot->start_time = '2021-01-01 10:00:00';
        $timeSlot->end_time = '2021-01-01 10:15:00';
        $timeSlot->is_available = true;
        $doctor->timeslots()->save($timeSlot);
    }
}