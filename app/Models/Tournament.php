<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Tournament extends Model
{
	
    protected $table = 'tournament';
    protected $fillable = ['country_id', 'venue', 'hotel_name', 'title','email','country_code','phone_number','description','maximum_Player','start_date','end_date','entry_fee','priceMoney','status','watch_live'];
	/**
     * @var string
     */
   

	 public function countries()
    {
         return $this->hasOne(Country::class, 'id' ,'game_id');
    }

}
