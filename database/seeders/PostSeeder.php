<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::create([
            "user_id" => 1,
            "title" => "My first seeded post",
            "description" => "I can post things",
        ]);

        $post = Post::create([
            "user_id" => 2,
            "title" => "My second seeded post",
            "description" => "I can seed my posts in",
        ]);
    }
}
