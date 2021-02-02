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
        'nombre'
      ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'nombre'
            ]
        ];
    }

}
 