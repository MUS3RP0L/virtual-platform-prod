<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributionratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contribution_rates', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->date('month_year')->unique()->required();
            $table->decimal('retirement_fund', 13, 3);
            $table->decimal('mortuary_quota', 13, 3);
            $table->decimal('retirement_fund_commission', 13, 3);
            $table->decimal('mortuary_quota_commission', 13, 3);
            $table->decimal('mortuary_aid', 13, 3);
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
        Schema::dropIfExists('contribution_rates cascade');
    }
}
