<?php

namespace Database\Factories;

use App\Models\History;
use App\Models\service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HistoryDetail>
 */
class HistoryDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'history_id' => History::inRandomOrder()->first()?->history_id ?? History::factory(),
            'service_id' => Service::inRandomOrder()->first()?->service_id ?? Service::factory(),
            'quantity' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->numberBetween(100000, 500000),
        ];
    }
}
