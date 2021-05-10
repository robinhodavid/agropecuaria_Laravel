<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCodpColumnsToSgdatosvidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgdatosvidas', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgdatosvidas MODIFY codp varchar(55) NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgdatosvidas', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgdatosvidas MODIFY codp varchar(50) NOT NULL;");
        });
    }
}
