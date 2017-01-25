<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {

            $table->increments('id');
            $table->timestamps();
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('spouse_id');
            $table->UnsignedBigInteger('retirement_fund_id');
            $table->UnsignedBigInteger('applicant_id');
            $table->UnsignedBigInteger('document_id');
            $table->UnsignedBigInteger('antecedent_id');
            $table->UnsignedBigInteger('contribution_id');
            $table->UnsignedBigInteger('direct_contribution_id');
            $table->UnsignedBigInteger('record_id');
            $table->UnsignedBigInteger('ipc_rate_id');
            $table->UnsignedBigInteger('contribution_rate_id');
            $table->UnsignedBigInteger('base_wage_id');
            $table->UnsignedBigInteger('complementary_factor_id');
            $table->UnsignedBigInteger('economic_complement_id');
            $table->UnsignedBigInteger('eco_com_applicant_id');
            $table->UnsignedBigInteger('eco_com_submitted_document_id');
            $table->text('message');
            $table->integer('activity_type_id');
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
        Schema::dropIfExists('activities');
    }
}
