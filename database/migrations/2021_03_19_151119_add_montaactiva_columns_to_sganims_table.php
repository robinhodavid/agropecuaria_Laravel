<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontaactivaColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->boolean('monta_activa')->nullable()->after('ltemp');
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
           $table->dropColumn('monta_activa');
        });
    }
}
