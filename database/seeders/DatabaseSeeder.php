<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
        $this->call(RoleSeeder::class);

        $user = User::create([
            "first_name" => "Ben",
            "last_name" => "Brown",
            "email" => "ben@gmail.com",
            "email_verified_at" => now(),
            "password" => Hash::make("password"),
            "username" => "Ben",
            "avatar" => "1741788921.jpeg",
            "bio" => "I hate doing seeders",
            "public" => false,
        ]);

        $user->assignRole("superadmin");

        $user = User::create([
            "first_name" => "Matthew",
            "last_name" => "Kirk",
            "email" => "matthew@gmail.com",
            "email_verified_at" => now(),
            "password" => Hash::make("password"),
            "username" => "Matthew",
            "avatar" => "1741788921.jpeg",
            "bio" => "I also hate doing seeders",
            "public" => false,
        ]);

        $this->call(PostSeeder::class);
    }
}
