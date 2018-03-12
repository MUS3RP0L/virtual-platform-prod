<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReimbursements extends Migration
{
  
    public function up()
    {   
        Schema::dropIfExists('reimbursements');
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('degree_id')->unsigned()->nullable();
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->bigInteger('breakdown_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->date('month_year');
            $table->string('item')->nullable();
            $table->enum('type',['Planilla', 'Directo']);
            $table->decimal('base_wage', 13, 2);
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
            $table->decimal('subtotal', 13, 2)->nullable();
            $table->decimal('ipc', 13, 2)->nullable();
            $table->decimal('total', 13, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->unique(['affiliate_id','month_year']);
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('breakdown_id')->references('id')->on('breakdowns');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    
    public function down()
    {
        Schema::dropIfExists('reimbursements');
    }
}
