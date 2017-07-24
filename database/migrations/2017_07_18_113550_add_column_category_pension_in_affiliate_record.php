<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCategoryPensionInAffiliateRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('affiliate_records', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->default(0);
            $table->unsignedInteger('pension_entity_id')->default(0);
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
         Schema::table('affiliate_records', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('pension_entity_id');
        });

    }
}
