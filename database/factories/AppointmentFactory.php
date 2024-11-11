<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;
use DateTime;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('now', '+1 month');

        $doctorId = $this->faker->numberBetween(1, 20); 

        return [
            'doctor_id' => $doctorId,
            'date_time' => $date,
            'status' => 'available',
        ];
    }

    /**
     * Generate appointments for a specific time slot and doctor.
     *
     * @param \DateTime $timeSlotStartTime
     * @param \DateTime $timeSlotEndTime
     * @param int $doctorId
     */
    public function generateAppointmentsForTimeSlot($timeSlotStartTime, $timeSlotEndTime, $doctorId) {
        $duration = 15;
        $appointmentStartTime = clone $timeSlotStartTime;

        while ($appointmentStartTime < $timeSlotEndTime) {

            $appointment = new Appointment();
            $appointment->doctor_id = $doctorId;
            $appointment->date_time = $appointmentStartTime;
            $availability = $this->faker->boolean(80) ? 'available' : 'booked';
            $appointment->status = $availability;
            $appointment->save();

            $appointmentStartTime->modify('+' . $duration . ' minutes');
        }
    }
}
