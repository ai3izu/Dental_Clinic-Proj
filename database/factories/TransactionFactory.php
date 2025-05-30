<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amounts = [150, 200, 250, 300, 350, 400, 450, 500];
        $isPaid = $this->faker->boolean(50);

        return [
            'appointment_id' => Appointment::factory(),
            'amount' => $this->faker->randomElement($amounts),
            'status' => $isPaid ? 'paid' : 'unpaid',
            'payment_date' => $isPaid ? Carbon::now()->subDays(rand(1, 30)) : null,
        ];
    }
}
