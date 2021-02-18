<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use App\Models;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade as PDF;


class ReportController extends Controller
{
    /*
    *Aquí se introducen los controladores de los reportes
    */

    // Reporte de Registro de peso especifico
    public function report_pesoespecifico (Request $request,  $id_finca, $ser)
        {
         	
         	//dd($id_finca, $ser);
            $fechadereporte = Carbon::now();

           // dd($fechadereporte); 
        	
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            //A través del código serie se obtiene el id y lo pasamos al modelo
            $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }

            $serie = \App\Models\sganim::findOrFail($id);

            $pesoreport = \App\Models\sgpeso::where('id_serie', '=', $serie->id)
                ->where('id_finca', '=', $finca->id_finca)
                ->get();

            $cantregistro=$pesoreport->count(); 
            $prompeso = collect($pesoreport)->avg('peso'); 

            $pdf = PDF::loadView('reports.pesoreport',compact('finca','serie','pesoreport','fechadereporte','cantregistro','prompeso'));  

           return $pdf->stream('Peso_Específico.pdf');
                
            //return view('reports.pesoreport');
        }

         public function report_catalogoganado (Request $request,  $id_finca)
        {
            
            $fechadereporte = Carbon::now();
            
            $finca = \App\Models\sgfinca::findOrFail($id_finca);
            
            $status = 1; //Series activas
            //$series = \App\Models\sganim::all();
            
            $series = DB::table('sganims')
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)->get();

            $cantregistro=$series->count(); 
            
           // return $series->all();            
           // set_time_limit(300);
            
            //$pdf = PDF::loadView('reports.catalogodeganado',compact('finca','series','fechadereporte','cantregistro'));  

            //set_time_limit(300);

            //return $pdf->stream('Cátalogo_de_Ganado.pdf');
                
            return view('reports.catalogodeganado',compact('finca','series','fechadereporte','cantregistro'));
        }
}
