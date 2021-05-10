<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSghprenhezsCodp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sghprenhezs', function (Blueprint $table) {
             DB::statement("ALTER TABLE sghprenhezs MODIFY codp varchar(50)  NULL;");
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
            DB::statement("ALTER TABLE sghprenhezs MODIFY codp integer  NULL;");
        });
    }
}
