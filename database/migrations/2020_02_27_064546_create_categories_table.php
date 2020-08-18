<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', [1,0])->default(1);
            $table->timestamps();
        });

        Schema::table('categories', function($table) {
            $table->bigInteger('parent_id')->nullable()->unsigned()->after('id');
            $table->foreign('parent_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade'); 
        });

        Schema::create('category_translations', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('category_id')->unsigned();
            $table->longText('name');
            $table->string('locale')->index();
            $table->unique(['category_id', 'locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
