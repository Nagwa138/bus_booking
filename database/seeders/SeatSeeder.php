<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bus::all()->each(function ($bus){
            Seat::factory(12)->create([
                'bus_id' => $bus->id,
                'start_station_id' => null,
                'end_station_id' => null,
                'user_id' => null,
            ]);
        });
    }
}
