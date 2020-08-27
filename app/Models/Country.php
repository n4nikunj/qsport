<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;
class Country extends Model
{
    protected $fillable = [
  		'country_name','country_code','currency_code','currency_symbol','slug','status','dial_code','currency',
  		];
		
	 public function tournament()
	  {
		return $this->belongsTo(Tournament::class, 'country_id');
	  }	
}
