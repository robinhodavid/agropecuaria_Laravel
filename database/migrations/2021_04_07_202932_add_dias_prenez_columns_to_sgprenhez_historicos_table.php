<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiasPrenezColumnsToSgprenhezHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgprenhez_historicos', function (Blueprint $table) {
            $table->integer('dias_prenez')->nullable()->after('mesespre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgprenhez_historicos', function (Blueprint $table) {
            $table->dropColumn('dias_prenez');
        });
    }
}
