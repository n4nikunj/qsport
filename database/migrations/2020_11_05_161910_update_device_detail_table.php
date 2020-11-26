<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDeviceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
			  Schema::table('device_detail', function($table) {
			$table->string('push_config')->default('Yes')->after('model_name');
			$table->string('country_name')->default('Kuwait')->after('push_config');
			$table->Integer('country_id')->default(132)->after('country_name');
			$table->string('currency')->default('KWD')->after('country_id');
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
