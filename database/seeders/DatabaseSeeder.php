<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $usersData = [
            [
                'name' => env('SEED_ADMIN_NAME', 'Administrator'),
                'email' => env('SEED_ADMIN_EMAIL', 'admin@test.com'),
                'password' => env('SEED_ADMIN_PASSWORD', 'admin'),
                'role' => 'admin'
            ],
            [
                'name' => env('SEED_EMPLOYEE_NAME', 'Employee'),
                'email' => env('SEED_EMPLOYEE_NAME', 'employee@test.com'),
                'password' => env('SEED_EMPLOYEE_PASSWORD', 'employee'),
                'role' => 'employee'
            ],
            [
                'name' => env('SEED_USER_NAME', 'User'),
                'email' => env('SEED_USER_EMAIL', 'user@test.com'),
                'password' => env('SEED_USER_PASSWORD', 'user'),
                'role' => 'user'
            ],
        ];

        foreach ($usersData as $userData) {
            User::factory()->create($userData);
        }


        $this->call([
            PizzeriaSeeder::class,
            StorageSeeder::class,
            PizzaSeeder::class,
            LogSeeder::class
        ]);
    }
}
