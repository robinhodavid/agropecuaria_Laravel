<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sgmv1 extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_serie'
      ];

    public function sganims()
    {
        return $this->belongsTo('App\Models\sganim','id_serie','id');
    }
}
