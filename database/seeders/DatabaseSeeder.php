<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@a.com',
            'password' => 'a'
        ]);

        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'b@b.com',
            'password' => 'b'
        ]);
        // Crear etiquetas predeterminadas
        Tag::create([
            'name' => '🔴 red'
        ]);
        Tag::create([
            'name' => '🟢 green'
        ]);
        Tag::create([
            'name' => '🟡 yellow'
        ]);

    }
}
