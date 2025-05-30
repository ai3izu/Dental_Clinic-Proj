<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $specializations = [
            'Dentysta ogólny',
            'Stomatolog dziecięcy',
            'Ortodonta',
            'Chirurg stomatologiczny',
            'Protetyk stomatologiczny',
            'Endodonta',
            'Periodontolog'
        ];

        return [
            'user_id' => User::factory()->doctor(),
            'specialization' => $this->faker->randomElement($specializations),
            'phone_number' => $this->faker->numerify('#########'),
            'photo_url' => 'storage/images/doctor.jpg',
            'photo_alt' => 'Zdjęcie lekarza ' . $this->faker->firstName . ' ' . $this->faker->lastName,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
