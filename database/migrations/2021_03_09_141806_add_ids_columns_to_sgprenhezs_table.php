<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdsColumnsToSgprenhezsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgprenhezs', function (Blueprint $table) {
            $table->integer('id_ciclo')->nullable()->after('torotemp');
            $table->integer('id_finca')->unsigned()->after('id_ciclo');
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgprenhezs', function (Blueprint $table) {
            $table->dropForeign('sgprenhezs_id_finca_foreign');
            $table->dropColumn('id_finca');
            $table->dropColumn('id_ciclo');
        });
    }
}
