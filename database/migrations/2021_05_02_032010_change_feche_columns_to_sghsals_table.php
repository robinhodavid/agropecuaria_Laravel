<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFecheColumnsToSghsalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghsals', function (Blueprint $table) {
             DB::statement("ALTER TABLE sghsals MODIFY feche date NULL;");
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghsals', function (Blueprint $table) {
            DB::statement("ALTER TABLE sghsals MODIFY feche date NOT NULL;");
        });
    }
}
