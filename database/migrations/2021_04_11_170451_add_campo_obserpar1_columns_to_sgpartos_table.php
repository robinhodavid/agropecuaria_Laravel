<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoObserpar1ColumnsToSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
             $table->string('obspar1')->nullable()->after('obspar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->dropColumn('obspar1');

        });
    }
}
