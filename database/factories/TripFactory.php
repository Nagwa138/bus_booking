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
            'start_point_id' => Station::factory()->create()->id,
            'destination_point_id' => Station::factory()->create()->id,
            'bus_id' => Bus::factory()->create()->id,
        ];
    }
}
