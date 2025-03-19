<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "sender_id",
        "receiver_id",
        "message",
    ];

    public function sender(){
        return $this->belongsTo(User::class, "sender_id", "id");
    }

    public function receiver(){
        return $this->belongsTo(User::class, "receiver_id", "id");
    }

}
