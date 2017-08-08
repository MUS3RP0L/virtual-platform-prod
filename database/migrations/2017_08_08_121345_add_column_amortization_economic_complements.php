<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAmortizationEconomicComplements extends Migration
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
             $table->decimal('amortization', 13, 2)->nullable();
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
             $table->dropColumn('amortization');
        });
    }
}
