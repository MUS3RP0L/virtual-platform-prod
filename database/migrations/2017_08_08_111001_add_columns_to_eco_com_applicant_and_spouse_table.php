<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToEcoComApplicantAndSpouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_com_applicants',function(Blueprint $table){
            $table->string('death_certificate_number')->nullable();
        });
        Schema::table('spouses',function(Blueprint $table){
            $table->string('death_certificate_number')->nullable();
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
