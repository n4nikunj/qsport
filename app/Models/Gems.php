<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Gems extends Model
{

    protected $table = 'gems';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'number_of_gems', 'getting_from', 'created_by'];

	public function users()
    {
         return $this->hasOne(User::class,'id','created_by');
    }
}
