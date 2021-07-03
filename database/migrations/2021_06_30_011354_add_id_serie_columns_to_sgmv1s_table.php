<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdSerieColumnsToSgmv1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmv1s', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id_serie')->unsigned()->after('id');
            $table->foreign('id_serie')->references('id')->on('sganims');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgmv1s', function (Blueprint $table) {
            $table->dropColumn('id_serie');
        });
    }
}
