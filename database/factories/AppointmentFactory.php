<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $visitTypes = [
            'implantology',
            'orthodontics',
            'root_canal',
            'cavity_treatment'
        ];

        $appointmentDate = Carbon::now()->addDays($this->faker->numberBetween(1, 60));
        $appointmentHour = $this->faker->numberBetween(9, 17);
        $appointmentDate->setTime($appointmentHour, 0, 0);

        return [
            'doctor_id' => Doctor::factory(),
            'patient_id' => Patient::factory(),
            'appointment_date' => $appointmentDate,
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'canceled']),
            'visit_type' => $this->faker->randomElement($visitTypes),
            'notes' => $this->faker->boolean(50) ? $this->faker->sentence : null,
        ];
    }
}
