<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GemsConfig extends Model
{

    protected $table = 'gems_config';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['game_id', 'allow_gems_payment', 'no_of_gems'];

    public function game()
    {
        return $this->hasOne(Game::class, 'id' ,'game_id');
    }

}
