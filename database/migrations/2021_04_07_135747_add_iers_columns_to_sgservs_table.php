<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIersColumnsToSgservsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgservs', function (Blueprint $table) {
           $table->integer('iers')->nullable()->after('nomi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgservs', function (Blueprint $table) {
            $table->dropColumn('iers');
        });
    }
}
