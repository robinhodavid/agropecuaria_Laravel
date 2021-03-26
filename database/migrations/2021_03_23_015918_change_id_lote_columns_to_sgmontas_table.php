<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIdLoteColumnsToSgmontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmontas', function (Blueprint $table) {
            $table->dropForeign('sgmontas_id_lote_foreign');
            $table->dropColumn('id_lote');
            $table->integer('id_lotemonta')->unsigned();
            $table->foreign('id_lotemonta')
                    ->references('id_lotemonta')
                    ->on('sglotemontas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgmontas', function (Blueprint $table) {
            $table->integer('id_lote')->unsigned();
            $table->foreign('id_lote')
                    ->references('id_lote')
                    ->on('sglotes');
            $table->dropForeign('sgmontas_id_lotemonta_foreign');
            $table->dropColumn('id_lotemonta'); 
        });
    }
}
