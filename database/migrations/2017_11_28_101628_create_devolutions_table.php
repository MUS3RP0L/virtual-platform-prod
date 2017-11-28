<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('affiliate_id')->unsigned()->nullable();
            $table->bigInteger('observation_type_id')->unsigned()->nullable();
            $table->bigInteger('start_eco_com_procedure_id')->unsigned()->nullable();
            $table->decimal('total', 13, 2)->nullable();
            $table->decimal('balance', 13, 2)->nullable();
            $table->string('deposit_number')->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('percentage', 13, 2)->nullable();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('start_eco_com_procedure_id')->references('id')->on('eco_com_procedures');
            $table->foreign('observation_type_id')->references('id')->on('observation_types');
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
        Schema::drop('devolutions');
    }
}
