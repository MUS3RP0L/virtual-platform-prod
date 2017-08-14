<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToEcoComApplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eco_com_applicants',function(Blueprint $table){
            $table->bigInteger('city_birth_id')->nullable();
            $table->foreign('city_birth_id')->references('id')->on('cities');
        });
        //
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
