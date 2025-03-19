<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:all-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return All Records From The Users Table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $headers = ["ID", "First Name", "Last Name", "Email", "Username", "avatar", "Bio", "Public"];
        $users = User::all(["id", "first_name", "last_name", "email", "username", "avatar", "bio", "public"]);
        $this->table($headers, $users);

        return 0;
    }
}
