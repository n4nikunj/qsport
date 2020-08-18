<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no_of_question')->default(15);
            $table->integer('plus_point_per_que')->default(1);
            $table->integer('minus_point_per_que')->default(1);
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('level_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('level_id')->unsigned();
            $table->string('level_name');
            $table->string('locale')->index();
            $table->unique(['level_id', 'locale']);
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_translations');
        Schema::dropIfExists('levels');
    }
}
