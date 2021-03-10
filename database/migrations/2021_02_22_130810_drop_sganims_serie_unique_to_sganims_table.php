<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSganimsSerieUniqueToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->dropUnique('sganims_serie_unique'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sganims', function (Blueprint $table) {
           $table->string('serie',50)->unique();
        });
    }
}
