<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgpaju extends Model
{
    use HasFactory;
   
    protected $table = 'sgpajus';
    
    protected $fillable = [
        'serie'
      ];


}
