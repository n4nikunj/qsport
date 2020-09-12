<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\TutorsTranslation;
class Tutors extends Model implements HasMedia
{
    use  Translatable,HasMediaTrait;
    protected $table = 'tutors';
	 /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
	
    protected $fillable = ['user_id', 'phoneno', 'email','country_id','address','currency','rate','lat','long','facebook','youtube','twitter','profile_status','status'];
	/**
     * @var string
     */
    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'description'];

    /**
     * @var string
     */
    public $translationForeignKey = 'tutor_id';

   

    /**
     * The class name for the localed model.
     *
     * @var string
     */
	 
    public $translationModel = TutorsTranslation::class;

	 public function countries()
    {
         return $this->hasOne(Country::class,'id','country_id');
    }
	 public function user()
    {
        return $this->hasOne(User::class, 'id' ,'user_id');
    }
	 public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(500)
            ->height(900);
    }
}
