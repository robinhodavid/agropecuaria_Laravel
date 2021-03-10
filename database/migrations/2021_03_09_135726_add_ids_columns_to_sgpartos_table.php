<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdsColumnsToSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->integer('id_ciclo')->nullable()->after('nciclo');
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
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->dropForeign('sgpartos_id_finca_foreign');
            $table->dropColumn('id_finca');
            $table->dropColumn('id_ciclo');
        });
    }
}
