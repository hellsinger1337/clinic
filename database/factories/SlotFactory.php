<?php

namespace Database\Factories;

use App\Models\Slot;
use App\Models\Doctor;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlotFactory extends Factory
{
    protected $model = Slot::class;

    public function definition()
    {
        $start_time = $this->faker->dateTimeBetween('now', '+1 month');
        $duration = $this->faker->numberBetween(30, 120);
        $end_time = (clone $start_time)->modify("+$duration minutes");
        $is_available = rand(0,1);

        return [
            'doctor_id' => Doctor::factory(),
            'client_id' => $is_available  ? null : Client::factory(), 
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $is_available ? 'available' : $this->faker->randomElement(['booked', 'missed']),
        ];
    }
}
