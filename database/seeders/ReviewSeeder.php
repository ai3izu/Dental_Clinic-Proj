<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::all();
        $patients = Patient::all();

        for ($i = 0; $i < 40; $i++) {
            Review::factory()->create([
                'doctor_id' => $doctors->random()->id,
                'patient_id' => $patients->random()->id,
            ]);
        }
    }
}
