<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposcausayobservmuerteColumnsToSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->string('causanm1')->nullable()->after('obsernm');
            $table->string('obsernm1')->nullable()->after('causanm1');
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
            $table->dropColumn('causanm1');
            $table->dropColumn('obsernm1');
        });
    }
}
