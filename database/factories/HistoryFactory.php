<?php

namespace Database\Factories;

use App\Models\customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\history>
 */
class HistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'noted' => $this->faker->paragraph(),
            'createdAt' => now(),
            'createdBy' => User::inRandomOrder()->first()?->user_id,
        ];
    }
}
