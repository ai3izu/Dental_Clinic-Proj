<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorsId = DB::table('doctors')->pluck('id')->toArray();
        $patientsId = DB::table('patients')->pluck('id')->toArray();
        $visitTypes = ['implantology', 'orthodontics', 'root_canal', 'cavity_treatment'];

        for ($i = 0; $i < 40; $i++) {
            $date = Carbon::now()->addDays(rand(1, 60))->addHours(rand(9, 16));
            $startTime = $date->copy()->addMinutes(rand(0, 4) * 15);

            DB::table('appointments')->insert([
                'doctor_id' => $doctorsId[array_rand($doctorsId)],
                'patient_id' => $patientsId[array_rand($patientsId)],
                'appointment_date' => $startTime,
                'status' => rand(0, 1) ? 'scheduled' : (rand(0, 1) ? 'completed' : 'canceled'),
                'visit_type' => $visitTypes[array_rand($visitTypes)],
                'notes' => rand(0, 1) ? 'Testowa wizyta dla pacjenta bo ma problem z seederem' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
