<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_sent', function (Blueprint $table) {
            $table->string('sms_identifier');
            $table->string('sms_class');
            $table->dateTime('queued_at');
            $table->dateTime('sent_at');
            $table->integer('residential_customer_id');
            $table->integer('user_id')->nullable()->change();
            $table->integer('sms_template_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_sent', function (Blueprint $table) {
            $table->dropColumn('sms_identifier');
            $table->dropColumn('sms_class');
            $table->dropColumn('queued_at');
            $table->dropColumn('sent_at');
            $table->dropColumn('residential_customer_id');
        });
    }
}
