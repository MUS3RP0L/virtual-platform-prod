<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('direct_contributions', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->enum('type',['normal', 'reimbursements'])->default('normal');
            $table->string('code')->unique()->required();
            $table->string('affiliate_name');
            $table->string('affiliate_degree');
            $table->string('affiliate_identity_card');
            $table->string('affiliate_registration');
            $table->decimal('quotable', 13, 2);
            $table->decimal('retirement_fund', 13, 2);
            $table->decimal('mortuary_quota', 13, 2);
            $table->decimal('mortuary_aid', 13, 2);
            $table->decimal('subtotal', 13, 2);
            $table->decimal('ipc', 13, 2);
            $table->decimal('total', 13, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');

        });

        Schema::create('contribution_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('contributions', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('contribution_type_id');
            $table->UnsignedBigInteger('direct_contribution_id')->nullable();
            $table->UnsignedBigInteger('degree_id')->nullable();
            $table->UnsignedBigInteger('unit_id')->nullable();
            $table->UnsignedBigInteger('breakdown_id')->nullable();
            $table->UnsignedBigInteger('category_id')->nullable();
            $table->date('month_year')->required();
            $table->string('item')->nullable();
            $table->decimal('base_wage', 13, 2);
            $table->decimal('dignity_pension', 13, 2)->nullable();
            $table->decimal('seniority_bonus', 13, 2);
            $table->decimal('study_bonus', 13, 2);
            $table->decimal('position_bonus', 13, 2);
            $table->decimal('border_bonus', 13, 2);
            $table->decimal('east_bonus', 13, 2);
            $table->decimal('public_security_bonus', 13, 2)->nullable();
            $table->string('deceased')->nullable();
            $table->string('natality')->nullable();
            $table->string('lactation')->nullable();
            $table->string('prenatal')->nullable();
            $table->decimal('subsidy', 13, 2)->nullable();
            $table->decimal('gain', 13, 2);
            $table->decimal('payable_liquid', 13, 2);
            $table->decimal('quotable', 13, 2);
            $table->decimal('retirement_fund', 13, 2);
            $table->decimal('mortuary_quota', 13, 2);
            $table->decimal('mortuary_aid', 13, 2)->nullable();
            $table->decimal('subtotal', 13, 2)->nullable();
            $table->decimal('ipc', 13, 2)->nullable();
            $table->decimal('total', 13, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('contribution_type_id')->references('id')->on('contribution_types');
            $table->foreign('direct_contribution_id')->references('id')->on('direct_contributions')->onDelete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unique(array('affiliate_id','month_year'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contributions cascade');
        Schema::dropIfExists('contribution_types cascade');
        Schema::dropIfExists('direct_contributions cascade');
    }
}
