<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubLoteColumnsToSgmontasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgmontas', function (Blueprint $table) {
            $table->string('sub_lote')->nullable()->after('tiempo');
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
            $table->dropColumn('sub_lote');
            
        });
    }
}
