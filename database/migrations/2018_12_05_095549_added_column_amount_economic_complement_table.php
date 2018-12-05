<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedColumnAmountEconomicComplementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('economic_complements', function (Blueprint $table) {
            $table->decimal('amount_credit', 13, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('economic_complements', function (Blueprint $table) {
            $table->dropColumn('amount_credit');
        });
    }
}
