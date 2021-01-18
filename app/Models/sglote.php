<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sglote extends Model
{
    use HasFactory;
 
    protected $primaryKey = "id_lote";
    //protected $primaryKey = "slug";
    
    protected $table = 'sglotes';
    
    protected $fillable = [
        'nombre_lote'
      ];

    public function sluggable ()
    {
        return [
            'slug' => [
                'source' => 'nombre_lote'
            ]
        ];
    }

    public static function filtrarlote($tipo){
        return \App\Models\sglote::where ('tipo','=', $tipo)
        ->get();

    }

}
