<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaColumnsToSgajustsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgajusts', function (Blueprint $table) {
            $table->date('fecha')->nullable()->after('id');
            $table->integer('id_finca')->nullable()->after('id_lote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgajusts', function (Blueprint $table) {
            $table->dropColumn('fecha'); 
            $table->dropColumn('id_finca'); 
        });
    }
}
