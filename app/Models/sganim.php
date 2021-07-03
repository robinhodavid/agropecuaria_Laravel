<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
//use Conner\Tagging\Taggable;

class sganim extends Model
{
    use HasFactory;
    //protected $primaryKey = "serie";
    
    //  use Taggable;
    protected $table = 'sganims';
 	
 	  protected $fillable = [
      	'serie'
      ];

    protected $dates = [

  //    	'fulpes',
      	'fecdes',
      	'fecua',
      ];

    public function sgmv1s()
    {
      return $this->hasMany('App\Models\sgmv1','id_serie','id');
    } 
  
}
