<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('cities', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('shortened');
            $table->string('second_shortened');
            $table->string('third_shortened');
            $table->timestamps();

        });

        Schema::create('hierarchies', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('degrees', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('hierarchy_id');
            $table->string('code');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();
            $table->foreign('hierarchy_id')->references('id')->on('hierarchies');

        });

        Schema::create('breakdowns', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('code');
            $table->string('name')->nullable();
            $table->timestamps();

        });

        Schema::create('units', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('breakdown_id');
            $table->string('district');
            $table->string('code');
            $table->string('name');
            $table->string('shortened');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('breakdown_id')->references('id')->on('breakdowns');

        });

        Schema::create('categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->integer('from');
            $table->integer('to');
            $table->string('name');
            $table->decimal('percentage', 13, 2);
            $table->timestamps();

        });

        Schema::create('pension_entities', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->enum('type',['APS', 'SENASIR']);
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('state_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('affiliate_states', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('state_type_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('state_type_id')->references('id')->on('state_types');

        });

        Schema::create('affiliate_types', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('affiliates', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_state_id');
            $table->UnsignedBigInteger('affiliate_type_id');
            $table->UnsignedBigInteger('city_identity_card_id')->nullable();
            $table->UnsignedBigInteger('city_birth_id')->nullable();
            $table->UnsignedBigInteger('degree_id');
            $table->UnsignedBigInteger('unit_id')->nullable();
            $table->UnsignedBigInteger('category_id')->nullable();
            $table->UnsignedBigInteger('pension_entity_id')->nullable();
            $table->string('identity_card')->unique()->required();
            $table->string('registration');
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
            $table->date('service_start_date')->nullable();
            $table->date('service_end_date')->nullable();
            $table->date('change_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('cell_phone_number')->nullable();
            $table->boolean('afp')->nullable();
            $table->bigInteger('nua')->nullable();
            $table->bigInteger('item')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_state_id')->references('id')->on('affiliate_states');
            $table->foreign('affiliate_type_id')->references('id')->on('affiliate_types');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->foreign('city_birth_id')->references('id')->on('cities');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('pension_entity_id')->references('id')->on('pension_entities');

        });

        Schema::create('affiliate_address', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('city_address_id')->nullable();
            $table->string('zone')->nullable();
            $table->string('street')->nullable();
            $table->string('number_address')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('city_address_id')->references('id')->on('cities');

        });

        Schema::create('spouses', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('city_identity_card_id')->nullable();
            $table->string('identity_card')->required();
            $table->string('registration')->required();
            $table->string('last_name')->nullable();
            $table->string('mothers_last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('second_name')->nullable();
            $table->string('surname_husband')->nullable();
            $table->date('birth_date')->nullable();
            $table->date('date_death')->nullable();
            $table->string('reason_death')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('city_identity_card_id')->references('id')->on('cities');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');

        });

        Schema::create('records', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('affiliate_state_id')->nullable();
            $table->UnsignedBigInteger('degree_id')->nullable();
            $table->UnsignedBigInteger('unit_id')->nullable();
            $table->date('date');
            $table->integer('type_id');
            $table->string('message');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');

        });

        Schema::create('observations', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('affiliate_id');
            $table->UnsignedBigInteger('module_id');
            $table->date('date');
            $table->string('title');
            $table->string('message');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('affiliate_id')->references('id')->on('affiliates')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('observations');
        Schema::dropIfExists('records');
        Schema::dropIfExists('spouses');
        Schema::dropIfExists('affiliate_address');
        Schema::dropIfExists('affiliates');
        Schema::dropIfExists('affiliate_types');
        Schema::dropIfExists('affiliate_states');
        Schema::dropIfExists('state_types');
        Schema::dropIfExists('pension_entities');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('units');
        Schema::dropIfExists('breakdowns');
        Schema::dropIfExists('degrees');
        Schema::dropIfExists('hierarchies');
        Schema::dropIfExists('cities');
    }
}
