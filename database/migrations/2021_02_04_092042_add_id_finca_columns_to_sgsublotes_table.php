<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdFincaColumnsToSgsublotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgsublotes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_finca')->unsigned()->after('sub_lote');
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
        Schema::table('sgsublotes', function (Blueprint $table) {
            $table->dropForeign('sgsublotes_id_finca_foreign');
            $table->dropColumn('id_finca');
        });
    }
}
