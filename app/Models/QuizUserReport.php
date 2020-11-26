<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizUserReport extends Model
{
    //
	 protected $table = 'quiz_user_reports';

    /**
     * The localed attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['level_id', 'score', 'user_id' ,'status','useranswer','quizid'];
}
