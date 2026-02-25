<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Oldm2563',
            'email' => 'oldm2563@gmail.com',
            'password' => Hash::make('admin123')
        ]);
        User::factory()->create([
            'name' => 'Supernoob',
            'email' => 'supernoob761@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $this->call(
            RoleSeeder::class
        );
    }
}
