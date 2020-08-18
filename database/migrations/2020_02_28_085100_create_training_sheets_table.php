<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['free', 'paid']);
            $table->text('formula');
            $table->decimal('price')->nullable();
            $table->string('currency')->nullable();
            $table->timestamps();
        });

        Schema::create('training_sheet_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('training_sheet_id')->unsigned();
            $table->string('title');
            $table->text('drill_instructions');
            $table->string('locale')->index();
            $table->unique(['training_sheet_id', 'locale']);
            $table->foreign('training_sheet_id')->references('id')->on('training_sheets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_sheet_translations');
        Schema::dropIfExists('training_sheets');
    }
}
