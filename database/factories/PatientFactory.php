<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cities = [
            'Warszawa',
            'Kraków',
            'Łódź',
            'Wrocław',
            'Poznań',
            'Gdańsk',
            'Szczecin',
            'Bydgoszcz',
            'Lublin',
            'Katowice'
        ];
        return [
            'user_id' => User::factory()->patient(),
            'phone_number' => $this->faker->numerify('#########'),
            'city' => $this->faker->randomElement($cities),
            'street' => $this->faker->streetName,
            'postal_code' => $this->faker->regexify('[0-9]{2}-[0-9]{3}'),
            'apartment_number' => $this->faker->numberBetween(1, 200),
            'staircase_number' => $this->faker->optional(0.3)->numberBetween(1, 5),
            'birth_date' => $this->faker->dateTimeBetween('-80 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
