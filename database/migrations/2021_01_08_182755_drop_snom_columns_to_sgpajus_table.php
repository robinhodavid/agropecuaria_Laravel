<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSnomColumnsToSgpajusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpajus', function (Blueprint $table) {
            $table->dropForeign('sgpajus_snom_foreign');
            $table->dropColumn('snom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpajus', function (Blueprint $table) {
             $table->integer('snom')->unsigned();
             $table->foreign('snom')
                    ->references('idraza')
                    ->on('sgrazas');
        });
    }
}
