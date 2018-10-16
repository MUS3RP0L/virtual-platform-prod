<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolutionEcoComProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolution_eco_com_procedure', function (Blueprint $table) {
            $table->bigInteger('devolution_id')->unsigned();
            $table->bigInteger('eco_com_procedure_id')->unsigned();
            $table->foreign('devolution_id')->references('id')->on('devolutions');
            $table->foreign('eco_com_procedure_id')->references('id')->on('eco_com_procedures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devolution_eco_com_procedure');
    }
}
