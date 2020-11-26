<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Country;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\TournamentTranslation;
class Tournament extends Model implements HasMedia
{
	use  Translatable, HasMediaTrait;
    protected $table = 'tournament';
	 /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
	
    protected $fillable = ['country_id', 'venue', 'hotel_name','email','country_code','phone_number','maximum_Player','start_date','end_date','entry_fee','currency','priceMoney','status','amountPaid','watch_live','created_by'];
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
     * The class name for the localed model.
     *
     * @var string
     */
	 
    public $translationModel = TournamentTranslation::class;

	
	
	public function countries()
    {
         return $this->hasOne(Country::class,'id','country_id');
    }
	public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(900);
    }
}
