<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('log_categories')->insert([
            [
                'id' => 1,
                'name' => "Notifications",
            ],
            [
                'id' => 2,
                'name' => "Auth",
            ],
            [
                'id' => 3,
                'name' => "Orders",
            ],
            [
                'id' => 4,
                'name' => "Management",
            ],
            [
                'id' => 5,
                'name' => "Ingredients",
            ],
            [
                'id' => 6,
                'name' => "Pizzas",
            ],
        ]);
        DB::table('log_types')->insert([
            [
                'category_id' => 1,
                'name' => "Low stock",
                'description' => "Low stock notification sent",
            ],
            [
                'category_id' => 2,
                'name' => "New User",
                'description' => "A new user has created an account",
            ],
            [
                'category_id' => 2,
                'name' => "Logged in",
                'description' => "User has logged in",
            ],
            [
                'category_id' => 2,
                'name' => "Password reset",
                'description' => "User reset password",
            ],
            [
                'category_id' => 3,
                'name' => "New Order",
                'description' => "User placed an order",
            ],
            [
                'category_id' => 4,
                'name' => "Dismissal",
                'description' => "Administrator fired employee",
            ],
            [
                'category_id' => 4,
                'name' => "Pizzeria information",
                'description' => "Administrator has updated information about pizzeria",
            ],
            [
                'category_id' => 4,
                'name' => "Updated translation",
                'description' => "Employee has updated ingredient translation",
            ],
            [
                'category_id' => 5,
                'name' => "New ingredient",
                'description' => "Employee added a new ingredient",
            ],
            [
                'category_id' => 5,
                'name' => "Deleted ingredient",
                'description' => "Employee removed ingredient",
            ],
            [
                'category_id' => 5,
                'name' => "Updated ingredient",
                'description' => "Employee updated ingredient",
            ],
            [
                'category_id' => 6,
                'name' => "New pizza",
                'description' => "Employee created a new pizza",
            ],
            [
                'category_id' => 6,
                'name' => "Deleted pizza",
                'description' => "Employee updated pizza",
            ],
            [
                'category_id' => 6,
                'name' => "Updated pizza",
                'description' => "Employee updated pizza",
            ],
        ]);
    }
}
