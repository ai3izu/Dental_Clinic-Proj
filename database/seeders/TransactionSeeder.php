<?php

namespace Database\Seeders;

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
        $appointmentsId = DB::table('appointments')->pluck('id')->toArray();
        $amounts = [150, 200, 250, 300, 350, 400, 450, 500];

        foreach ($appointmentsId as $appointmentId) {
            $isPaid = rand(0, 1);

            DB::table('transactions')->insert([
                'appointment_id' => $appointmentId,
                'amount' => $amounts[array_rand($amounts)],
                'status' => $isPaid ? 'paid' : 'unpaid',
                'payment_date' => $isPaid ? Carbon::now()->subDays(rand(1, 30)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
