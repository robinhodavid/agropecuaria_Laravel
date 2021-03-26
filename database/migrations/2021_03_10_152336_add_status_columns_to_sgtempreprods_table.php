<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnsToSgtempreprodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgtempreprods', function (Blueprint $table) {
            $table->boolean('status')->nullable()->after('id_finca');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgtempreprods', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
