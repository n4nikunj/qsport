<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
  		'country_name','country_code','currency_code','currency_symbol','slug','status','dial_code','currency',
  		];
}
