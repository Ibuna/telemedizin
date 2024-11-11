<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\TimeSlot;
use App\Models\Specialization;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Specialization::factory(20)->create();
        
        Doctor::factory(20)->create();
        TimeSlot::factory(60)->create();
    }
}
