<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bus = Bus::first();

        Seat::factory(8)->create([
            'bus_id' => $bus->id,
            'start_point_id' => $bus->trips()->first()->start_point_id,
            'destination_point_id' => $bus->trips()->first()->destination_point_id,
        ]);

        Seat::factory(4)->create([
            'bus_id' => $bus->id,
            'start_point_id' => null,
            'destination_point_id' => null,
            'user_id' => null,
        ]);



        // create two seats one is not booked and another booked only to in between destination

        // make bus full from start to in between point but not full to the end
    }
}
