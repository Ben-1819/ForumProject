<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    protected $fillable = [
        "user1_id",
        "user2_id",
        "favourite",
        "status",
    ];
}
