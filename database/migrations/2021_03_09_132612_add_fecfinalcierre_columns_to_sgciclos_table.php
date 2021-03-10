<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFecfinalcierreColumnsToSgciclosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgciclos', function (Blueprint $table) {
            $table->string('fecfincierre')->nullable()->after('duracion');
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
            $table->dropColumn('fecfincierre');
        });
    }
}
