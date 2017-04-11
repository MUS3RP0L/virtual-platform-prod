<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpcratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('ipc_rates', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->date('month_year')->unique()->required();
            $table->decimal('index', 13, 3);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipc_rates cascade');
    }
}
