<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\LevelTranslation;

class Level extends Model
{
    use Translatable;

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['no_of_question', 'plus_point_per_que', 'minus_point_per_que', 'status'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['level_name'];

    /**
     * @var string
     */
    public $translationForeignKey = 'level_id';

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
    public $translationModel = LevelTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(LevelTranslation::class, 'level_id','id');
    }

}
