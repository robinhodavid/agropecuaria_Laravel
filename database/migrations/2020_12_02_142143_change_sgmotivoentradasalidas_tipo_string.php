<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSgmotivoentradasalidasTipoString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmotivoentradasalidas', function (Blueprint $table) {
           DB::statement ("ALTER TABLE sgmotivoentradasalidas MODIFY tipo varchar(7)");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgmotivoentradasalidas', function (Blueprint $table) {
            DB::statement ("ALTER TABLE sgmotivoentradasalidas MODIFY tipo boolean");
        });
    }
}
