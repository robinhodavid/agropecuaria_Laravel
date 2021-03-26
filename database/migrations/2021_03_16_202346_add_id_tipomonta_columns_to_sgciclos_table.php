<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTipomontaColumnsToSgciclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgciclos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('id_tipomonta')->unsigned()->after('id_finca');
            $table->foreign('id_tipomonta')->references('id')->on('sgtipomontas');
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
           $table->dropForeign('sgciclos_id_tipomonta_foreign');
            $table->dropColumn('id_tipomonta');
        });
    }
}
