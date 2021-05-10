<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSgpalpsPrcita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgpalps', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgpalps MODIFY prcita date  NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgpalps', function (Blueprint $table) {
           DB::statement("ALTER TABLE sgpalps MODIFY prcita date NOT NULL;");
        });
    }
}
