<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        "user_id",
        "title",
        "description",
        "likes",
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post_likes(){
        return $this->hasMany(Like::class);
    }

    public function saves(){
        return $this->hasMany(Save::class);
    }
}
