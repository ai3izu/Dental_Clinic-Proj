<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pl_PL');
        $cities = ['Warszawa', 'Kraków', 'Łódź', 'Wrocław', 'Poznań', 'Gdańsk', 'Szczecin', 'Bydgoszcz', 'Lublin', 'Katowice'];

        for ($i = 0; $i < 40; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $email = strtolower($firstName . '.' . $lastName . $i . '@example.com');

            $patientId = DB::table('users')->insertGetId([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => Hash::make('password123'),
                'role' => 'patient',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $birthDate = $faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d');

            DB::table('patients')->insert([
                'user_id' => $patientId,
                'phone_number' => $faker->numerify('#########'),
                'city' => $faker->randomElement($cities),
                'street' => $faker->streetName,
                'postal_code' => $faker->regexify('[0-9]{2}-[0-9]{3}'),
                'apartment_number' => $faker->numberBetween(1, 200),
                'staircase_number' => $faker->optional(0.3)->numberBetween(1, 5),
                'birth_date' => $birthDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
