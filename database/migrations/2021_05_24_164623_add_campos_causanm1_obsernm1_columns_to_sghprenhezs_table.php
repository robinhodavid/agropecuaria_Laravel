<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposCausanm1Obsernm1ColumnsToSghprenhezsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghprenhezs', function (Blueprint $table) {
            $table->string('causanm1')->nullable()->after('causanm');
            $table->string('obsernm1')->nullable()->after('obsernm');
            $table->date('fecregpnc')->nullable()->after('fecabo');
            $table->string('causapnc')->nullable()->after('fecregpnc');
            $table->string('observpnc')->nullable()->after('causapnc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sghprenhezs', function (Blueprint $table) {
            $table->dropColumn('causanm1');
            $table->dropColumn('obsernm1');
            $table->dropColumn('fecregpnc');
            $table->dropColumn('causapnc');
            $table->dropColumn('observpnc');


        });
    }
}
