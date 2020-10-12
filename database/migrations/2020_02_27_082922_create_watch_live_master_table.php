<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchLiveMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watch_live', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('price');
            $table->string('currency');
            $table->string('online_link');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
        Schema::create('watch_live_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('watch_live_id')->unsigned();
            $table->string('match_name');
            $table->string('locale')->index();
            $table->unique(['watch_live_id', 'locale']);
            $table->foreign('watch_live_id')->references('id')->on('watch_live')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('watch_live_translations');
        Schema::dropIfExists('watch_live');
    }
}
