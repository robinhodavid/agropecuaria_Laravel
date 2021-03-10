<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class sghsal extends Model
{
    use HasFactory;

    public function dias($fecha1, $fecha2){
    	 $dias = Carbon::parse($fecha1)->diffInYears($fecha2);
        
        	//$dias = diffInDay($fecha1, $fecha2)->format('%R%a');
        return $dias;
    }


}
