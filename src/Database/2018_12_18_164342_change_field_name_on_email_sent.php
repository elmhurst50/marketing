<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFieldNameOnEmailSent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails_sent', function (Blueprint $table) {
            $table->renameColumn('email_name', 'email_identifier');
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
            $table->renameColumn('email_identifier', 'email_name');
        });
    }
}
