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
                'name' => 'Administrator',
                'email' => 'admin@pizzeria.com',
                'password' => 'admin',
                'role' => 'admin'
            ],
            [
                'name' => 'Employee',
                'email' => 'employee@pizzeria.com',
                'password' => 'employee',
                'role' => 'employee'
            ],
            [
                'name' => 'User',
                'email' => 'user@pizzeria.com',
                'password' => 'user',
                'role' => 'user'
            ]
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
