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

        Schema::create('eco_com_factors', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('hierarchy_id');
            $table->date('year')->required();
            $table->enum('semester', ['F', 'S'])->required();
            $table->decimal('old_age', 13, 2);
            $table->decimal('widowhood', 13, 2);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');

        });

        Schema::create('economic_complements', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('eco_com_modality_id');
            $table->UnsignedBigInteger('eco_com_state_id');
            $table->UnsignedBigInteger('city_id');
            $table->UnsignedBigInteger('category_id');
            $table->UnsignedBigInteger('base_wage_id')->nullable();
            $table->UnsignedBigInteger('eco_com_factor_id')->nullable();

            $table->date('first_ticket_month_id')->nullable();
            $table->date('second_ticket_month_id')->nullable();

            $table->string('code')->unique()->required();
            $table->date('reception_date')->nullable();
            $table->date('review_date')->nullable();
            $table->enum('semester', ['F', 'S']);

            $table->decimal('sub_total_rent', 13, 2);
            $table->decimal('dignity_pension', 13, 2);
            $table->decimal('reimbursement', 13, 2);
            $table->decimal('christmas_bonus', 13, 2);
            $table->decimal('seniority', 13, 2);
            $table->decimal('quotable', 13, 2);

            $table->decimal('total', 13, 2);

            $table->string('comment');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('eco_com_modality_id')->references('id')->on('eco_com_modalities');
            $table->foreign('eco_com_state_id')->references('id')->on('eco_com_states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('base_wage_id')->references('id')->on('base_wages');
            $table->foreign('eco_com_factor_id')->references('id')->on('economic_complements');


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
            $table->UnsignedBigInteger('eco_com_requirements');
            $table->UnsignedBigInteger('economic_complement_id');
            $table->date('reception_date');
            $table->boolean('status')->default(0);
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('eco_com_requirements')->references('id')->on('eco_com_requirements');
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');

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
            $table->foreign('economic_complement_id')->references('id')->on('economic_complements')->onDelete('cascade');
            $table->foreign('eco_com_applicant_type_id')->references('id')->on('eco_com_applicant_types');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eco_com_applicants');
        Schema::dropIfExists('eco_com_applicant_types');
        Schema::dropIfExists('eco_com_submitted_documents');
        Schema::dropIfExists('eco_com_requirements');
        Schema::dropIfExists('economic_complements');
        Schema::dropIfExists('eco_com_factors');
        Schema::dropIfExists('eco_com_rents');
        Schema::dropIfExists('eco_com_states');
        Schema::dropIfExists('eco_com_state_types');
        Schema::dropIfExists('eco_com_modalities');
        Schema::dropIfExists('eco_com_types');
    }
}
