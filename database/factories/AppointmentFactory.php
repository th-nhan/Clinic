<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->user_id ?? User::factory(),
            'contact_number' => $this->faker->phoneNumber(),
            'time' => $this->faker->time(),
            'date' => $this->faker->date(),
            'noted' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'canceled']),
        ];
    }
}
