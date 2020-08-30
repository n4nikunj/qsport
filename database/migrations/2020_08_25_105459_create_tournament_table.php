<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->Integer('country_id')->unsigned();
            $table->string('venue');
            $table->string('hotel_name');
            $table->string('email');
			$table->string('country_code');
			$table->string('phone_number');
			$table->Integer('maximum_Player');
			$table->date('start_date');
			$table->date('end_date');
			$table->string('currency')->nullable();
			$table->decimal('entry_fee');
			$table->decimal('priceMoney');
			$table->decimal('amountPaid');
			$table->enum('status', ['Announced','Running','Elapsed','Cancelled'])->default('Announced');
            $table->enum('watch_live',['yes','no'])->default('no');
			$table->bigInteger('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->timestamps();
        });
		
		 Schema::create('tournament_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('tournament_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('locale')->index();
            $table->unique(['tournament_id', 'locale']);
            $table->foreign('tournament_id')->references('id')->on('tournament')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament');
    }
}
