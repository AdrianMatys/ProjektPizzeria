<?php

namespace Database\Seeders;

use App\Models\Opening_hours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzeriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('opening_hours')->insert([
            [
                'day' => 0,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"
            ],
            [
                'day' => 1,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"
            ],
            [
                'day' => 2,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"
            ],
            [
                'day' => 3,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"
            ],
            [
                'day' => 4,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"]
            ,
            [
                'day' => 5,
                'open_time' => "10:00:00",
                'close_time' => "22:00:00"
            ],
            [
                'day' => 6,
                'open_time' => null,
                'close_time' => null
            ]

        ]);
        DB::table('pizzeria_info')->insert([
            [
                'name' => "Collegium Pizzerona",
                'address' => 'Sejmowa 5',
                'city' => "Legnica",
                'delivery_available' => false,
                'max_delivery_radius' => 10,
                'phone_number' => '+48 111 222 333'
            ]
        ]);
    }
}
