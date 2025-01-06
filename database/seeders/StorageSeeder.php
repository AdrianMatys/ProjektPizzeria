<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            [
                'name' => "Dough",
                'quantity' => '5000',
                'unit' => "g",
                'price' => 10,
            ],
            [
                'name' => "Tomato pizza sauce",
                'quantity' => '3000',
                'unit' => "g",
                'price' => 2,
            ],
            [
                'name' => "Ham",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 4.99,
            ],
            [
                'name' => "Salami",
                'quantity' => '5000',
                'unit' => "g",
                'price' => 7.99,
            ],
            [
                'name' => "Oregano",
                'quantity' => '800',
                'unit' => "g",
                'price' => 0.99,
            ],
            [
                'name' => "Cheese",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
            ]
        ]);
        DB::table('translations')->insert([
            [
                'ingredient_id' => 1,
                'language_code' => 'pl',
                'name' => "Ciasto",
            ],
            [
                'ingredient_id' => 2,
                'language_code' => 'pl',
                'name' => "Sos pomidorowy",
            ],
            [
                'ingredient_id' => 5,
                'language_code' => 'es',
                'name' => "orégano",
            ],
        ]);
    }
}
