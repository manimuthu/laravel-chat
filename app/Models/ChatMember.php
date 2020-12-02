<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ChatMember extends Model
{

    protected $table = "chatting_members";

    protected $fillable = [
        'user_id', 'chat_id'
    ];

}
