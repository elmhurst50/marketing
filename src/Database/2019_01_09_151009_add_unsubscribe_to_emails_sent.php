<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnsubscribeToEmailsSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails_sent', function (Blueprint $table) {
            $table->boolean('unsubscribe_clicked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails_sent', function (Blueprint $table) {
            $table->dropColumn('unsubscribe_clicked');
        });
    }
}
