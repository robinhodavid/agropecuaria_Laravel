<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEspajuelaColumnsToSgservsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgservs', function (Blueprint $table) {
            $table->boolean('espajuela')->nullable()->after('paju');
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
            $table->dropColumn('espajuela');
        });
    }
}
