<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KindOfRent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_com_kind_rent', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::table('economic_complements', function (Blueprint $table) {
             $table->bigInteger('eco_com_kind_rent_id')->nullable();
             $table->foreign('eco_com_kind_rent_id')->references('id')->on('eco_com_kind_rent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_com_kind_rent');
    }
}
