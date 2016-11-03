<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRetirementfundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retirement_fund_modalities', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();

        });

        Schema::create('retirement_funds', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('retirement_fund_modality_id')->nullable();
            $table->UnsignedBigInteger('city_id')->nullable();
            $table->string('code')->unique()->required();
            $table->date('reception_date')->nullable();
            $table->date('check_file_date')->nullable();
            $table->date('qualification_date')->nullable();
            $table->date('legal_assessment_date')->nullable();
            $table->date('anticipation_start_date')->nullable();
            $table->date('anticipation_end_date')->nullable();
            $table->date('recognized_start_date')->nullable();
            $table->date('recognized_end_date')->nullable();
            $table->decimal('total_quotable', 13, 2);
            $table->decimal('total_additional_quotable', 13, 2);
            $table->decimal('subtotal', 13, 2);
            $table->decimal('performance', 13, 2);
            $table->decimal('total', 13, 2);
            $table->string('comment');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('retirement_fund_modality_id')->references('id')->on('retirement_fund_modalities');
            $table->foreign('city_id')->references('id')->on('cities');

        });

        Schema::create('requirements', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('retirement_fund_modality_id');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();
            $table->foreign('retirement_fund_modality_id')->references('id')->on('retirement_fund_modalities');

        });

        Schema::create('documents', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('requirement_id');
            $table->UnsignedBigInteger('retirement_fund_id');
            $table->date('reception_date');
            $table->boolean('status')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->foreign('requirement_id')->references('id')->on('requirements');
            $table->foreign('retirement_fund_id')->references('id')->on('retirement_funds')->onDelete('cascade');

        });

        Schema::create('antecedent_files', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();

        });

        Schema::create('antecedents', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('antecedent_file_id');
            $table->UnsignedBigInteger('retirement_fund_id');
            $table->boolean('status')->default(0);
            $table->date('reception_date')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
            $table->foreign('antecedent_file_id')->references('id')->on('antecedent_files');
            $table->foreign('retirement_fund_id')->references('id')->on('retirement_funds')->onDelete('cascade');

        });

        Schema::create('applicant_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('applicants', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('retirement_fund_id');
            $table->UnsignedBigInteger('applicant_type_id');
            $table->string('identity_card')->required();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('kinship')->nullable();
            $table->string('home_address')->nullable();
            $table->string('home_phone_number')->nullable();
            $table->string('home_cell_phone_number')->nullable();
            $table->string('work_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('retirement_fund_id')->references('id')->on('retirement_funds')->onDelete('cascade');
            $table->foreign('applicant_type_id')->references('id')->on('applicant_types');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
        Schema::dropIfExists('applicant_types');
        Schema::dropIfExists('antecedents');
        Schema::dropIfExists('antecedent_files');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('requirements');
        Schema::dropIfExists('retirement_funds');
        Schema::dropIfExists('retirement_fund_modalities');
    }
}
