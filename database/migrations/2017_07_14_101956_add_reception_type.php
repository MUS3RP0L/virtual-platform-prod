<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReceptionType extends Migration
{
    
    public function up()
    {
         Schema::table('economic_complements', function (Blueprint $table) {            
            
            $table->enum('reception_type', ['Inclusion', 'Habitual'])->required()->default('Inclusion');
            
        });

    }

    
    public function down()
    {
        //
    }
}
