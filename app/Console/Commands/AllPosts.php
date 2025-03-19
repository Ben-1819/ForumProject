<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class AllPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:all-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return all records from the posts table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $headers = ["ID", "User Id", "Title", "Description", "Likes"];
        $posts = Post::all(["id", "user_id", "title", "description", "likes"]);
        $this->table($headers, $posts);

        return 0;
    }
}
