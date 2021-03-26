<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposColumnsToSglotemontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sglotemontas', function (Blueprint $table) {
            $table->string('nombre_lote')->nullable()->after('id_lote');
            $table->string('sub_lote')->nullable()->after('nombre_lote');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sglotemontas', function (Blueprint $table) {
            $table->dropColumn('nombre_lote');
            $table->dropColumn('sub_lote');
        });
    }
}
