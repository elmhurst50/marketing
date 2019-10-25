<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustEmailsSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails_sent', function (Blueprint $table) {
            $table->integer('opened')->change();
            $table->integer('clicked')->change();
            $table->string('provider_status')->nullable();
            $table->string('sender');
            $table->string('subject');
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
            $table->boolean('opened')->change();
            $table->boolean('clicked')->change();
            $table->dropColumn('provider_status');
            $table->dropColumn('sender');
            $table->dropColumn('subject');
        });
    }
}
