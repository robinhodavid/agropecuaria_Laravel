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
use App\Models\sganim;
use Maatwebsite\Excel\Facades\Excel;
Use App\Http\Controllers\Controllers;
use Illuminate\Contracs\View\View;
//use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\SeriesActivas;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;


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
           // $series = \App\Models\sganim::view();
            
 
            $series = DB::table('sganims')
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)->get();
 
            $cantregistro=$series->count(); 
            
           // return $series->all();            
           // set_time_limit(300);
            
           // $pdf = PDF::loadView('reports.catalogodeganado',compact('finca','series','fechadereporte','cantregistro'));  

            //set_time_limit(300);

            //return $pdf->download('Cátalogo_de_Ganado.pdf');
              
            //return Excel::download(new SeriesActivas, 'Series_Activas.xlsx');  
           return view('reports.catalogodeganado',compact('finca','series','fechadereporte','cantregistro'));
        }

        public function report_catalogoganadoinactivo (Request $request,  $id_finca)
        {
            
            $fechadereporte = Carbon::now();
            
            $finca = \App\Models\sgfinca::findOrFail($id_finca);
            
            $status = 0; //Series inactivas
           // $series = \App\Models\sganim::view();
            
 
            $series = DB::table('sganims')
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)->get();
 
            $cantregistro=$series->count(); 
            
           // return $series->all();            
           // set_time_limit(300);
            
            //$pdf = PDF::loadView('reports.catalogodeganadoinactivo',compact('finca','series','fechadereporte','cantregistro'));  

            //set_time_limit(300);

            //return $pdf->download('Cátalogo_de_Ganado_Inactivo.pdf');
              
            //return Excel::download(new SeriesActivas, 'Series_Activas.xlsx');  
            return view('reports.catalogodeganadoinactivo',compact('finca','series','fechadereporte','cantregistro'));
        }

        public function report_catalogoganadopordestete (Request $request,  $id_finca)
        {
            
            $fechadereporte = Carbon::now();
            
            $finca = \App\Models\sgfinca::findOrFail($id_finca);
            
            $status = 1; //Series activas
           // $series = \App\Models\sganim::view();
            
 
            $series = DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote', DB::raw('DATE_ADD(sganims.fnac,INTERVAL 210 DAY) as fechaproxdestete'))
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.destatado','=',0)->get();
 
            $cantregistro=$series->count(); 
        
            //return $series->all();      
            //$fecha = $series->pluck('fnac') + $fechadereporte;
            //return response()->json($fecha);
                 
           // set_time_limit(300);
            
            //$pdf = PDF::loadView('reports.catalogodeganadoinactivo',compact('finca','series','fechadereporte','cantregistro'));  

            //set_time_limit(300);

            //return $pdf->download('Cátalogo_de_Ganado_Inactivo.pdf');
              
            //return Excel::download(new SeriesActivas, 'Series_Activas.xlsx');  

           // dd($series);

           return view('reports.ganadopordestete',compact('finca','series','fechadereporte','cantregistro'));
        }

        public function report_catalogohemrepro (Request $request,  $id_finca)
        {
            
            $fechadereporte = Carbon::now();
            
            $finca = \App\Models\sgfinca::findOrFail($id_finca);
            
            $status = 1; //Series inactivas
            // $series = \App\Models\sganim::view();
            
 
            $series = DB::table('sganims')
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.sexo','=',0)
                ->where('sganims.destatado','=',1)->get();
 
            $cantregistro=$series->count(); 
            
           // return $series->all();            
           // set_time_limit(300);
            
            //$pdf = PDF::loadView('reports.catalogodeganadoinactivo',compact('finca','series','fechadereporte','cantregistro'));  

            //set_time_limit(300);

            //return $pdf->download('Cátalogo_de_Ganado_Inactivo.pdf');
              
            //return Excel::download(new SeriesActivas, 'Series_Activas.xlsx');  
            return view('reports.hembras_reprod',compact('finca','series','fechadereporte','cantregistro'));
        }

         public function report_transferencia (Request $request,  $id_finca)
        {
    
            
            if (($request->tipo == null) && ($request->destino == null) && ($request->motivo == null) && ($request->desde == null) && ($request->hasta == null)) {
        
            $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->get(); 
        } 

        if (! ($request->tipo == null) && ($request->destino == null) && ($request->motivo == null)&& ($request->desde == null) && ($request->hasta == null)) {
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }

        if ( ($request->tipo == null) && (!($request->destino == null)) &&($request->motivo == null) && ($request->desde == null) && ($request->hasta == null) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('destino','=',$request->destino)->get(); 
        }

        if ( ($request->tipo == null) && ($request->destino == null) && (!($request->motivo == null)) && ($request->desde == null) && ($request->hasta == null) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        //Aquí comiena por rango
        if ( ($request->tipo == null) && ($request->destino == null) && (($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])->get(); 
        }  

        if ( ($request->tipo == null) && ($request->destino == null) && (($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)->get(); 
        }
        if ( ($request->tipo == null) && ($request->destino == null) && (($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)->get(); 
        }               


        if ( ($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('destino','=',$request->destino)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        if (!($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        
        if (!($request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)
            ->where('destino','=',$request->destino)->get(); 
        }

         if (!($request->tipo == null) && (!($request->destino == null)) &&(! ($request->motivo == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)
            ->where('destino','=',$request->destino)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo motivo  con rango de fecha.
        if ( ($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( ($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( ($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo destino  con rango de fecha.
        if ( ($request->tipo == null) && ((!$request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('destino','=',$request->destino)->get(); 
        }
        if ( ($request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('destino','=',$request->destino)->get(); 
        }
        if ( ($request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('destino','=',$request->destino)->get(); 
        }

         //Aqui validamos El campo tipo con rango de fecha.
        if ( !($request->tipo == null) && (($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }
        if ( (!$request->tipo == null) && (($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }
        if ( !($request->tipo == null) && (($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }


         //Aqui validamos El campo tipo y destino  con rango de fecha.
        if ( !($request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }
        if ( (!$request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }
        if ( !($request->tipo == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)->get(); 
        }

        //Aqui validamos El campo destino y motivo  con rango de fecha.
        if ( ($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('destino','=',$request->destino)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( ($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('destino','=',$request->destino)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( ($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('destino','=',$request->destino)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo Tipologia y motivo  con rango de fecha.
        if ( !($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( !($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if (! ($request->tipo == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

         //Aqui validamos todos los campos con rango de fecha.
        if ( !($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->whereBetween('fecs',[$request->desde,$request->hasta])
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if ( !($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','>=',$request->desde)
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }
        if (! ($request->tipo == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
            ->where('fecs','<=',$request->hasta)
            ->where('destino','=',$request->destino)
            ->where('id_tipologia','=',$request->tipo)
            ->where('id_motivo_salida','=',$request->motivo)->get(); 
        }

        $fechadereporte = Carbon::now();
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $destino = \App\Models\sgfinca::all();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();

        $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
        
        $cantregistro = $transfrealizada->count();

            return view('reports.seriestransferidas',compact('finca','transfrealizada','tipologia','destino','motivo','fechadereporte','cantregistro'));
        }

         public function report_catalogoseries (Request $request,  $id_finca)
        {
    
        $status = 1; //Porque se muestran los animales activos en la finca.

        if (($request->tipo == null) && ($request->lote == null) && ($request->sublote == null) && ($request->desde == null) && ($request->hasta == null)) {
        
            
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->get();         
               //return $series->all();  

        } 

        if (! ($request->tipo == null) && ($request->lote == null) && ($request->sublote == null)&& ($request->desde == null) && ($request->hasta == null)) {
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->get(); 
        }

        if ( ($request->tipo == null) && (!($request->lote == null)) &&($request->sublote == null) && ($request->desde == null) && ($request->hasta == null) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                    ->where('sganims.status','=',$status)
                    ->where('sganims.nombrelote','=',$request->lote)
                    ->get(); 
        }

        if ( ($request->tipo == null) && ($request->lote == null) && (!($request->sublote == null)) && ($request->desde == null) && ($request->hasta == null) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                    ->where('sganims.status','=',$status)
                    ->where('sganims.sub_lote','=',$request->sublote)
                    ->get(); 
        }

        //Aquí comienza por rango
        if ( ($request->tipo == null) && ($request->lote == null) && (($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                    ->where('sganims.status','=',$status)
                    ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                    ->get(); 
        }  

        if ( ($request->tipo == null) && ($request->lote == null) && (($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
          
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                    ->where('sganims.status','=',$status)
                    ->where('sganims.fecs','>=',$request->desde)
                    ->get(); 
        }


        if ( ($request->tipo == null) && ($request->lote == null) && (($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
            
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                    ->where('sganims.status','=',$status)
                    ->where('sganims.fecs','<=',$request->hasta)
                    ->get();
        }               


        if ( ($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) ){
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        if (!($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) ){

            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sgamims.status','=',$status)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }
        
        if (!($request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.lote','=',$request->lote)->get(); 
        }

         if (!($request->tipo == null) && (!($request->lote == null)) &&(! ($request->sublote == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        //Aqui validamos El campo motivo  con rango de fecha.
        if ( ($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        if ( ($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.sub_lote','=',$request->sublote)->get();  
        }
        if ( ($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.sub_lote','=',$request->sublote)->get();  
        }

        //Aqui validamos El campo destino  con rango de fecha.
        if ( ($request->tipo == null) && ((!$request->lote == null)) &&(($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.nombrelote','=',$request->lote)->get();  
        }


        if ( ($request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.nombrelote','=',$request->lote)->get(); 

        }
        if ( ($request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','<=',$request->hasta)
                ->where('sganims.nombrelote','=',$request->lote)->get(); 
        }

         //Aqui validamos El campo tipo con rango de fecha.
        if ( !($request->tipo == null) && (($request->lote == null)) &&(($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }
        if ( (!$request->tipo == null) && (($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }

        if ( !($request->tipo == null) && (($request->lote == null)) &&(($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
            
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','<=',$request->hasta)
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }

         //Aqui validamos El campo tipo y lote  con rango de fecha.
        if ( !($request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }

        if ( (!$request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganms.fecs','>=',$request->desde)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }

        if ( !($request->tipo == null) && (!($request->lote == null)) &&(($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','<=',$request->hasta)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.id_tipologia','=',$request->tipo)->get(); 
        }

        //Aqui validamos El campo Lote y sublote  con rango de fecha.
        if ( ($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
              $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.sub_lotelote','=',$request->sublote)->get(); 
        }

        if ( ($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        if ( ($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','<=',$request->hasta)
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        //Aqui validamos El campo Tipologia y motivo  con rango de fecha.
        if ( !($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }
        if ( !($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->where('sganims.fecs','>=',$request->desde)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }
        if (! ($request->tipo == null) && (($request->lote == null)) &&(!($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganms.status','=',$status)
                ->where('sganims.fecs','<=',$request->hasta)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

         //Aqui validamos todos los campos con rango de fecha.
        if ( !($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
            $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
                ->where('sganims.status','=',$status)
                ->whereBetween('sganims.fecs',[$request->desde,$request->hasta])
                ->where('sganims.nombrelote','=',$request->lote)
                ->where('sganims.id_tipologia','=',$request->tipo)
                ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        if ( !($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
            ->where('sganims.status','=',$status)
            ->where('sganims.fecs','>=',$request->desde)
            ->where('sganims.nombrelote','=',$request->lote)
            ->where('sganims.id_tipologia','=',$request->tipo)
            ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }
        if (! ($request->tipo == null) && (!($request->lote == null)) &&(!($request->sublote == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
             $series =DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$id_finca)
            ->where('sganims.status','=',$status)
            ->where('sganims.fecs','<=',$request->hasta)
            ->where('sganims.nombre_lote','=',$request->lote)
            ->where('sganims.id_tipologia','=',$request->tipo)
            ->where('sganims.sub_lote','=',$request->sublote)->get(); 
        }

        $fechadereporte = Carbon::now();
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

      //  $destino = \App\Models\sgfinca::all();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();

      //  $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
        
        $cantregistro = $series->count();

            return view('reports.catalogodeganado',compact('finca','series','tipologia','fechadereporte','cantregistro'));
        }

         public function report_pajuela (Request $request,  $id_finca)
        {
    
        if (($request->serie == null) && ($request->ubica == null) && ($request->desde == null) && ($request->hasta == null)) {
        
            $pajuela = \App\Models\sgpaju::where('id_finca','=',$id_finca)
            ->get();                
               //return $series->all();  
        } 

        if (! ($request->serie == null) && ($request->ubica == null) && ($request->desde == null) && ($request->hasta == null)) {
           
           $pajuela = \App\Models\sgpaju::where('id_finca','=',$id_finca)
                ->where('serie','=',$request->serie)
                ->get(); 
        }

        if ( ($request->serie == null) && (!($request->ubica == null)) && ($request->desde == null) && ($request->hasta == null) ){
           
            $pajuela = \App\Models\sgpaju::where('id_finca','=',$id_finca)
                ->where('ubica','=',$request->ubica)
                ->get(); 
        }

        //Aquí comienza por rango
        if ( ($request->serie == null) && ($request->ubica == null) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
            $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->whereBetween('fecr',[$request->desde,$request->hasta])
                ->get(); 
        }  

        if ( ($request->serie == null) && ($request->ubica == null) && (!($request->desde == null)) && (($request->hasta == null)) ){
          
             $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                    ->where('fecr','>=',$request->desde)
                    ->get(); 
        }

        if ( ($request->serie == null) && ($request->ubica == null) && (($request->desde == null)) && (!($request->hasta == null)) ){
            
              $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                    ->where('fecr','<=',$request->hasta)
                    ->get();
        }               

        if ( ! ($request->serie == null) && (!($request->ubica == null)) ) {
           
           $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->where('serie','=',$request->serie)
                ->where('ubica','=',$request->ubica)
                ->get(); 
        }
       
        if ( ! ($request->serie == null) && (($request->ubica == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
             $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->where('serie','=',$request->serie)
                ->whereBetween('fecr',[$request->desde,$request->hasta])
                ->get(); 
        }

        if ( ($request->serie == null) && ((!$request->ubica == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
              $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->where('ubica','=',$request->ubica)
                ->whereBetween('fecr',[$request->desde,$request->hasta])
                ->get();  
        }

        if (! ($request->serie == null) && (($request->ubica == null)) && (!($request->desde == null)) && ( ($request->hasta == null)) ){
           
              $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->where('serie','=',$request->serie)
                ->where('fecr','=',$request->desde)
                ->get();  
        }
        
        if ( ($request->serie == null) && ( !($request->ubica == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
              $pajuela = \App\Models\sgpaju::where('id_finca','=', $id_finca)
                ->where('ubica','=',$request->ubica)
                ->where('fecr','=',$request->hasta)
                ->get();  
        }

    
        $fechadereporte = Carbon::now();
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
    
        $cantregistro = $pajuela->count();

            return view('reports.catalogo_pajuela',compact('finca','pajuela','fechadereporte','cantregistro'));
        }



          public function report_historialsalida (Request $request,  $id_finca)
        {
    
           
        if (($request->serie == null) && ($request->destino == null) && ($request->motivo == null) && ($request->desde == null) && ($request->hasta == null)) {
  
    
            $histsalida =  DB::table('sghsals')
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp','sganims.tipo',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->get();  
        } 

        if (! ($request->serie == null) && ($request->destino == null) && ($request->motivo == null)&& ($request->desde == null) && ($request->hasta == null)) {
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }

        if ( ($request->serie == null) && (!($request->destino == null)) &&($request->motivo == null) && ($request->desde == null) && ($request->hasta == null) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.destino','=',$request->destino)->get(); 
        }

        if ( ($request->serie == null) && ($request->destino == null) && (!($request->motivo == null)) && ($request->desde == null) && ($request->hasta == null) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        //Aquí comiena por rango
        if ( ($request->serie == null) && ($request->destino == null) && (($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
            $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])->get(); 
        }  

        if ( ($request->serie == null) && ($request->destino == null) && (($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)->get(); 
        }
        if ( ($request->serie == null) && ($request->destino == null) && (($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
            $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)->get(); 
        }               

        if ( ($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        if (!($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) ){
           
            $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        
        if (!($request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.destino','=',$request->destino)->get(); 
        }

         if (!($request->serie == null) && (!($request->destino == null)) &&(! ($request->motivo == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo motivo  con rango de fecha.
        if ( ($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( ($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( ($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo destino  con rango de fecha.
        if ( ($request->serie == null) && ((!$request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])
                ->where('sghsals.destino','=',$request->destino)->get(); 
        }
        if ( ($request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.destino','=',$request->destino)->get(); 
        }
        if ( ($request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.destino','=',$request->destino)->get(); 
        }

         //Aqui validamos El campo tipo con rango de fecha.
        if ( !($request->serie == null) && (($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fecs',[$request->desde,$request->hasta])
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }
        if ( (!$request->serie == null) && (($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }
        if ( !($request->serie == null) && (($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.id_tipologia','=',$request->serie)->get(); 
        }


         //Aqui validamos El campo tipo y destino  con rango de fecha.
        if ( !($request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }

        if ( (!$request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }
        if ( !($request->serie == null) && (!($request->destino == null)) &&(($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)->get(); 
        }

        //Aqui validamos El campo destino y motivo  con rango de fecha.
        if ( ($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( ($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
           $$histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( ($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        //Aqui validamos El campo Tipologia y motivo  con rango de fecha.
        if ( !($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('sghsals.fechs',[$request->desde,$request->hasta])
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( !($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
              ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','>=',$request->desde)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if (! ($request->serie == null) && (($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
          $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
              ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

         //Aqui validamos todos los campos con rango de fecha.
        if ( !($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->whereBetween('fechs',[$request->desde,$request->hasta])
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if ( !($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
         $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
               ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('fechs','>=',$request->desde)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }
        if (! ($request->serie == null) && (!($request->destino == null)) &&(!($request->motivo == null)) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
         $histsalida =  DB::table('sghsals')
               // ->select(DB::raw('count(*) as user_count, status'), ) 
                ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
              ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                ->where('sghsals.id_finca','=',$id_finca)
                ->where('sghsals.fechs','<=',$request->hasta)
                ->where('sghsals.destino','=',$request->destino)
                ->where('sghsals.serie','=',$request->serie)
                ->where('sghsals.id_motsal','=',$request->motivo)->get(); 
        }

        $fechadereporte = Carbon::now();

        $rangofechadesde = $request->desde;
        $rangofechahasta = $request->hasta;
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $destino = \App\Models\sgfinca::all();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();

        $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
        
        $cantregistro = $histsalida->count();

            return view('reports.hist_salida',compact('finca','histsalida','fechadereporte','cantregistro','motivo','destino','rangofechadesde','rangofechahasta'));
        }



         public function report_movimientolote (Request $request,  $id_finca)
        {
    
           
        if (($request->serie == null) && ($request->desde == null) && ($request->hasta == null)) {
            $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->get();
        } 

        if (! ($request->serie == null) && ($request->desde == null) && ($request->hasta == null)) {
           
            $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->where('serie','=',$request->serie)->get(); 
        }

        //Aquí comiena por rango
        if ( ($request->serie == null) && (!($request->desde == null)) && (!($request->hasta == null)) ){
           
           $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->whereBetween('fecharegistro',[$request->desde,$request->hasta])->get(); 
        }  

        if ( ($request->serie == null) && (!($request->desde == null)) && ( ($request->hasta == null)) ){
           
            $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->where('fecharegistro','>=',$request->desde)->get(); 
        }

        if ( !($request->serie == null) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
             $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->where('fecharegistro','<=',$request->hasta)->get(); 
        } 
        if ( ($request->serie == null) && (($request->desde == null)) && (!($request->hasta == null)) ){
           
             $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->where('serie','=',$request->serie)
                ->where('fecharegistro','<=',$request->hasta)->get(); 
        }
        if (! ($request->serie == null) && (!($request->desde == null)) && (($request->hasta == null)) ){
           
             $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
                ->where('serie','=',$request->serie)
                ->where('fecharegistro','>=',$request->desde)->get(); 
        }                    

        
        $fechadereporte = Carbon::now();

        $rangofechadesde = $request->desde;
        $rangofechahasta = $request->hasta;
        

        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $cantregistro = $movimientolote->count();

            return view('reports.movimiento_lote',compact('finca','movimientolote','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
        }









}
