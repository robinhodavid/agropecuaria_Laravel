<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCicloColumnsToSghistoricotempreprosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_ciclo')->unsigned()->after('nropart');
            $table->foreign('id_ciclo')->references('id_ciclo')->on('sgciclos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->dropForeign('sghistoricotemprepros_id_ciclo_foreign');
            $table->dropColumn('id_ciclo');
        });
    }
}
