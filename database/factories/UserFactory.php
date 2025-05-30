<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'),
            'role' => $this->faker->randomElement(['patient', 'doctor', 'admin']),
        ];
    }

    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@clinic.pl',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ];
        });
    }

    public function patient(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'patient',
            ];
        });
    }

    public function doctor(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'doctor',
            ];
        });
    }
}
