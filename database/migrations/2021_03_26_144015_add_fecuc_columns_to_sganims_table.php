<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFecucColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->date('fecuc')->nullable()->after('dparto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->dropColumn('fecuc');
        });
    }
}
