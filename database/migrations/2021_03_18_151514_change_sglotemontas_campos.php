<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSglotemontasCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sglotemontas', function (Blueprint $table) {
            DB::statement("ALTER TABLE sglotemontas MODIFY anho1 varchar(4) NOT NULL;");
            DB::statement("ALTER TABLE sglotemontas MODIFY anho2 varchar(4) NOT NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sglotemontas', function (Blueprint $table) {
            DB::statement("ALTER TABLE sglotemontas MODIFY anho1 date NOT NULL;");
            DB::statement("ALTER TABLE sglotemontas MODIFY anho2 date NOT NULL;");
        });
    }
}
