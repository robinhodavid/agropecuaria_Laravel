<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->string('lprod', 160)->nullable()->after('id_motivo_entrada');
            $table->string('lpast', 160)->nullable()->after('lprod');
            $table->string('lnaci', 160)->nullable()->after('lpast');
            $table->string('ltemp', 160)->nullable()->after('lpast');
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
            $table->dropColumn('lprod');
            $table->dropColumn('lpast');
            $table->dropColumn('lnaci');
            $table->dropColumn('ltemp');
        });
    }
}
