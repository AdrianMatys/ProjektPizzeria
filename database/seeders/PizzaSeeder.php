<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pizzas')->insert([
            [
                'name' => "Margheritta",
                'price' => 36,
            ],
            [
                'name' => "Salami picante",
                'price' => 39,
            ],
            [
                'name' => "Capricciosa",
                'price' => 39,
            ],
            [
                'name' => "Quattro Formaggi",
                'price' => 43,
            ],
        ]);
        DB::table('pizza_ingredients')->insert([
            //margherita
            [
                'pizza_id' => 1,
                'ingredient_id' => 1,
            ],
            [
                'pizza_id' => 1,
                'ingredient_id' => 2,
            ],
            [
                'pizza_id' => 1,
                'ingredient_id' => 6,
            ],
            [
                'pizza_id' => 1,
                'ingredient_id' => 5,
            ],
            //salami
            [
                'pizza_id' => 2,
                'ingredient_id' => 1,
            ],
            [
                'pizza_id' => 2,
                'ingredient_id' => 2,
            ],
            [
                'pizza_id' => 2,
                'ingredient_id' => 4,
            ],
            [
                'pizza_id' => 2,
                'ingredient_id' => 6,
            ],
            //capricciosa
            [
                'pizza_id' => 3,
                'ingredient_id' => 1,
            ],
            [
                'pizza_id' => 3,
                'ingredient_id' => 2,
            ],
            [
                'pizza_id' => 3,
                'ingredient_id' => 3,
            ],
            [
                'pizza_id' => 3,
                'ingredient_id' => 6,
            ],
            [
                'pizza_id' => 3,
                'ingredient_id' => 7,
            ],
            //quattro formaggi
            [
                'pizza_id' => 4,
                'ingredient_id' => 1,
            ],
            [
                'pizza_id' => 4,
                'ingredient_id' => 2,
            ],
            [
                'pizza_id' => 4,
                'ingredient_id' => 6,
            ],
            [
                'pizza_id' => 4,
                'ingredient_id' => 8,
            ],
            [
                'pizza_id' => 4,
                'ingredient_id' => 9,
            ],
            [
                'pizza_id' => 4,
                'ingredient_id' => 10,
            ],
        ]);
    }
}
