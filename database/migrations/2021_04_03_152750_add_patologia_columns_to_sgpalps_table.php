<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatologiaColumnsToSgpalpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpalps', function (Blueprint $table) {
            $table->string('patologia')->nullable()->after('id_diagnostico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpalps', function (Blueprint $table) {
            $table->dropColumn('patologia');
        });
    }
}
