<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgfinca extends Model
{
    use HasFactory;

    protected $primaryKey = "id_finca";

    protected $table = 'sgfincas';
    
    protected $fillable = [
        'nombre','id_finca', 
      ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nombre'
            ]
        ];
    }

    public function users(){

        return $this->belongsToMany('App\Models\User','sgfinca_user','id_finca','user_id')->withTimesTamps();
    }


}
 