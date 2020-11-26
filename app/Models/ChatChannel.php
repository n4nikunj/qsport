<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatChannel extends Model
{
    protected $table = 'chat_channels';

    protected $fillable = ['created_by', 'joined_by','create_chat_module','channel_unique_name','last_message','last_message_date','channel_sid'];
}
