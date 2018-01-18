<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedCascadeDeleteDuestable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE dues DROP CONSTRAINT dues_devolution_id_foreign");
        DB::statement("ALTER TABLE dues ADD CONSTRAINT dues_devolution_id_foreign FOREIGN KEY (devolution_id) REFERENCES devolutions(id) ON DELETE CASCADE;");
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
