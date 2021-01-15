<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposColumnsToSghistlotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghistlotes', function (Blueprint $table) {
            $table->string('sub_lote_ini',160)->nullable()->before('lotefinal');
            $table->string('sub_lote_fin',160)->nullable()->before('fecharegistro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghistlotes', function (Blueprint $table) {
            $table->dropColumn('sub_lote_ini');
            $table->dropColumn('sub_lote_fin');
        });
    }
}
