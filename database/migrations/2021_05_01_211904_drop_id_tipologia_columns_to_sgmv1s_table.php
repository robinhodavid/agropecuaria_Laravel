<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdTipologiaColumnsToSgmv1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmv1s', function (Blueprint $table) {
        
            $table->dropForeign('sgmv1s_id_tipologia_foreign');
            $table->dropColumn('id_tipologia');
            $table->integer('id_tipo')->nullable()->after('tipologia');
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
             $table->dropColumn('id_tipo');   
             
             $table->integer('id_tipologia')->unsigned();
             $table->foreign('id_tipologia')
                    ->references('id_tipologia')
                    ->on('sgtipologias');
                   
        });
    }
}
