<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSganimsCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sganims', function (Blueprint $table) {
            DB::statement("ALTER TABLE sganims MODIFY codmadre varchar(50) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY codpadre varchar(50) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY espajuela boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pajuela varchar(50) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fnac date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecr date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecs date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecentrada date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY status boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tipo varchar(150) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tipoanterior varchar(150) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY sexo boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY observa varchar(180) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY procede varchar(180) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesoi float NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesoactual float NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fulpes date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY destatado boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesodestete float NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecdes date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nparto integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY dparto integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nservi integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecua date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecup date NULL;");
            DB::statement("ALTER TABLE sganims MODIFY abort integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY edad varchar(5) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY edadpp varchar(5) NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesopp float NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ultgdp float NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ncrias integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY npartorepor integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nabortoreport integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nro_monta integer NULL;");
            DB::statement("ALTER TABLE sganims MODIFY prenada boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY parida boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tienecria boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY criaviva boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ordenho boolean NULL;");
            DB::statement("ALTER TABLE sganims MODIFY detectacelo boolean NULL;");

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
            DB::statement("ALTER TABLE sganims MODIFY codmadre varchar(50) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY codpadre varchar(50) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY espajuela boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pajuela varchar(50) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fnac date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecr date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecs date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecentrada date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY status boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tipo varchar(150) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tipoanterior varchar(150) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY sexo boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY observa varchar(180) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY procede varchar(180) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesoi float NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesoactual float NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fulpes date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY destatado boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesodestete float NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fuldestete date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nparto integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY dparto integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nservi integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecua date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY fecup date NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY abort integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY edad varchar(5) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY edadpp varchar(5) NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY pesopp float NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ulgdp float NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ncrias integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY npartorepor integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nabortoreport integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY nro_monta integer NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY prenada boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY parida boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY tienecria boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY criaviva boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY ordenho boolean NOT NULL;");
            DB::statement("ALTER TABLE sganims MODIFY detectacelo boolean NOT NULL;");
        });
    }
}
