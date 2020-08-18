<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\GameTranslation;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;


class Game extends Model implements HasMedia
{
	use Translatable , HasMediaTrait;
    

    protected $table = 'games';

    protected $fillable = ['game_icon', 'status'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['game_name'];

    /**
     * @var string
     */
    public $translationForeignKey = 'game_id';

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
    public $translationModel = GameTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(GameTranslation::class, 'game_id','id');
    }

     public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }
}