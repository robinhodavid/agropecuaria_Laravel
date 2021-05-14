<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoSexoColumnsToDetalleTrabajoCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detalle_trabajo_campos', function (Blueprint $table) {
           $table->boolean('sexo')->nullable()->after('serie'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_trabajo_campos', function (Blueprint $table) {
            $table->dropColumn('sexo'); 
        });
    }
}
