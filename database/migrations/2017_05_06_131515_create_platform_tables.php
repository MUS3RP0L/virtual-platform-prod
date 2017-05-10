<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
        });
      
        Schema::create('workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('module_id')->unsigned();
            $table->string('name');
            $table->string('description');
            $table->foreign('module_id')->references('id')->on('modules');
        });
      
        Schema::create('roles', function (Blueprint $table) {   
            $table->bigIncrements('id');
            $table->bigInteger('module_id')->unsigned();
            $table->string('name');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->rememberToken();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_id')->references('id')->on('users');
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('wf_step_types', function (Blueprint $table) {   
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
        });
      
        Schema::create('wf_steps', function (Blueprint $table) {    
            $table->bigIncrements('id');
            $table->bigInteger('workflow_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('wf_step_type_id')->unsigned();
            $table->string('name');
            $table->foreign('workflow_id')->references('id')->on('workflows');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('wf_step_type_id')->references('id')->on('wf_step_types');
        });
        
        Schema::create('wf_sequences', function (Blueprint $table) {    
            $table->bigIncrements('id');
            $table->bigInteger('workflow_id')->unsigned();
            $table->bigInteger('wf_step_current_id');
            $table->bigInteger('wf_step_next_id');
            $table->foreign('workflow_id')->references('id')->on('workflows');
            $table->timestamps();
        });
        
        Schema::create('wf_records', function (Blueprint $table) {  
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('wf_step_id');   
            $table->bigInteger('eco_com_id')->nullable();
            $table->bigInteger('ret_fun_id')->nullable();
            $table->longText('message');
            //other wf's
            $table->timestamps();
        });
        
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('first_shortened');
            $table->string('second_shortened');
            $table->string('third_shortened');
        });

        Schema::create('hierarchies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
        });

        Schema::create('degrees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hierarchy_id')->unsigned();
            $table->string('code');
            $table->string('name');
            $table->string('shortened');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');
        });

        Schema::create('breakdowns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code');
            $table->string('name');
        });

        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('breakdown_id')->unsigned();
            $table->string('district');
            $table->string('code');
            $table->string('name');
            $table->string('shortened');
            $table->foreign('breakdown_id')->references('id')->on('breakdowns');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from');
            $table->integer('to');
            $table->string('name');
            $table->decimal('percentage', 13, 2);
        });

        Schema::create('pension_entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',['APS', 'SENASIR']);
            $table->string('name');
        });

        Schema::create('affiliate_state_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('affiliate_states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('affiliate_state_type_id')->unsigned();
            $table->string('name');
            $table->foreign('affiliate_state_type_id')->references('id')->on('affiliate_state_types');
        });
       
        Schema::create('affiliates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_state_id')->unsigned();
            $table->bigInteger('city_identity_card_id')->unsigned()->nullable();
            $table->bigInteger('city_birth_id')->unsigned()->nullable();
            $table->bigInteger('degree_id')->unsigned();
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('pension_entity_id')->unsigned()->nullable();
            $table->string('identity_card')->unique()->required();
            $table->string('registration');
            $table->enum('type',['C', 'B']);
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->enum('gender', ['M', 'F']);
            $table->enum('civil_status', ['C', 'S', 'V', 'D']);
            $table->date('birth_date')->nullable();
            $table->date('date_entry')->nullable();
            $table->string('date_death')->nullable();
            $table->string('reason_death')->nullable();
            $table->date('date_derelict')->nullable();
            $table->string('reason_derelict')->nullable();
            $table->date('change_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->boolean('afp')->nullable();
            $table->bigInteger('nua')->nullable();
            $table->bigInteger('item')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_state_id')->references('id')->on('affiliate_states');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->foreign('city_birth_id')->references('id')->on('cities');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('pension_entity_id')->references('id')->on('pension_entities');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('affiliate_address', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('city_address_id')->unsigned()->nullable();
            $table->string('zone')->nullable();
            $table->string('street')->nullable();
            $table->string('number_address')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('city_address_id')->references('id')->on('cities');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('spouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('city_identity_card_id')->unsigned()->nullable();
            $table->string('identity_card')->required();
            $table->string('registration')->required();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->enum('civil_status', ['C', 'S', 'V', 'D'])->nullable();
            $table->date('birth_date')->nullable();
            $table->date('date_death')->nullable();
            $table->string('reason_death')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('affiliate_records', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('affiliate_state_id')->unsigned()->nullable();
            $table->bigInteger('degree_id')->unsigned()->nullable();
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->date('date');
            $table->integer('type_id');
            $table->string('message');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
                    
        Schema::create('affiliate_observations', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('module_id')->unsigned();
            $table->date('date');
            $table->string('title');
            $table->string('description');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->timestamps();
            $table->softDeletes();
        });
      
        Schema::create('direct_contributions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->enum('type',['normal', 'reimbursement'])->default('normal');
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
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('contributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('direct_contribution_id')->unsigned()->nullable();
            $table->bigInteger('degree_id')->unsigned()->nullable();
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->bigInteger('breakdown_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
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
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('direct_contribution_id')->references('id')->on('direct_contributions')->onDelete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unique(['affiliate_id','month_year']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ipc_rates', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->date('month_year')->unique()->required();
            $table->decimal('index', 13, 3);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('contribution_rates', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->date('month_year')->unique()->required();
            $table->decimal('retirement_fund', 13, 3);
            $table->decimal('mortuary_quota', 13, 3);
            $table->decimal('retirement_fund_commission', 13, 3);
            $table->decimal('mortuary_quota_commission', 13, 3);
            $table->decimal('mortuary_aid', 13, 3);
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('base_wages', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('degree_id')->unsigned();
            $table->date('month_year')->required();
            $table->decimal('amount', 13, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('spouse_id')->unsigned()->nullable();
            $table->bigInteger('retirement_fund_id')->unsigned()->nullable();
            $table->bigInteger('ret_fun_applicant_id')->unsigned()->nullable();
            $table->bigInteger('ret_fun_submitted_document_id')->unsigned()->nullable();
            $table->bigInteger('ret_fun_antecedent_id')->unsigned()->nullable();
            $table->bigInteger('contribution_id')->unsigned()->nullable();
            $table->bigInteger('direct_contribution_id')->unsigned()->nullable();
            $table->bigInteger('record_id')->unsigned()->nullable();
            $table->bigInteger('ipc_rate_id')->unsigned()->nullable();
            $table->bigInteger('contribution_rate_id')->unsigned()->nullable();
            $table->bigInteger('base_wage_id')->unsigned()->nullable();
            $table->bigInteger('complementary_factor_id')->unsigned()->nullable();
            $table->bigInteger('economic_complement_id')->unsigned()->nullable();
            $table->bigInteger('eco_com_applicant_id')->unsigned()->nullable();
            $table->bigInteger('eco_com_submitted_document_id')->unsigned()->nullable();
            $table->text('message')->nullable();
            $table->integer('activity_type_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('reimbursements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('direct_contribution_id')->unsigned()->nullable();
            $table->date('month_year')->required();
            $table->decimal('base_wage', 13, 2);
            $table->decimal('seniority_bonus', 13, 2);
            $table->decimal('study_bonus', 13, 2);
            $table->decimal('position_bonus', 13, 2);
            $table->decimal('border_bonus', 13, 2);
            $table->decimal('east_bonus', 13, 2);
            $table->decimal('public_security_bonus', 13, 2)->nullable();
            $table->decimal('gain', 13, 2);
            $table->decimal('payable_liquid', 13, 2);
            $table->decimal('quotable', 13, 2);
            $table->decimal('retirement_fund', 13, 2);
            $table->decimal('mortuary_quota', 13, 2);
            $table->decimal('mortuary_aid', 13, 2);
            $table->decimal('subtotal', 13, 2)->nullable();
            $table->decimal('ipc', 13, 2)->nullable();
            $table->decimal('total', 13, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('direct_contribution_id')->references('id')->on('direct_contributions')->onDelete('cascade');
            $table->unique(['affiliate_id','month_year']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('voucher_types', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('voucher_type_id')->unsigned();
            $table->bigInteger('direct_contribution_id')->unsigned()->nullable();
            $table->string('code')->unique()->required();
            $table->decimal('total', 13, 2);
            $table->date('payment_date')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types');
            $table->timestamps();
            $table->softDeletes();
        });

      /*
        Begin Economic complement
      */
        Schema::create('eco_com_types', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
        });

        Schema::create('eco_com_modalities', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('eco_com_type_id')->unsigned();
            $table->string('name');
            $table->string('shortened');
            $table->string('description');
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');
        });

        Schema::create('eco_com_rents', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('degree_id')->unsigned();
            $table->bigInteger('eco_com_type_id')->unsigned();
            $table->date('year')->required();
            $table->enum('semester', ['Primer', 'Segundo'])->required();
            $table->decimal('minor', 13, 2);
            $table->decimal('higher', 13, 2);
            $table->decimal('average', 13, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');
            $table->unique(['year','semester']);
            $table->timestamps();
        });

        Schema::create('complementary_factors', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('hierarchy_id')->unsigned();
            $table->date('year')->required();
            $table->enum('semester', ['Primer', 'Segundo'])->required();
            $table->decimal('old_age', 13, 2);
            $table->decimal('widowhood', 13, 2);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');
            $table->timestamps();
        });

        Schema::create('economic_complements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('affiliate_id')->unsigned();
            $table->bigInteger('eco_com_modality_id')->unsigned();
            $table->bigInteger('wf_step_id')->unsigned();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('base_wage_id')->nullable()->unsigned();
            $table->bigInteger('complementary_factor_id')->unsigned()->nullable();
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
            $table->decimal('total_rent', 13, 2)->nullable();
            $table->decimal('total_rent_calc', 13, 2)->nullable();
            $table->decimal('salary_reference', 13, 2)->nullable();
            $table->decimal('seniority', 13, 2)->nullable();
            $table->decimal('salary_quotable', 13, 2)->nullable();
            $table->decimal('difference', 13, 2)->nullable();
            $table->decimal('total_amount_semester', 13, 2)->nullable();
            $table->decimal('complementary_factor', 13, 2)->nullable();
            $table->decimal('reimbursement', 13, 2)->nullable();
            $table->decimal('christmas_bonus', 13, 2)->nullable();
            $table->decimal('quotable', 13, 2)->nullable();
            $table->decimal('total', 13, 2)->nullable();
            $table->date('payment_date')->nullable();
            $table->string('payment_number')->nullable();
            $table->text('comment')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('eco_com_modality_id')->references('id')->on('eco_com_modalities');
            $table->foreign('wf_step_id')->references('id')->on('wf_steps');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('base_wage_id')->references('id')->on('base_wages');
            $table->foreign('complementary_factor_id')->references('id')->on('complementary_factors');
            $table->timestamps();
            +$table->softDeletes();
        });

        Schema::create('eco_com_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('eco_com_type_id')->unsigned();
            $table->string('name');
            $table->string('shortened');
            $table->foreign('eco_com_type_id')->references('id')->on('eco_com_types');
            $table->timestamps();
        });
                
        Schema::create('eco_com_submitted_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('economic_complement_id')->unsigned();
            $table->bigInteger('eco_com_requirement_id')->unsigned();
            $table->date('reception_date');
            $table->boolean('status')->default(0);
            $table->string('comment')->nullable();
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('eco_com_requirement_id')->references('id')->on('eco_com_requirements');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('eco_com_applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('economic_complement_id')->unsigned();
            $table->bigInteger('city_identity_card_id')->unsigned()->nullable();
            $table->string('identity_card')->required();
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
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('eco_com_legal_guardians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('economic_complement_id')->unsigned()->index();
            $table->bigInteger('city_identity_card_id')->unsigned()->nullable();
            $table->string('identity_card')->required();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->foreign('economic_comlement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_com_legal_guardians');
        Schema::dropIfExists('eco_com_applicants');
        Schema::dropIfExists('eco_com_submitted_documents');
        Schema::dropIfExists('eco_com_requirements');
        Schema::dropIfExists('economic_complements');
        Schema::dropIfExists('complementary_factors');
        Schema::dropIfExists('eco_com_rents');
        Schema::dropIfExists('eco_com_modalities');
        Schema::dropIfExists('eco_com_types');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('voucher_types');
        Schema::dropIfExists('reimbursements');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('base_wages');
        Schema::dropIfExists('contribution_rates');
        Schema::dropIfExists('ipc_rates');
        Schema::dropIfExists('contributions');
        Schema::dropIfExists('direct_contributions');
        Schema::dropIfExists('affiliate_observations');
        Schema::dropIfExists('affiliate_records');
        Schema::dropIfExists('spouses');
        Schema::dropIfExists('affiliate_address');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('affiliate_states');
        Schema::dropIfExists('affiliate_state_types');
        Schema::dropIfExists('pension_entities');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('units');
        Schema::dropIfExists('breakdowns');
        Schema::dropIfExists('degrees');        
        Schema::dropIfExists('hierarchies');
        Schema::dropIfExists('cities');      
        Schema::dropIfExists('wf_records');
        Schema::dropIfExists('wf_sequences');
        Schema::dropIfExists('wf_steps');
        Schema::dropIfExists('wf_step_types');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('workflows');
        Schema::dropIfExists('modules');
    }
}
