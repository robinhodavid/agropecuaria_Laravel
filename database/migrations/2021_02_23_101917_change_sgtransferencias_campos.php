<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSgtransferenciasCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sgtransferencias', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgtransferencias MODIFY edad varchar(5) NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY edadpp varchar(5) NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ulgdp float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa1 float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa2 float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa3 float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa4 float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ua float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ncrias float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY npartorepor float NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY nabortoreport float NULL;");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sgtransferencias', function (Blueprint $table) {
            DB::statement("ALTER TABLE sgtransferencias MODIFY edad varchar(5) NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY edadpp varchar(5) NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ulgdp float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa1 float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa2 float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa3 float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY pa4 float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ua float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY ncrias float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY npartorepor float NOT NULL;");
            DB::statement("ALTER TABLE sgtransferencias MODIFY nabortoreport float NOT NULL;");
        });
    }
}
