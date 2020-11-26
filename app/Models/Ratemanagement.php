<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ratemanagement extends Model
{
	
	 protected $table = 'ratemanagements';
	 
   protected $fillable = [
  		'section','rate','status'
    ];
  
}
