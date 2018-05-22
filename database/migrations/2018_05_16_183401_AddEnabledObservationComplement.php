<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnabledObservationComplement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('eco_com_observations', function (Blueprint $table) {
            $table->boolean('is_enabled')->default(false);
            $table->renameColumn('economic_omplement_id', 'economic_complement_id');            
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
