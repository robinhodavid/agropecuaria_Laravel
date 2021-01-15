<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgtipologia extends Model
{
    use HasFactory;
    protected $primaryKey = "id_tipologia";

    protected $fillable = [
        'nombre_tipologia',
        'nomenclatura'
      ];
	// Filtra las tipologia por sexo
    public static function filtrartiposexo($sexo)
    {
        return \App\Models\sgtipologia::where ('sexo','=', $sexo)
        ->get();
    }
}
