<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampospesoColumnsToSgpesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpesos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_finca')->unsigned()->after('id');
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');
            $table->boolean('destetado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpesos', function (Blueprint $table) {
            $table->dropForeign('sgpesos_id_finca_foreign');
            $table->dropColumn('id_finca');
            $table->dropColumn('destetado');
        });
    }
}
