<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgsublote extends Model
{
    use HasFactory;
    protected $primaryKey = "id_sublote";

    protected $table = 'sgsublotes';
    
    protected $fillable = [
        'nombre_lote',
        'sub_lote',
      ];
    public static function filtrarlotesublote($id_finca, $nombre_lote){
        return \App\Models\sgsublote::where ('nombre_lote','=', $nombre_lote)
        ->where('id_finca','=',$id_finca)
        ->get();

    }

}
