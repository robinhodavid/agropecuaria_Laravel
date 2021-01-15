<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSglotesFuncionString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sglotes', function (Blueprint $table) {
           DB::statement("ALTER TABLE sglotes MODIFY funcion varchar(180) NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sglotes', function (Blueprint $table) {
           DB::statement("ALTER TABLE sglotes MODIFY funcion varchar(180) NULL;");
        });
    }
}
