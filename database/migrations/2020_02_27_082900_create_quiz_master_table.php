<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('level_id')->unsigned();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->enum('correct_answer',['1','2','3','4'])->default('1');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
        Schema::create('quiz_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('quiz_id')->unsigned();
            $table->text('question');
            $table->string('option1');
            $table->string('option2');
            $table->string('option3');
            $table->string('option4');
            $table->string('locale')->index();
            $table->unique(['quiz_id', 'locale']);
            $table->foreign('quiz_id')->references('id')->on('quiz')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_translations');
        Schema::dropIfExists('quiz');
    }
}
