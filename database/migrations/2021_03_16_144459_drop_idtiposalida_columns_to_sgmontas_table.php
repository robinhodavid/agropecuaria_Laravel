<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdtiposalidaColumnsToSgmontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmontas', function (Blueprint $table) {
            $table->dropForeign('sgmontas_idtiposalida_foreign');
            $table->dropColumn('idtiposalida');
            $table->string('tipologia_salida')->nullable()->after('idtipoentrante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgmontas', function (Blueprint $table) {
            $table->integer('idtiposalida')->unsigned();
            $table->foreign('idtiposalida')
                    ->references('id_tipologia')
                    ->on('sgtipologias');
            $table->dropColumn('tipologia_salida');        
        });
    }
}
