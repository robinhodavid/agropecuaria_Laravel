<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdTempReprColumnsToSghistoricotempreprosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->dropForeign('sghistoricotemprepros_id_temp_repr_foreign');
            $table->dropColumn('id_temp_repr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->integer('id_temp_repr')->unsigned();
            $table->foreign('id_temp_repr')
                    ->references('id')
                    ->on('sgtempreprods');
        });
    }
}
