<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\PoolHallTranslation;

class PoolHall extends Model
{
	use  Translatable;
    protected $table = 'pool_hall';
	 /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations','countries'];
	
    protected $fillable = ['pool_image','title','email','phone_number','description','country_id','address','social_media_link','number_of_tables','types_of_tables','price','start_time','end_time','status'];
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
    public $translationForeignKey = 'pool_hall_id';
    /**
     * The class name for the localed model.
     *
     * @var string
     */
	 
    public $translationModel = PoolHallTranslation::class;

	public function countries()
    {
         return $this->hasOne(Country::class,'id','country_id');
    }

}
