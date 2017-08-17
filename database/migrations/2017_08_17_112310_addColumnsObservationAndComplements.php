<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsObservationAndComplements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('economic_complements', function (Blueprint $table) {
             $table->decimal('amount_loan', 13, 2)->nullable();//prestamos
             $table->decimal('amount_accounting', 13, 2)->nullable();//contabilidad
             $table->decimal('amount_replacement', 13, 2)->nullable();//recepcion
        });

        Schema::table('affiliate_observations', function (Blueprint $table) {
             $table->boolean('isEnabled', 13, 2)->default(0);//estaHabilitado
   
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
        Schema::table('economic_complements', function (Blueprint $table) {
             $table->dropColumn('amount_loan');//prestamos
             $table->dropColumn('amount_accounting');//contabilidad
             $table->dropColumn('amount_replacement');//recepcion
        });

        Schema::table('affiliate_observations', function (Blueprint $table) {
             $table->dropColumn('isEnabled');//estaHabilitado
   
        });
    }
}
