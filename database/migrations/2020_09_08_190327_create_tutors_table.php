<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('user_id')->unique()->unsigned();
			$table->string('country_code');
			$table->string('phoneno');
            $table->string('email');
			$table->Integer('country_id')->unsigned();
			$table->string('address');
			$table->string('currency')->nullable();
			$table->decimal('rate')->default(0.00);
			$table->string('lat');
			$table->string('long');
			$table->string('facebook')->nullable(); 
			$table->string('youtube')->nullable(); 
			$table->string('twitter')->nullable(); 
			$table->enum('profile_status', ['New','Approved','Rejected'])->default('New');
			$table->enum('status', ['Active','Inactive'])->default('Active');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			 $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->timestamps();
        });
		Schema::create('tutors_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('tutor_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->string('locale')->index();
            $table->unique(['tutor_id', 'locale']);
            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutors_translations');
        Schema::dropIfExists('tutors');
    }
}
