<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDueDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('affiliates', function (Blueprint $table) {
            
            $table->date('due_date')->nullable();
            $table->boolean('is_duedate_undefined')->default(0);
        });

        Schema::table('eco_com_applicants', function (Blueprint $table) {
            
            $table->date('due_date')->nullable();
            $table->boolean('is_duedate_undefined')->default(0);
        });

        Schema::table('spouses', function (Blueprint $table) {
            
            $table->date('due_date')->nullable();
            $table->boolean('is_duedate_undefined')->default(0);
        });

        Schema::table('eco_com_legal_guardians', function (Blueprint $table) {
            
            $table->date('due_date')->nullable();
            $table->boolean('is_duedate_undefined')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
