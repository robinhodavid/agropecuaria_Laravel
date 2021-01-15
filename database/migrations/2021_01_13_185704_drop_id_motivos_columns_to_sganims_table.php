<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdMotivosColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->dropForeign('sganims_id_motivo_salida_foreign');
            $table->dropColumn('id_motivo_salida');
            $table->dropForeign('sganims_id_motivo_entrada_foreign');
            $table->dropColumn('id_motivo_entrada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->integer('id_motivo_entrada')->unsigned();
            $table->foreign('id_motivo_entrada')
                    ->references('id')
                    ->on('sgmotivoentradasalidas');
            $table->integer('id_motivo_salida')->unsigned();
            $table->foreign('id_motivo_salida')
                    ->references('id')
                    ->on('sgmotivoentradasalidas');
        });
    }
}
