<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSgtempreprodsCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgtempreprods', function (Blueprint $table) {
           DB::statement("ALTER TABLE sgtempreprods MODIFY fecdefcierre date NULL;");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgtempreprods', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgtempreprods MODIFY fecdefcierre date NOT NULL;");
        });
    }
}
