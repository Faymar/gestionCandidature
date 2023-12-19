<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'nom' => 'admin',
            'prenom' => 'faye',
            'datedeNaissance' => '1999-01-01',
            'telephone' => '771232425'
        ]);
    }
}
