<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdLoteSganims extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->dropForeign('sganims_id_lote_foreign');
            $table->dropColumn('id_lote');
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
             $table->integer('id_lote')->unsigned();
             $table->foreign('id_lote')
                    ->references('id_lote')
                    ->on('sglotes');
        });
    }
}
