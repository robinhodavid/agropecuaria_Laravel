<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdFincaColumnsToSghsalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghsals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_finca')->unsigned()->after('id_motsal');
            $table->foreign('id_finca')->references('id_finca')->on('sgfincas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghsals', function (Blueprint $table) {
            $table->dropForeign('sghsals_id_finca_foreign');
            $table->dropColumn('id_finca');
        });
    }
}
