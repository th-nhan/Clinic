<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'total_price' => $this->faker->numberBetween(100000, 2000000),
            'method_payment' => $this->faker->randomElement(['cash', 'momo', 'card']),
            'status' => $this->faker->randomElement(['pending', 'paid']),
            'createdAt' => now(),
            // Không set 'history_id' và 'user_id' ở đây, sẽ được Seeder truyền
        ];
    }
}
