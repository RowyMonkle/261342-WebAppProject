<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        User::factory()->create([
    'name'     => 'fame',
    'email'    => 'nannapat_chaip@cmu.ac.th',
    'password' => bcrypt('fame1846'),
    'role'     => 'admin',
        ]);
        User::factory()->create([
    'name'     => 'panda Pandara',
    'email'    => 'pandarayuti@gmail.com',
    'password' => bcrypt('Pandarayuti0707'),
    'role'     => 'admin',
]);
         User::factory()->create([
    'name'     => 'forcollapsse',
    'email'    => 'forcolingzie@gmail.com',
    'password' => bcrypt('670615022'),
    'role'     => 'admin',
]);
  User::factory()->create([
    'name'     => 'Fai',
    'email'    => 'fai123@gmail.com',
    'password' => bcrypt('12345678'),
    'role'     => 'admin',
]);
        $this->call([
        TagSeeder::class,
        ProductSeeder::class,
        
    ]);
    }
}
