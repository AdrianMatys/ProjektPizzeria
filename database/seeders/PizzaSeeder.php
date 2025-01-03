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
                'name' => "Margherita",
                'price' => 19.99,
            ],
            [
                'name' => "Salami",
                'price' => 24.99,
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
        ]);
    }
}
