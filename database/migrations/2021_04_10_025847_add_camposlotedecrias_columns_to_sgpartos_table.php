<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposlotedecriasColumnsToSgpartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpartos', function (Blueprint $table) {
            $table->string('lotebecerro')->nullable()->after('becer1');
            $table->string('lotebecerro1')->nullable()->after('lotebecerro');
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
            $table->dropColumn('lotebecerro');
            $table->dropColumn('lotebecerro1');
        });
    }
}
