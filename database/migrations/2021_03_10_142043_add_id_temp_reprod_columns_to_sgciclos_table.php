<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTempReprodColumnsToSgciclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgciclos', function (Blueprint $table) {
            $table->integer('id_temp_reprod')->unsigned()->after('id_finca');
            $table->foreign('id_temp_reprod')->references('id')->on('sgtempreprods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgciclos', function (Blueprint $table) {
            $table->dropForeign('sgciclos_id_temp_reprod_foreign');
            $table->dropColumn('id_temp_reprod');
        });
    }
}
