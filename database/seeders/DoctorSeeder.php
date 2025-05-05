<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $specializations = [
            'Dentysta ogólny',
            'Stomatolog dziecięcy',
            'Ortodonta',
            'Chirurg stomatologiczny',
            'Protetyk stomatologiczny',
            'Endodonta',
            'Periodontolog'
        ];

        for ($i = 0; $i < 40; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $email = strtolower($firstName . '.' . $lastName . $i . '@example.com');

            $doctorId = DB::table('users')->insertGetId([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'doctor',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('doctors')->insert([
                'user_id' => $doctorId,
                'specialization' => $faker->randomElement($specializations),
                'phone_number' => $faker->numerify('#########'),
                'photo_url' => null,
                'description' => $faker->paragraph(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
