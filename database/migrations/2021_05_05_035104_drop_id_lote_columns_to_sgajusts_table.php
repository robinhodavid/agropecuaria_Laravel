<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdLoteColumnsToSgajustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgajusts', function (Blueprint $table) {
            $table->dropForeign('sgajusts_id_lote_foreign');
            $table->dropColumn('id_lote');
            $table->string('lote')->nullable()->after('idraza');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgajusts', function (Blueprint $table) {
            $table->dropColumn('lote');   
             
             $table->integer('id_lote')->unsigned();
             $table->foreign('id_lote')
                    ->references('id_lote')
                    ->on('sglotes');
        });
    }
}
