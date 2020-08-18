<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\TrainingSheetTranslation;

class TrainingSheet extends Model implements HasMedia
{
	use HasMediaTrait, Translatable;

    protected $table = 'training_sheets';
    protected $fillable = ['type', 'formula', 'price', 'currency'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'drill_instructions'];

    /**
     * @var string
     */
    public $translationForeignKey = 'training_sheet_id';

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
    public $translationModel = TrainingSheetTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(TrainingSheetTranslation::class, 'training_sheet_id','id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(400);
    }
}
