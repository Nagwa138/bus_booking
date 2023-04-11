<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
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
            'bus_id' => Bus::factory()->create()->id,
        ];
    }
}
