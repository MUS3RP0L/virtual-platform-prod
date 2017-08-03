<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEconApplicant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add column date_death and reason_death
        Schema::table('eco_com_applicants',function(Blueprint $table){
            $table->string('date_death',255)->after('birth_date')->nullable();
            $table->string('reason_death',255)->after('date_death')->nullable();
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
