<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGameLevelStatus extends Model
{
    //
	 protected $table = 'user_game_level_statuses';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['level_id','user_id', 'game', 'gems' ,'status'];
}
