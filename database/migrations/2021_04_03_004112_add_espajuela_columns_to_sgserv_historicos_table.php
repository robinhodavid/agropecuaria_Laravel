<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEspajuelaColumnsToSgservHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgserv_historicos', function (Blueprint $table) {
            $table->boolean('espajuela')->nullable()->after('paju');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgserv_historicos', function (Blueprint $table) {
            $table->dropColumn('espajuela');
        });
    }
}
