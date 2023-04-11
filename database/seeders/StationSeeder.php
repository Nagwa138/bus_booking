<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                "order" => "1",
                "name" => "Cairo"
            ],
            [
                "order" => "2",
                "name" => "Giza"
            ],
            [
                "order" => "3",
                "name" => "Alexandria"
            ],
            [
                "order" => "4",
                "name" => "Dakahlia"
            ],
            [
                "order" => "5",
                "name" => "Red Sea"
            ],
            [
                "order" => "6",
                "name" => "Beheira"
            ],
            [
                "order" => "7",
                "name" => "Fayoum"
            ],
            [
                "order" => "8",
                "name" => "Gharbiya"
            ],
            [
                "order" => "9",
                "name" => "Ismailia"
            ],
            [
                "order" => "10",
                "name" => "Menofia"
            ],
            [
                "order" => "11",
                "name" => "Minya"
            ],
            [
                "order" => "12",
                "name" => "Qaliubiya"
            ],
            [
                "order" => "13",
                "name" => "New Valley"
            ],
            [
                "order" => "14",
                "name" => "Suez"
            ],
            [
                "order" => "15",
                "name" => "Aswan"
            ],
            [
                "order" => "16",
                "name" => "Assiut"
            ],
            [
                "order" => "17",
                "name" => "Beni Suef"
            ],
            [
                "order" => "18",
                "name" => "Port Saorder"
            ],
            [
                "order" => "19",
                "name" => "Damietta"
            ],
            [
                "order" => "20",
                "name" => "Sharkia"
            ],
            [
                "order" => "21",
                "name" => "South Sinai"
            ],
            [
                "order" => "22",
                "name" => "Kafr Al sheikh"
            ],
            [
                "order" => "23",
                "name" => "Matrouh"
            ],
            [
                "order" => "24",
                "name" => "Luxor"
            ],
            [
                "order" => "25",
                "name" => "Qena"
            ],
            [
                "order" => "26",
                "name" => "North Sinai"
            ],
            [
                "order" => "27",
                "name" => "Sohag"
            ]
        ];

        DB::table('stations')->insert($cities);
    }
}
