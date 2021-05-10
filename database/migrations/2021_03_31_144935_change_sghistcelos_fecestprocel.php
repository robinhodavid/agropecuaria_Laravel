<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSghistcelosFecestprocel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghistcelos', function (Blueprint $table) {
             DB::statement("ALTER TABLE sghistcelos MODIFY fecestprocel date NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghistcelos', function (Blueprint $table) {
            DB::statement("ALTER TABLE sghistcelos MODIFY fecestprocel integer NOT NULL;");
        });
    }
}
