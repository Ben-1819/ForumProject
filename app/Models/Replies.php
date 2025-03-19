<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    protected $fillable = [
        "comment_id",
        "user_id",
        "contents",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
