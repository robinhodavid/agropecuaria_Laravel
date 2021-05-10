<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSgcelosFproxcelo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgcelos', function (Blueprint $table) {
              DB::statement("ALTER TABLE sgcelos MODIFY fecestprocel date NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgcelos', function (Blueprint $table) {
             DB::statement("ALTER TABLE sgcelos MODIFY fecestprocel integer NOT NULL;");
        });
    }
}
