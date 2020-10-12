<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Country;
use App\Models\User;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\PoolHallTranslation;

class PoolHall extends Model implements HasMedia
{
	use  Translatable,HasMediaTrait;
    protected $table = 'pool_hall';
	 /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations','countries','users'];
	
    protected $fillable = ['email','phone_number','country_code','country_id','social_media_link','number_of_tables','types_of_tables','price','start_time','end_time','status','created_by'];
	/**
     * @var string
     */
    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description','address'];

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
	public function users()
    {
         return $this->hasOne(User::class,'id','created_by');
    }
	public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(900);
    }
}
