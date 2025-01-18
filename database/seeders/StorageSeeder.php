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
                'quantityOnPizza' => 250
            ],
            [
                'name' => "San marzano tomato sauce",
                'quantity' => '3000',
                'unit' => "g",
                'price' => 2,
                'quantityOnPizza' => 100
            ],
            [
                'name' => "Prosciutto Cotto",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 4.99,
                'quantityOnPizza' => 70
            ],
            [
                'name' => "Salami picante",
                'quantity' => '5000',
                'unit' => "g",
                'price' => 7.99,
                'quantityOnPizza' => 60
            ],
            [
                'name' => "Basil",
                'quantity' => '800',
                'unit' => "g",
                'price' => 0.99,
                'quantityOnPizza' =>3
            ],
            [
                'name' => "Mozzarella FiorDiLatte",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
                'quantityOnPizza' => 200
            ],
            [
                'name' => "Champignons",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
                'quantityOnPizza' => 100
            ],
            [
                'name' => "Gorgonzola",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
                'quantityOnPizza' => 50
            ],
            [
                'name' => "Grana padano",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
                'quantityOnPizza' => 20
            ],
            [
                'name' => "Pecorino romano",
                'quantity' => '4000',
                'unit' => "g",
                'price' => 5.99,
                'quantityOnPizza' => 20
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
                'name' => "Sos z pomidorów san marzano",
            ],
            [
                'ingredient_id' => 3,
                'language_code' => 'pl',
                'name' => "Szynka prosciutto cotto",
            ],
            [
                'ingredient_id' => 5,
                'language_code' => 'pl',
                'name' => "Bazylia",
            ],
            [
                'ingredient_id' => 7,
                'language_code' => 'pl',
                'name' => "Pieczarki",
            ],
        ]);
    }
}
