<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEconomicComplementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eco_com_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('eco_com_modalities', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('eco_com_type_id');
            $table->string('name');
            $table->string('shortened');
            $table->string('description');
            $table->timestamps();
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');

        });

        Schema::create('eco_com_state_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('eco_com_states', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('eco_com_state_type_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('eco_com_state_type_id')->references('id')->on('eco_com_state_types');


        });

        Schema::create('eco_com_rents', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('degree_id');
            $table->UnsignedBigInteger('eco_com_type_id');
            $table->date('month_year')->required();
            $table->enum('semester', ['F', 'S'])->required();
            $table->decimal('minor', 13, 2);
            $table->decimal('higher', 13, 2);
            $table->decimal('average', 13, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');

        });

        Schema::create('complementary_factors', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('hierarchy_id');
            $table->date('year')->required();
            $table->enum('semester', ['Primer', 'Segundo'])->required();
            $table->decimal('old_age', 13, 2);
            $table->decimal('widowhood', 13, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');

        });

        Schema::create('economic_complements', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('eco_com_modality_id');
            $table->UnsignedBigInteger('eco_com_state_id');
            $table->UnsignedBigInteger('city_id');
            $table->UnsignedBigInteger('category_id');

            $table->UnsignedBigInteger('base_wage_id')->nullable();
            $table->UnsignedBigInteger('complementary_factor_id')->nullable();

            $table->date('first_ticket_month_id')->nullable();
            $table->date('second_ticket_month_id')->nullable();

            $table->boolean('has_legal_guardian')->default(0);

            $table->string('code')->unique()->required();
            $table->date('reception_date')->nullable();
            $table->date('review_date')->nullable();
            $table->date('year')->required();
            $table->enum('semester', ['Primer', 'Segundo']);

            $table->decimal('sub_total_rent', 13, 2)->nullable();
            $table->decimal('reimbursement_basic_pension', 13, 2)->nullable();
            $table->decimal('dignity_pension', 13, 2)->nullable();
            $table->decimal('dignity_pension_reimbursement', 13, 2)->nullable();
            $table->decimal('dignity_pension_bonus', 13, 2)->nullable();
            $table->decimal('bonus_reimbursement', 13, 2)->nullable();
            $table->decimal('reimbursement_aditional_amount', 13, 2)->nullable();
            $table->decimal('reimbursement_increase_year', 13, 2)->nullable();

            $table->decimal('reimbursement', 13, 2)->nullable();
            $table->decimal('christmas_bonus', 13, 2)->nullable();
            $table->decimal('seniority', 13, 2)->nullable();
            $table->decimal('quotable', 13, 2)->nullable();
            $table->decimal('total', 13, 2)->nullable();

            $table->date('payment_date')->nullable();
            $table->string('payment_number')->nullable();

            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('eco_com_modality_id')->references('id')->on('eco_com_modalities');
            $table->foreign('eco_com_state_id')->references('id')->on('eco_com_states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('base_wage_id')->references('id')->on('base_wages');
            $table->foreign('complementary_factor_id')->references('id')->on('complementary_factors');


        });

        Schema::create('eco_com_requirements', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('eco_com_type_id');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');

        });

        Schema::create('eco_com_submitted_documents', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('economic_complement_id');
            $table->UnsignedBigInteger('eco_com_requirement_id');
            $table->date('reception_date');
            $table->boolean('status')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('eco_com_requirement_id')->references('id')->on('eco_com_requirements');

        });

        Schema::create('eco_com_applicant_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('eco_com_applicants', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('economic_complement_id');
            $table->UnsignedBigInteger('eco_com_applicant_type_id');
            $table->UnsignedBigInteger('city_identity_card_id')->nullable();
            $table->string('identity_card')->required()->nullable();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->date('birth_date')->nullable();
            $table->bigInteger('nua')->nullable();
            $table->enum('gender', ['M', 'F']);
            $table->enum('civil_status', ['C', 'S', 'V', 'D'])->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('eco_com_applicant_type_id')->references('id')->on('eco_com_applicant_types');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');

        });

        Schema::create('eco_com_legal_guardians', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('eco_com_applicant_id')->index();
            $table->UnsignedBigInteger('city_identity_card_id')->nullable();
            $table->string('identity_card')->required();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('eco_com_applicant_id')->references('id')->on('eco_com_applicants')->onDelete('cascade');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');

        });

        Schema::create('eco_com_records', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('economic_complement_id');
            $table->date('date');
            $table->integer('type');
            $table->string('message');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_com_records');
        Schema::dropIfExists('eco_com_legal_guardians');
        Schema::dropIfExists('eco_com_applicants');
        Schema::dropIfExists('eco_com_applicant_types');
        Schema::dropIfExists('eco_com_submitted_documents');
        Schema::dropIfExists('eco_com_requirements');
        Schema::dropIfExists('economic_complements');
        Schema::dropIfExists('complementary_factors');
        Schema::dropIfExists('eco_com_rents');
        Schema::dropIfExists('eco_com_states');
        Schema::dropIfExists('eco_com_state_types');
        Schema::dropIfExists('eco_com_modalities');
        Schema::dropIfExists('eco_com_types');
    }
}
