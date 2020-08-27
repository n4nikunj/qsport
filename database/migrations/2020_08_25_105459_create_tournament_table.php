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
			$table->string('title');
            $table->string('email');
			$table->string('country_code');
			$table->string('phone_number');
			$table->text('description');
			$table->Integer('maximum_Player');
			$table->date('start_date');
			$table->date('end_date');
			$table->decimal('entry_fee');
			$table->decimal('priceMoney');
			$table->enum('status', ['Announced','Running','Elapsed','Cancelled'])->default('Announced');
            $table->enum('watch_live',['yes','no'])->default('no');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::dropIfExists('tournament');
    }
}
