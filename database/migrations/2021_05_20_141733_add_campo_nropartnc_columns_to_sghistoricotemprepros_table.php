<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoNropartncColumnsToSghistoricotempreprosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->integer('nropartnc')->nullable()->after('nropart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghistoricotemprepros', function (Blueprint $table) {
            $table->dropColumn('nropartnc');
        });
    }
}
