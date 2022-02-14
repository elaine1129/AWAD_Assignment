<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = $this->faker->randomElement(['ADMIN', 'PATIENT', 'DOCTOR']);
        $userData = [
            'name' => $this->faker->name(),
            'ic' => $this->faker->regexify('\\d{6}\\-\\d{2}\\-\\d{4}'),
            'email' => $this->faker->email(),
        ];
        switch ($role) {
            case 'ADMIN':
                break;
            case 'PATIENT':
                $userData["phone"] = $this->faker->phoneNumber;
                $userData["gender"] = $this->faker->randomElement(['male','female']);
                $userData["address"] = $this->faker->address;
                break;
            case 'DOCTOR':
                $userData["expertise"] = 'expertise';
                $userData["image_url"]=$this->faker->imageUrl();
                break;
        }

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => $role,
            'data' => $userData,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
