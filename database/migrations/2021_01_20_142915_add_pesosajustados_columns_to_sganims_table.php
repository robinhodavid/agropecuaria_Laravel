<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPesosajustadosColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
           $table->float('pa1')->nullable()->after('fecdes');
           $table->float('pa2')->nullable()->after('pa1');
           $table->float('pa3')->nullable()->after('pa2');
           $table->float('pa4')->nullable()->after('pa3');
           $table->float('ua')->nullable()->after('pa4');
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
           $table->dropColumn('pa1');
           $table->dropColumn('pa2');
           $table->dropColumn('pa3');
           $table->dropColumn('pa4');
           $table->dropColumn('ua');
        });
    }
}
