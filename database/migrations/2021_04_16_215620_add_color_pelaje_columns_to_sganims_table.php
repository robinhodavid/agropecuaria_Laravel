<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorPelajeColumnsToSganimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            $table->string('color_pelaje')->nullable()->after('sexo');
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
            $table->dropColumn('color_pelaje'); 
        });
    }
}
