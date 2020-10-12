<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolHallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
		Schema::create('pool_hall', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('email');
			$table->string('country_code');
			$table->string('phone_number');
			$table->Integer('country_id')->unsigned();
            $table->string('social_media_link');
            $table->Integer('number_of_tables');
			$table->string('types_of_tables');
            $table->decimal('price');
			$table->time('start_time');
			$table->time('end_time');
			$table->enum('status',['active','inactive'])->default('active');
			$table->bigInteger('created_by')->unsigned()->nullable();
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
			$table->timestamps();
        });
		
		Schema::create('pool_hall_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('pool_hall_id')->unsigned();
            $table->string('title');
			$table->text('description');
			$table->text('address');
            $table->string('locale')->index();
            $table->unique(['pool_hall_id', 'locale']);
            $table->foreign('pool_hall_id')->references('id')->on('pool_hall')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_hall_translations');
        Schema::dropIfExists('pool_hall');
    }
}
