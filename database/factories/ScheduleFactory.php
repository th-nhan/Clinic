<?php

namespace Database\Factories;

use App\Models\schedule_time;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\ScheduleTime;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->user_id ?? User::factory(),
            'schedule_time_id' => ScheduleTime::inRandomOrder()->first()?->schedule_time_id,
            'date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['available', 'booked']),
            'createdAt' => now(),
            'createdBy' => User::inRandomOrder()->first()?->user_id,
        ];
    }
}
