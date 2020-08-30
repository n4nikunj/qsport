<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\TournamentTranslation;
class Tournament extends Model
{
	use  Translatable;
    protected $table = 'tournament';
    protected $fillable = ['country_id', 'venue', 'hotel_name','email','country_code','phone_number','maximum_Player','start_date','end_date','entry_fee','priceMoney','status','watch_live'];
	/**
     * @var string
     */
    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];

    /**
     * @var string
     */
    public $translationForeignKey = 'tournament_id';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The class name for the localed model.
     *
     * @var string
     */
    public $translationModel = TournamentTranslation::class;

	 public function countries()
    {
         return $this->hasOne(Country::class,'id','country_id');
    }

}
