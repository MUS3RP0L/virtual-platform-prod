<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dues', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('devolution_id')->unsigned()->nullable();
            $table->bigInteger('eco_com_procedure_id')->unsigned()->nullable();
            $table->decimal('amount', 13, 2)->nullable();
            $table->foreign('devolution_id')->references('id')->on('devolutions');
            $table->foreign('eco_com_procedure_id')->references('id')->on('eco_com_procedures');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dues');
    }
}
