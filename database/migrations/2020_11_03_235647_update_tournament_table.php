<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('tournament', function (Blueprint $table) {
			$table->decimal('entry_fee', 11, 6)->change();
			$table->decimal('priceMoney', 11, 6)->change();
			$table->decimal('amountPaid', 11, 6)->change();
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
