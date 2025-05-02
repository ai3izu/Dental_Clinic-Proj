<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorId = DB::table('users')->insertGetId([
            'first_name' => 'Marcin',
            'last_name' => 'Maczuga',
            'email' => 'marcin12@wp.pl',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        DB::table('doctors')->insert([
            'user_id' => $doctorId,
            'specialization' => 'Dentysta ogólny',
            'phone_number' => '123456789',
            'photo_url' => null,
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
