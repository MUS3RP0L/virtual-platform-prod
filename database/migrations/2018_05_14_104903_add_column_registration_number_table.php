<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRegistrationNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('affiliates', function (Blueprint $table) {
            $table->string('affiliate_registration_number')->nullable();
        });
        Schema::table('eco_com_applicants', function (Blueprint $table) {
            $table->string('applicant_registration_number')->nullable();
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
