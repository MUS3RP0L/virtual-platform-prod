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
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('observation_type_id')->unsigned();
            $table->decimal('amount', 13, 2);
            $table->decimal('balance', 13, 2);
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
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
        Schema::dropIfExists('dues');
    }
}
