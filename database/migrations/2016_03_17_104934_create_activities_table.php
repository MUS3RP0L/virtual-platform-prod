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
            $table->UnsignedBigInteger('spouse_id')->nullable();
            $table->UnsignedBigInteger('retirement_fund_id')->nullable();
            $table->UnsignedBigInteger('applicant_id')->nullable();
            $table->UnsignedBigInteger('document_id')->nullable();
            $table->UnsignedBigInteger('antecedent_id')->nullable();
            $table->UnsignedBigInteger('contribution_id')->nullable();
            $table->UnsignedBigInteger('direct_contribution_id')->nullable();
            $table->UnsignedBigInteger('record_id')->nullable();
            $table->UnsignedBigInteger('ipc_rate_id')->nullable();
            $table->UnsignedBigInteger('contribution_rate_id')->nullable();
            $table->UnsignedBigInteger('base_wage_id')->nullable();
            $table->UnsignedBigInteger('complementary_factor_id')->nullable();
            $table->UnsignedBigInteger('economic_complement_id')->nullable();
            $table->UnsignedBigInteger('eco_com_applicant_id')->nullable();
            $table->UnsignedBigInteger('eco_com_submitted_document_id')->nullable();
            $table->text('message')->nullable();
            $table->integer('activity_type_id')->nullable();
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
