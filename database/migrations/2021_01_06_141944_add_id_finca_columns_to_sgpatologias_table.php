<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdFincaColumnsToSgpatologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpatologias', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_finca')->unsigned()->after('descripcion');
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
        Schema::table('sgpatologias', function (Blueprint $table) {
            $table->dropForeign('sgpatologias_id_finca_foreign');
            $table->dropColumn('id_finca');
        });
    }
}
