<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleTimeFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->time('H:i');
        return [
            'start_time' => $start,
            'end_time' => date('H:i', strtotime($start) + 3600),
        ];
    }
}
