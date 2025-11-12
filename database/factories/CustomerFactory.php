<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fullname' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['nam', 'nữ', 'khác']),
            'contact_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'createdAt' => now(),
            'createdBy' => User::inRandomOrder()->first()?->user_id ?? User::factory(),
        ];
    }
}
