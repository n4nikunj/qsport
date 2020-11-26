<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductTableForExtrafield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::table('products', function($table) {
			$table->string('country')->nullable()->after('user_id');
			$table->string('location')->nullable()->after('country');
			$table->string('country_code')->nullable()->after('location');
			$table->string('phoneNumber')->nullable()->after('country_code');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
