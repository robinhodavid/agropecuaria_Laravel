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
use Illuminate\Support\Arr;
//use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\SeriesActivas;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\Gate;
use App\Models\sgfinca;
use App\Models\sgmv1;
use App\Models\sgcelo;

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
      
      $query = DB::table('sgtransferencias')
                  ->where('id_finca','=',$id_finca)
                  ->orderBy($request->orderby,'ASC');
               ($request->desde==null) ? "":$query->whereDate('fecs','>=',$request->desde);
               ($request->hasta==null) ? "":$query->whereDate('fecs','<=',$request->hasta);
      
               ($request->destino==null) ? "":$query->where('destino','=',$request->destino);

               ($request->tipo==null) ? "":$query->where('id_tipologia','=',$request->tipo);

         $transfrealizada = $query->get(); 

         $fechadereporte = Carbon::now();
        
         $finca = \App\Models\sgfinca::findOrFail($id_finca);

         $destino = \App\Models\sgfinca::all();
        
         $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();

         $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
        
         $cantregistro = $transfrealizada->count();

         return view('reports.seriestransferidas',compact('finca','transfrealizada','tipologia','destino','motivo','fechadereporte','cantregistro'));
        }

   #Vista para el reporte de Salida de Animales
   public function report_salida (Request $request,  $id_finca)
   {
            
      $query = DB::table('sgtransferencias')
            ->where('id_finca','=',$id_finca)
            ->orderBy($request->orderby,'ASC');

            ($request->desde==null) ? "":$query->whereDate('fecs','>=',$request->desde);
            ($request->hasta==null) ? "":$query->whereDate('fecs','<=',$request->hasta);
            ($request->destino==null) ? "":$query->where('destino','=',$request->destino);
            ($request->tipo==null) ? "":$query->where('id_tipologia','=',$request->tipo);

         $salidarealizada = $query->get(); 
            

      $fechadereporte = Carbon::now();
     
      $finca = \App\Models\sgfinca::findOrFail($id_finca);

      $destino = \App\Models\sgfinca::all();
      
      $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
         ->get();

      $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
     
      $cantregistro = $salidarealizada->count();

      return view('reports.seriesretiradas',compact('finca','salidarealizada','tipologia','destino','motivo','fechadereporte','cantregistro'));
   }

   public function report_catalogoseries (Request $request,  $id_finca)
   {
    

      $status = 1; //Porque se muestran los animales activos en la finca.

      $fechadereporte = Carbon::now();
        
      $finca = \App\Models\sgfinca::findOrFail($id_finca);
  
      $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();
        
      $query = DB::table('sganims')
                   ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac','sganims.fecr', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                   ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                   ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                   ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                   ->where('sganims.id_finca','=',$id_finca)
                   ->where('sganims.status','=',$status)
                   ->orderBy($request->orderby,'ASC');
                   
                  ($request->tipo==null) ? "":$query->where('sganims.id_tipologia','=',$request->tipo);
                  ($request->desde==null) ? "":$query->whereDate('sganims.fecr','>=',$request->desde);
                  ($request->hasta==null) ? "":$query->whereDate('sganims.fecr','<=',$request->hasta);
                  ($request->nombrelote==null) ? "":$query->where('sganims.nombrelote','=',$request->lote);
         
                  $series = $query->get(); 
  
        $cantregistro = $series->count();

            return view('reports.catalogodeganado',compact('finca','series','tipologia','fechadereporte','cantregistro'));
        }

   public function report_pajuela (Request $request,  $id_finca)
   {

      // return $request; 

      $query = DB::table('sgpajus')
                  ->where('id_finca','=',$id_finca)
                  ->orderBy($request->orderby,'ASC');

                     ($request->desde==null) ? "":$query->whereDate('fecr','>=',$request->desde);
                     ($request->hasta==null) ? "":$query->whereDate('fecr','<=',$request->hasta);

                     ($request->ubica==null) ? "":$query->where('ubica','LIKE',"%".$request->ubica);

                     ($request->serie==null) ? "":$query->where('serie','LIKE',"%".$request->serie);

                  $pajuela = $query->get(); 
   
         $fechadereporte = Carbon::now();
        
         $finca = \App\Models\sgfinca::findOrFail($id_finca);
    
         $cantregistro = $pajuela->count();

         return view('reports.catalogo_pajuela',compact('finca','pajuela','fechadereporte','cantregistro'));
   }

   public function report_historialsalida (Request $request,  $id_finca)
   {   
      
      $query = DB::table('sghsals')
                  ->select('sghsals.serie','sghsals.feche', 'sganims.pesoi','sghsals.procede','sghsals.fechs','sghsals.peso','sghsals.motivo', 'sghsals.destino','sganims.ultgdp','sganims.tipo','sgtipologias.nomenclatura',
                    DB::raw('DATEDIFF(sghsals.fechs, sghsals.feche) as difdia'))
                  ->join('sganims', 'sganims.id', '=', 'sghsals.id_serie')
                  ->join('sgtipologias','sgtipologias.id_tipologia','=','sganims.id_tipologia')
                  ->where('sghsals.id_finca','=',$id_finca)
                  ->orderBy($request->orderby,'ASC');

                  ($request->serie==null) ? "":$query->where('sghsals.serie','=',$request->serie);
                  ($request->motivo==null) ? "":$query->where('sghsals.id_motsal','=',$request->motivo);
                  ($request->destino==null) ? "":$query->where('sghsals.destino','=',$request->destino);
                  ($request->desde==null) ? "":$query->whereDate('sghsals.fechs','>=',$request->desde);
                  ($request->hasta==null) ? "":$query->whereDate('sghsals.fechs','<=',$request->hasta);

                  $histsalida = $query->get(); 

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
      
      //return $request; 
      $query = DB::table('sghistlotes')
               ->where('id_finca','=',$id_finca)
               ->orderBy($request->orderby,'ASC');
               ($request->desde==null) ? "":$query->whereDate('fecharegistro','>=',$request->desde);
               ($request->hasta==null) ? "":$query->whereDate('fecharegistro','<=',$request->hasta);
               ($request->serie==null) ? "":$query->where('serie','=',$request->serie);

               $movimientolote = $query->get(); 

      $fechadereporte = Carbon::now();

      $rangofechadesde = $request->desde;
      $rangofechahasta = $request->hasta;
     

      $finca = \App\Models\sgfinca::findOrFail($id_finca);

      $cantregistro = $movimientolote->count();

      return view('reports.movimiento_lote',compact('finca','movimientolote','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }

   public function report_pa (Request $request,  $id_finca)
   {
         
         //return $request; 
         //dd($id_finca, $ser);
         $fechadereporte = Carbon::now()->subDay(1);

         $finca = \App\Models\sgfinca::findOrFail($id_finca);

         $query = DB::table('sgajusts')
               ->select('sgajusts.id','sgajusts.fecha','sgajusts.id_serie','sgajusts.serie','sgajusts.sexo','sgajusts.pesdes', 'sgajusts.peso', 'sgajusts.difdia', 'sgajusts.difpeso', 'sgajusts.pesoi','sgajusts.pa1','sgajusts.c1','sgajusts.gdp','sgajusts.idraza','sgajusts.fnac','sgajusts.lote','sgajusts.id_finca','sganims.codmadre','sganims.fecdes','sganims.tipo','sganims.edad')
               ->join('sganims','sganims.id','=','sgajusts.id_serie')
               ->where('sgajusts.id_finca','=',$id_finca)
               ->orderBy($request->orderby,'ASC');

         ($request->desde==null) ? "":$query->whereDate('sgajusts.fecha','>=',$request->desde);
         ($request->hasta==null) ? "":$query->whereDate('sgajusts.fecha','<=',$request->hasta);

         $ajust = $query->get(); 

  
         $cantregistro=$ajust->count(); 
         
         $promPesoDestete = round(collect($ajust)->avg('pesdes'),2);
         $promPa1 = round(collect($ajust)->avg('pa1'),2);
         $promPa2 = round(collect($ajust)->avg('pa2'),2);
         $promPa3 = round(collect($ajust)->avg('pa3'),2);
         $promPa4 = round(collect($ajust)->avg('pa4'),2);
         
         $pdf = PDF::loadView('reports.pesoajustado',compact('finca','ajust','promPesoDestete','fechadereporte','cantregistro','promPa1','promPa2','promPa3','promPa4'));  
            
        return $pdf->stream('Peso_Ajustado.pdf');
             
        //return view('reports.pesoajustado', compact('finca','ajust','promPesoDestete','fechadereporte','cantregistro','promPa1','promPa2','promPa3','promPa4'));
   }

   public function report_personal_ganaderia (Request $request,  $id_finca)
   {

      
        $fechadereporte = Carbon::now(); 

        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        #Comprobamos que el request no venga en null
        #Guardamos las opciones de los campos en un array
        $option = collect($request->campo);

        $cont = $option->count();   

         #Validamos que se han seleccionado campos para mostrar
         if ($request->campo==null) {
         #Sino hay campos
            $indicador = 0; #false
            $cantregistro = 0;
            #Esto es para que la variable no pase en vacio
            $reportGanaderia = DB::table('sganims')
               ->select('sganims.serie','sgrazas.nombreraza','sganims.edad', 'sgtipologias.nomenclatura','sgtipologias.id_tipologia','sganims.codmadre','sganims.codpadre', 'sganims.fecr','sganims.sexo','sganims.pesoi','sganims.fnac','sganims.fulpes','sganims.pesodestete','sganims.fecdes','sganims.nombrelote','sganims.pesoactual')
                   ->join('sgrazas','sgrazas.idraza','=','sganims.idraza')
                   ->join('sgtipologias','sgtipologias.id_tipologia','=','sganims.id_tipologia')
                   ->join('sgcondicioncorporals','sgcondicioncorporals.id_condicion','=','sganims.id_condicion')
                   ->where('sganims.id_finca','=',$id_finca)
                   ->orderBy($request->orderby,'ASC')
                   ->get(); 
            } else {

            $indicador = 1; #false

            $query = DB::table('sganims')
                  ->select('sganims.serie','sgrazas.nombreraza','sganims.edad', 'sgtipologias.nomenclatura','sgtipologias.id_tipologia','sganims.codmadre','sganims.codpadre', 'sganims.fecr','sganims.sexo','sganims.pesoi','sganims.fnac','sganims.fulpes','sganims.pesodestete','sganims.fecdes','sganims.nombrelote','sganims.pesoactual')
                      ->join('sgrazas','sgrazas.idraza','=','sganims.idraza')
                      ->join('sgtipologias','sgtipologias.id_tipologia','=','sganims.id_tipologia')
                      ->join('sgcondicioncorporals','sgcondicioncorporals.id_condicion','=','sganims.id_condicion')
                      ->where('sganims.id_finca','=',$id_finca)
                      ->orderBy($request->orderby,'ASC');
                     ($request->tipo==null) ? "":$query->where('sganims.id_tipologia','=',$request->tipo);
                     ($request->frdesde==null) ? "":$query->whereDate('sganims.fecr','>=',$request->frdesde);
                     ($request->frhasta==null) ? "":$query->whereDate('sganims.fecr','<=',$request->frhasta);
                     ($request->pdesde==null) ? "":$query->where('sganims.pesoactual','>=',$request->pdesde);
                     ($request->phasta==null) ? "":$query->where('sganims.pesoactual','<=',$request->phasta);
                     ($request->fddesde==null) ? "":$query->whereDate('sganims.fecdes','>=',$request->fddesde);
                     ($request->fdhasta==null) ? "":$query->whereDate('sganims.fecdes','<=',$request->fdhasta);
            
                     $reportGanaderia = $query->get(); 
            }


        $cantregistro = $reportGanaderia->count(); 
                        
        return view('reports.person_ganaderia', compact('finca','reportGanaderia','fechadereporte','cantregistro', 'option','indicador'));
   }    

    #Aqui Va el otro controlador de reporudccion.
   public function report_personal_reproduccion (Request $request,  $id_finca)
   {

        //return $request;

        $fechadereporte = Carbon::now(); 

        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        #Comprobamos que el request no venga en null
        #Guardamos las opciones de los campos en un array
        $option = collect($request->campo);

        $cont = $option->count();   
        #Celos
        if ($request->tipo=="t1") 
        {
            #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgcelos')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderby,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

               $query = DB::table('sgcelos')
                         ->where('id_finca','=',$id_finca)
                         ->orderBy($request->orderby,'ASC');
                        ($request->resp==null) ? "":$query->where('resp','=',$request->resp);

                        ($request->frdesde==null) ? "":$query->whereDate('fechr','>=',$request->frdesde);
                        ($request->frhasta==null) ? "":$query->whereDate('fechr','<=',$request->frhasta);
                        ($request->fpcdesde==null) ? "":$query->whereDate('fecestprocel','>=',$request->fpcdesde);
                        ($request->fpchasta==null) ? "":$query->whereDate('fecestprocel','<=',$request->fpchasta);
               
                        $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_celos', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }
        #Servicios
        if ($request->tipo=="t2") 
        {
           #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgservs')
                  ->select('sgservs.serie','sgservs.fecha','sgservs.toro','sgservs.paju','sgservs.snro','sgservs.peso','sgservs.nomi','sgservs.iers','sgservs.id_tipologia','sgtipologias.nomenclatura')
                      ->join('sgtipologias','sgtipologias.id_tipologia','=','sgservs.id_tipologia')
                      ->where('sgservs.id_finca','=',$id_finca)
                      ->orderBy($request->orderbys,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

               $query = DB::table('sgservs')
                     ->select('sgservs.serie','sgservs.fecha','sgservs.toro','sgservs.paju','sgservs.snro','sgservs.peso','sgservs.nomi','sgservs.iers','sgservs.id_tipologia','sgservs.edad','sgtipologias.nomenclatura')
                     ->join('sgtipologias','sgtipologias.id_tipologia','=','sgservs.id_tipologia')
                     ->where('sgservs.id_finca','=',$id_finca)
                     ->orderBy($request->orderbys,'ASC');

                        ($request->resp==null) ? "":$query->where('sgservs.nomi','=',$request->resp);
                        ($request->frdesde==null) ? "":$query->whereDate('sgservs.fecha','>=',$request->frdesde);
                        ($request->frhasta==null) ? "":$query->whereDate('sgservs.fecha','<=',$request->frhasta);
                        ($request->pdesde==null) ? "":$query->where('sgservs.peso','>=',$request->pdesde);
                        ($request->phasta==null) ? "":$query->where('sgservs.peso','<=',$request->phasta);
               
                        $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_servicios', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }

        if ($request->tipo=="t3") 
        {
           #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgpalps')
                  ->select('sgpalps.serie','sgpalps.fechr','sgpalps.resp','sgpalps.eval','sgpalps.prcita','sgdiagnosticpalpaciones.id_diagnostico','sgdiagnosticpalpaciones.nombre','sgpalps.patologia')
                  ->join('sgdiagnosticpalpaciones','sgdiagnosticpalpaciones.id_diagnostico','=','sgpalps.id_diagnostico')
                      ->where('sgpalps.id_finca','=',$id_finca)
                      ->orderBy($request->orderbyp,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

               $query = DB::table('sgpalps')
                  ->select('sgpalps.serie','sgpalps.fechr','sgpalps.resp','sgpalps.eval','sgpalps.prcita','sgdiagnosticpalpaciones.id_diagnostico','sgdiagnosticpalpaciones.nombre','sgpalps.patologia')
                  ->join('sgdiagnosticpalpaciones','sgdiagnosticpalpaciones.id_diagnostico','=','sgpalps.id_diagnostico')
                      ->where('sgpalps.id_finca','=',$id_finca)
                      ->orderBy($request->orderbyp,'ASC');
                     ($request->frdesde==null) ? "":$query->whereDate('sgpalps.fechr','>=',$request->frdesde);
                     ($request->frhasta==null) ? "":$query->whereDate('sgpalps.fechr','<=',$request->frhasta);
                     ($request->diag==null) ? "":$query->where('sgpalps.id_diagnostico','=',$request->diag);
                     ($request->patol==null) ? "":$query->where('sgpalps.patologia','<=',$request->patol);
                     ($request->citadesde==null) ? "":$query->whereDate('sgpalps.prcita','>=',$request->citadesde);
                     ($request->citahasta==null) ? "":$query->whereDate('sgpalps.prcita','<=',$request->citahasta);
            
                     $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_palpaciones', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }

        if ($request->tipo=="t4") 
        {
           #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgprenhezs')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypre,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

               $mesdesde = $request->dpredesde/30;
               $meshasta = $request->dprehasta/30; 

               $query = DB::table('sgprenhezs')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypre,'ASC');
                     ($request->frdesde==null) ? "":$query->whereDate('fregp','>=',$request->frdesde);
                     ($request->frhasta==null) ? "":$query->whereDate('fregp','<=',$request->frhasta);

                     ($request->fepartdesde==null) ? "":$query->whereDate('fecap','>=',$request->fepartdesde);
                     ($request->feparthasta==null) ? "":$query->whereDate('fecap','<=',$request->feparthasta);

                     ($request->dpredesde==null) ? "":$query->where('dias_prenez','>=',$request->dpredesde);
                     ($request->dprehasta==null) ? "":$query->where('dias_prenez','<=',$request->dprehasta);

                     ($request->dpredesde==null) ? "":$query->orWhere('mesespre','>=',$mesdesde);
                     ($request->dprehasta==null) ? "":$query->orWhere('mesespre','<=',$meshasta);
                     
                     ($request->fepredesde==null) ? "":$query->whereDate('fepre','>=',$request->fepredesde);
                     ($request->feprehasta==null) ? "":$query->whereDate('fepre','<=',$request->feprehasta);
            
                     $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_prenez', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }

        if ($request->tipo=="t5") 
        {
           #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgpartos')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypa,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

   
               $query = DB::table('sgpartos')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypre,'ASC');
                     
                     ($request->fpartdesde==null) ? "":$query->whereDate('fecpar','>=',$request->fpartdesde);
                     ($request->fparthasta==null) ? "":$query->whereDate('fecpar','<=',$request->fparthasta);

                     ($request->condi==null) ? "":$query->where('marcabec1','=',$request->condi);
                     ($request->condi==null) ? "":$query->orWhere('marcabec2','=',$request->condi);

                     ($request->causa==null) ? "":$query->where('causanm','=',$request->causa);
                    // ($request->causa==null) ? "":$query->orWhere('causanm1','=',$request->causa);
            
                     $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_parto', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }

        if ($request->tipo=="t6") 
        {
         #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgabors')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbya,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

   
               $query = DB::table('sgabors')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbya,'ASC');
                     
                     ($request->fabordesde==null) ? "":$query->whereDate('fecr','>=',$request->fabordesde);
                     ($request->faborhasta==null) ? "":$query->whereDate('fecr','<=',$request->faborhasta);

                     ($request->causaabor==null) ? "":$query->where('causa','=',$request->causaabor);
                   
                     $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_aborto', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }

        if ($request->tipo=="t7") 
        {
           #Validamos que se han seleccionado campos para mostrar
            if ($request->campo==null) {
            #Sino hay campos
               $indicador = 0; #false
               $cantregistro = 0;
               #Esto es para que la variable no pase en vacio
               $reporteReproducion = DB::table('sgpartosncs')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypnc,'ASC')
                      ->get(); 
               } else {

               $indicador = 1; #false

   
               $query = DB::table('sgpartosncs')
                      ->where('id_finca','=',$id_finca)
                      ->orderBy($request->orderbypnc,'ASC');
                     
                     ($request->fpncdesde==null) ? "":$query->whereDate('fecregistro','>=',$request->fpncdesde);
                     ($request->fpnchasta==null) ? "":$query->whereDate('fecregistro','<=',$request->fpnchasta);
                     
                     ($request->causapnc==null) ? "":$query->where('causa','=',$request->causapnc);
                   
                     $reporteReproducion = $query->get(); 
               }

            $cantregistro = $reporteReproducion->count(); 
                        
            return view('reports.person_repro_pn', compact('finca','reporteReproducion','fechadereporte','cantregistro', 'option','indicador'));
        }     
   }     



   public function report_manejo_vientre (Request $request, $id_finca)
   {

        #return $request; 
      
        $finca = sgfinca::findOrFail($id_finca);   

        #Calculamos la
        $y = 'TIMESTAMPDIFF(YEAR, fnac, CURDATE())';
        $dt = $y.'*12';
        $months = 'TIMESTAMPDIFF(MONTH, fnac, CURDATE()) -'.$dt;

        $mpre = 'TIMESTAMPDIFF(MONTH, fecupre, CURDATE())';

        $ida = 'DATEDIFF(CURDATE(),fecup)';

        $fecaproxparto = 'DATE_ADD(fecupre, INTERVAL 9 MONTH)';
        //return $months; 
        //return $mpre." ".'='.$request->tiempogesta; 

        $sqlquery = sganim::select(DB::raw($y." ".'as anho'), 
                         DB::raw($months." ".'as mes'), 
                         DB::raw($mpre." ".'as mesesprenada'),
                         DB::raw($ida." ".'as ida'),
                         DB::raw($fecaproxparto." ".'as fecaproxparto'),
                         'id','serie','fnac','edad', 'tipo','id_tipologia','nparto', 'npartonc','nabortoreport','nservi','nombrelote', 'observa','fecupre','fecs','fecup', 'fecupartonc')
                ->withCount(['sgmv1s', 'sgmv1s as sgmv1s_count' => function ($query) {
                        $query->where('serie_hijo', '<>', null);
                    }])
                ->where('id_finca','=',$id_finca)
                ->where('pesoactual','>=',300)
                ->where('sexo','=',0) # Todas Hemb
                ->where('status','=',1) #Nos dará todas las series activas
                ->orderBy($request->orderby,'ASC');
                ($request->serie==null) ? "":$sqlquery->where('serie','=',$request->serie);
                ($request->tipo==null) ? "":$sqlquery->where('id_tipologia','=',$request->tipo);
                ($request->lote==null) ? "":$sqlquery->where('nombrelote','=',$request->lote);
                ($request->tgdesde==null) ? "":$sqlquery->whereRaw($mpre." ".'>='.$request->tgdesde);
                ($request->tghasta==null) ? "":$sqlquery->whereRaw($mpre." ".'<='.$request->tghasta);
            $mvmadres = $sqlquery->get();

        $fechadereporte = Carbon::now();

        $rangofechadesde = $request->desde;
        $rangofechahasta = $request->hasta;
     
        $cantregistro = $mvmadres->count();


        return view('reports.manejo_vientre',compact('finca','mvmadres','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }

    public function report_celos(Request $request, $id_finca)
    {

        $finca = sgfinca::findOrFail($id_finca);

        $query = DB::table('sgcelos')
                ->where('id_finca','=',$id_finca)
                ->orderBy($request->orderby,'ASC');
                         
                ($request->serie==null) ? "":$query->where('serie','=',$request->serie);

                ($request->fcdesde==null) ? "":$query->whereDate('fechr','>=',$request->fcdesde);
                ($request->fchasta==null) ? "":$query->whereDate('fechr','<=',$request->fchasta);
                     
                ($request->fpcdesde==null) ? "":$query->whereDate('fecestprocel','>=',$request->fpcdesde);
                ($request->fpchasta==null) ? "":$query->whereDate('fecestprocel','<=',$request->fpchasta);
                        
        $celos = $query->get(); 
            
        //return $celos; 
            
        $fechadereporte = Carbon::now(); 

        $rangofechadesde = $request->fcdesde;
        $rangofechahasta = $request->fchasta;   
    
        $cantregistro = $celos->count(); 
    

        if ($request->formato == "html") {
          
          return view('reports.celos',compact('finca','celos','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
        }

        if ($request->formato == "Pdf") {
          $pdf = PDF::loadView('reports.celos',compact('finca','celos','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));

            return $pdf->stream('Celos_Registrados.pdf');
        }

        if ($request->formato == "xls") {
           // return Excel::download(new sganim, 'Celos_Registrados.xlsx');
        }   
    }

   public function report_servicios(Request $request, $id_finca)
   {

      $finca = sgfinca::findOrFail($id_finca);

        $query = DB::table('sgservs')
                ->where('id_finca','=',$id_finca)
                ->orderBy($request->orderby,'ASC');
                         
                ($request->serie==null) ? "":$query->where('serie','=',$request->serie);

                ($request->fsdesde==null) ? "":$query->whereDate('fecha','>=',$request->fsdesde);
                ($request->fshasta==null) ? "":$query->whereDate('fecha','<=',$request->fshasta);
        $servicios = $query->get(); 
            
        //return $celos; 
            
        $fechadereporte = Carbon::now(); 

        $rangofechadesde = $request->fcdesde;
        $rangofechahasta = $request->fchasta;   
    
        $cantregistro = $servicios->count(); 
    

        if ($request->formato == "html") {
          
          return view('reports.servicios',compact('finca','servicios','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
        }

        if ($request->formato == "Pdf") {
          $pdf = PDF::loadView('reports.servicios',compact('finca','servicios','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));

            return $pdf->stream('Servicios_Registrados.pdf');
        }

        if ($request->formato == "xls") {
            return Excel::download(new sganim, 'Servicios_Registrados.xlsx');
        }
    
   }

   public function report_partos(Request $request, $id_finca)
   {

        $finca = sgfinca::findOrFail($id_finca);

        $query = DB::table('sgpartos')
                ->select('sgpartos.id_serie', 'sgpartos.serie', 'sgpartos.tipo', 
                         'sgpartos.estado','sgpartos.edad','sgpartos.tipoap','sgpartos.fecup',
                         'sgpartos.fecpar', 'sgpartos.sexo','sgpartos.sexo1', 'sgpartos.becer',
                         'sgpartos.color_pelaje', 'sgpartos.becer1', 'sgpartos.color_pelaje1',
                         'sgpartos.obspar', 'sgpartos.obspar1', 'sgpartos.edobece', 'sgpartos.edobece1',
                         'sgpartos.razabe', 'sgpartos.pesoib', 'sgpartos.pesoib1', 'sgpartos.ientpar',
                         'sgpartos.codap', 'sganims.nparto', 'sganims.nservi', 'sgrazas.nombreraza',
                         'sgprenhezs.toropaj', 'sgprenhezs.torotemp')
                ->join('sganims','sganims.id','=','sgpartos.id_serie')
                ->join('sgrazas','sgrazas.idraza','=','sganims.idraza')
                ->leftjoin('sgprenhezs','sgprenhezs.id_serie','=','sgpartos.id_serie')
                ->where('sgpartos.id_finca','=',$id_finca)
                ->orderBy($request->orderby,'ASC');
                         
                ($request->serie==null) ? "":$query->where('sgpartos.serie','=',$request->serie);

                ($request->fpdesde==null) ? "":$query->whereDate('sgpartos.fecpar','>=',$request->fpdesde);
                ($request->fphasta==null) ? "":$query->whereDate('sgpartos.fecpar','<=',$request->fphasta);
        $partos = $query->get(); 
                  
            foreach ($partos as $key) {
                $totalCria1 [] = $key->becer;
                $totalCria2 [] = $key->becer1;
            }

        //return $partos;
        $arregloFinal = Arr::except($totalCria2, null);    
        return count($arregloFinal); 
            
        $fechadereporte = Carbon::now(); 

        $rangofechadesde = $request->fcdesde;
        $rangofechahasta = $request->fchasta;   
    
        #Aqui calculamos los datos promedios para el cuadro resumen.


        $cantregistro = $partos->count(); 
    

        if ($request->formato == "html") {
          
          return view('reports.partos',compact('finca','partos','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
        }

        if ($request->formato == "Pdf") {
          $pdf = PDF::loadView('reports.partos',compact('finca','partos','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));

            return $pdf->stream('Servicios_Registrados.pdf');
        }

        if ($request->formato == "xls") {
            return Excel::download(new sganim, 'Servicios_Registrados.xlsx');
        }


   }

   public function report_abortos()
   {

    return view('reports.manejo_vientre',compact('finca','mvmadres','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }

   public function report_partonc()
   {

    return view('reports.manejo_vientre',compact('finca','mvmadres','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }

   public function report_proximaspalpar()
   {

    return view('reports.manejo_vientre',compact('finca','mvmadres','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }

   public function report_proximasparir()
   {

    return view('reports.manejo_vientre',compact('finca','mvmadres','fechadereporte','cantregistro','rangofechadesde','rangofechahasta'));
   }
}
