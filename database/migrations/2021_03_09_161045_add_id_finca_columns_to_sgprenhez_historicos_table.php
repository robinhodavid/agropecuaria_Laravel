<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdFincaColumnsToSgprenhezHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgprenhez_historicos', function (Blueprint $table) {
            $table->integer('id_finca')->unsigned();
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
        Schema::table('sgprenhez_historicos', function (Blueprint $table) {
            $table->dropForeign('sgprenhez_historicos_id_finca_foreign');
            $table->dropColumn('id_finca');
        });
    }
}
