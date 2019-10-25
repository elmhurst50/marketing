<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails_sent', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('email_address');
            $table->string('email_class');
            $table->dateTime('queued_at');
            $table->dateTime('sent_at')->nullable();
            $table->boolean('spam')->default(false);
            $table->boolean('opened')->default(false);
            $table->boolean('clicked')->default(false);
            $table->integer('sender_reference')->nullable();
            $table->integer('recipient_reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails_sent');
    }
}
