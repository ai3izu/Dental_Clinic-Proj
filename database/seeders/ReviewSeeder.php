<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $doctorsId = DB::table('doctors')->pluck('id')->toArray();
        $patientsId = DB::table('patients')->pluck('id')->toArray();

        for ($i = 0; $i < 40; $i++) {
            DB::table('reviews')->insert([
                'doctor_id' => $doctorsId[array_rand($doctorsId)],
                'patient_id' => $patientsId[array_rand($patientsId)],
                'content' => $faker->realText(200),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
