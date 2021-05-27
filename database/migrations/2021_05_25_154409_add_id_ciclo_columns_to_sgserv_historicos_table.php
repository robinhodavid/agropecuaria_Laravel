<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCicloColumnsToSgservHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgserv_historicos', function (Blueprint $table) {
            $table->integer('id_ciclo')->nullable()->after('id_tipologia'); 
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
            $table->dropColumn('id_ciclo');
        });
    }
}
