<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_channels', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('created_by');
			$table->string('joined_by');
			$table->string('create_chat_module');
			$table->string('channel_unique_name');
			$table->string('last_message');
			$table->string('last_message_date');
			$table->string('channel_sid');
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
        Schema::dropIfExists('chat_channels');
    }
}
