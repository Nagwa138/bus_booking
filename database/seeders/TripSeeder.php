<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trip::factory()->create([
            'bus_id' => Bus::first()->id,
            'start_station_id' => Station::first()->id,
            'end_station_id' => Station::orderBy('order', 'DESC')->first()->id,
        ]);
    }
}
