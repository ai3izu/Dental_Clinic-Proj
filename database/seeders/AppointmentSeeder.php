<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();


        for ($i = 0; $i < 40; $i++) {
            Appointment::factory()->create([
                'doctor_id' => $doctors->random()->id,
                'patient_id' => $patients->random()->id,
            ]);
        }
    }
}
