<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnJsonToEcoComTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('economic_complements', function (Blueprint $table) {
            $table->date('recalification_date')->nullable();
            $table->json('old_eco_com')->nullable();
            $table->decimal('total_repay', 13, 2)->nullable();
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
