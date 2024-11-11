<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timeslot>
 */
class TimeslotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random date
        $date = $this->faker->dateTimeBetween('now', '+1 month');

        // Generate start and end times
        [$startTime, $endTime] = $this->generateTimeslot($date);

        // Generate appointments for the timeslot
        $doctorId = $this->faker->numberBetween(1, 20);
        $appointments = Appointment::factory()->generateAppointmentsForTimeSlot($startTime, $endTime, $doctorId);

        return [
            'doctor_id' => $doctorId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_available' => true,
        ];
    }

    /**
     * Generate start and end time for a timeslot.
     *
     * @param \DateTime $date
     * @return array
     */
    protected function generateTimeslot(\DateTime $date): array
    {
        // Generate a random start time between 8:00 and 16:00
        $startHour = $this->faker->numberBetween(8, 16); 

        // Set the start time to the generated hour and minute
        $startTime = clone $date;
        $startTime->setTime($startHour, 0);

        // Set end time - timeslots between one and four hours
        $duration = $this->faker->numberBetween(1, 4);
        $endTime = clone $startTime;
        $endTime->modify('+' . $duration . ' hours');

        return [$startTime, $endTime];
    }
}
