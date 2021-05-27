<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdCicloColumnsToSgservHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgserv_historicos', function (Blueprint $table) {
            $table->dropForeign('sgserv_historicos_id_ciclo_foreign');
            $table->dropColumn('id_ciclo');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgserv_historicos', function (Blueprint $table) {
            $table->integer('id_ciclo')->unsigned();
            $table->foreign('id_ciclo')
                    ->references('id_ciclo')
                    ->on('sgciclos');
        });
    }
}
