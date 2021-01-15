<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomenclaturaColumnsTosgmotivoentradasalidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmotivoentradasalidas', function (Blueprint $table) {
            $table->string('nomenclatura');
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
          $table->dropColumn('nomenclatura');
        });
    }
}
