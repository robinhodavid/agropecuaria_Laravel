<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposPartosncColumnsToSgmvmadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmvmadres', function (Blueprint $table) {
            $table->integer('npartonc')->nullable()->after('npartos');
            $table->date('fecupartonc')->nullable()->after('fecup');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgmvmadres', function (Blueprint $table) {
              $table->dropColumn('npartonc');
            $table->dropColumn('fecupartonc');
        });
    }
}
