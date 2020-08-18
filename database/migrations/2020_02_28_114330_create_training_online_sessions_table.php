<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingOnlineSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_online', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['free', 'paid']);
            $table->decimal('price')->nullable();
            $table->string('currency')->nullable();
            $table->date('session_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('link')->nullable();
            $table->timestamps();
        });

        Schema::create('training_online_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('training_online_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->text('tutor_name');
            $table->string('locale')->index();
            $table->unique(['training_online_id', 'locale']);
            $table->foreign('training_online_id')->references('id')->on('training_online')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_online_translations');
        Schema::dropIfExists('training_online');
    }
}
