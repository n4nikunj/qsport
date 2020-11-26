<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizUserReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_user_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
			 $table->bigInteger('user_id')->unsigned();
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		   	 $table->bigInteger('quizid')->unsigned();
           $table->foreign('quizid')->references('id')->on('quiz')->onDelete('cascade');
			$table->string('score');
			$table->string('useranswer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_user_reports');
    }
}
