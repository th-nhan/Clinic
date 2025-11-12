<?php

namespace Database\Factories;

use App\Models\apointment;
use App\Models\Appointment;
use App\Models\service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppointmentDetail>
 */
class AppointmentDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'appointment_id' => Appointment::inRandomOrder()->first()?->appointment_id,
            'service_id' => Service::inRandomOrder()->first()?->service_id ?? Service::factory(),
        ];
    }
}
