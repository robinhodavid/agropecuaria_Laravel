<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdEspecieColumnsToSgrazasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgrazas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_especie')->unsigned()->after('id_finca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgrazas', function (Blueprint $table) {
             $table->dropColumn('id_especie');
        });
    }
}
