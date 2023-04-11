<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_station_id' => Station::first()->id,
            'end_station_id' => Station::first()->id,
            'user_id' => User::factory()->create()->id,
            'bus_id' => Bus::factory()->create()->id
        ];
    }
}
