<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\Translations\QuizTranslation;

class Quiz extends Model
{
    use Translatable;

    protected $table = 'quiz';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['level_id', 'correct_answer', 'status'];

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    public $translatedAttributes = ['question', 'option1', 'option2', 'option3', 'option4'];

    /**
     * @var string
     */
    public $translationForeignKey = 'quiz_id';

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
    public $translationModel = QuizTranslation::class;

    // function for filter records
    public function translation(){
    	return $this->hasMany(QuizTranslation::class, 'quiz_id','id');
    }

    public function level()
    {
        return $this->hasOne(Level::class, 'id' ,'level_id');
    }

}
