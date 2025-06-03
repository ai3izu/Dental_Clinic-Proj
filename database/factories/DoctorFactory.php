<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Dodaj tę linię

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
        ];

        $photoUrl = 'storage/images/doctor.jpg';
        $photoAlt = null;

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $photoAlt = 'Zdjęcie lekarza ' . $firstName . ' ' . $lastName;

        try {
            $response = Http::get('https://thispersondoesnotexist.com');

            if ($response->successful()) {
                $contents = $response->body();
                $fileName = 'doctors/' . Str::uuid() . '.jpg';

                if (Storage::disk('public')->put($fileName, $contents)) {
                    $photoUrl = 'storage/' . $fileName;
                } else {
                    Log::error('Blad zapisu zdjecia do magazynu ' . $fileName);
                }
            } else {
                Log::error('Nie udalo sie fetchowac z api thispersondoesnotexist' . $response->status());
            }
        } catch (\Exception $e) {
            Log::error('Wyjatek podczas pobierania zdjecia' . $e->getMessage());
        }

        return [
            'user_id' => User::factory()->doctor(),
            'specialization' => $this->faker->randomElement($specializations),
            'phone_number' => $this->faker->numerify('#########'),
            'photo_url' => $photoUrl,
            'photo_alt' => $photoAlt,
            'description' => $this->faker->paragraph(3),
        ];
    }
}
