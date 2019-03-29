<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsReplies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_replies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('mobile_number');
            $table->string('reply');
            $table->string('original_message');
            $table->string('replay_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_replies');
    }
}
