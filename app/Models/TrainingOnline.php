<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\TrainingOnlineTranslation;

class TrainingOnline extends Model implements HasMedia
{
    use HasMediaTrait, Translatable;

    protected $table = 'training_online';
    protected $fillable = ['type', 'price', 'currency', 'session_date', 'start_time', 'end_time', 'link'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description', 'tutor_name'];

    /**
     * @var string
     */
    public $translationForeignKey = 'training_online_id';

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
    public $translationModel = TrainingOnlineTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(TrainingOnlineTranslation::class, 'training_online_session_id','id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(1200)
            ->height(800);
    }
}
