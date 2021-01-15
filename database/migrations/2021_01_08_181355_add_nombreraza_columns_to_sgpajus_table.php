<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNombrerazaColumnsToSgpajusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpajus', function (Blueprint $table) {
            $table->string('nombreraza')->after('snom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpajus', function (Blueprint $table) {
            $table->dropColumn('nombreraza');
        });
    }
}
