<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorPelajeColumnsToSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->string('color_pelaje')->nullable()->after('becer');
            $table->string('color_pelaje1')->nullable()->after('becer1');
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
            $table->dropColumn('color_pelaje');
            $table->dropColumn('color_pelaje1');
        });
    }
}
