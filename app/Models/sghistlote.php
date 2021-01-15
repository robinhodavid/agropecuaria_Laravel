<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sghistlote extends Model
{
    use HasFactory;


    protected $table = 'sghistlotes';
    
    protected $fillable = [
        'serie',
        'loteinicial',
        'lotefinal',
      ];
    

}
