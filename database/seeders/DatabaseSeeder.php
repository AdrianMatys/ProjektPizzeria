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

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@pizzeria.com',
            'password' => 'admin',
            'role' => 'admin'
        ]);


        $this->call([
            PizzeriaSeeder::class,
            StorageSeeder::class
        ]);
    }
}
