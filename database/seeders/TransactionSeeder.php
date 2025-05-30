<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointments = Appointment::all();

        foreach ($appointments as $appointment) {
            Transaction::factory()->create([
                'appointment_id' => $appointment->id,
            ]);
        }
    }
}
