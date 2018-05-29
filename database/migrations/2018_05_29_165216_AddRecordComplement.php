<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordComplement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('eco_com_records', function (Blueprint $table) {// historial para los tramites de complemento
                $table->bigIncrements('id');
                $table->bigInteger('user_id')->unsigned();
                $table->bigInteger('economic_complement_id')->unsigned();
                $table->string('message')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('economic_complement_id')->references('id')->on('economic_complements');
                $table->timestamps();
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
