<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {

        Schema::create('modules', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();

        });

        Schema::create('roles', function(Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('module_id');
            $table->string('name');
            $table->timestamps();
            $table->foreign('module_id')->references('id')->on('modules');

        });

        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->UnsignedBigInteger('role_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('username')->unique();
            $table->string('password', 60);
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('role_id')->references('id')->on('roles');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {

        Schema::dropIfExists('users cascade');
        Schema::dropIfExists('roles cascade');
        Schema::dropIfExists('modules cascade');

    }
}
