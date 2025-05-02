<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patientId = DB::table('users')->insertGetId([
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'kowalski@example.pl',
            'password' => Hash::make('password123'),
            'role' => 'patient',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('patients')->insert([
            'user_id' => $patientId,
            'phone_number' => '123456789',
            'city' => 'Dobrynia',
            'street' => 'Dobrynia',
            'postal_code' => '12-345',
            'apartment_number' => '113',
            'staircase_number' => null,
            'birth_date' => '1990-01-01',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
