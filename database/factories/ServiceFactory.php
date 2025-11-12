<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->category_id ?? Category::factory(),
            'name' => $this->faker->words(2, true),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'min_price' => $this->faker->numberBetween(100000, 300000),
            'max_price' => $this->faker->numberBetween(400000, 700000),
            'unit' => 'lần',
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
