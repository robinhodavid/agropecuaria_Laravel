<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFecusColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->date('fecus')->nullable()->after('nservi');
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
             $table->dropColumn('fecus');
        });
    }
}
