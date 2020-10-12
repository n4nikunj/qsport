<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('website');
            $table->string('country_code');
			$table->string('phone_number');
            $table->string('email');
            $table->enum('sponsors_category', ['Standard','Premium'])->default('Standard');
            $table->enum('status', ['Active','Inactive'])->default('Active');
			$table->decimal('amountPaid')->default(0.00);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        //Schema::dropIfExists('sponsors');
    }
}
