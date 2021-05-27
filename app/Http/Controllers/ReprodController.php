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
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\sganim;
use Maatwebsite\Excel\Facades\Excel;
Use App\Http\Controllers\Controllers;
use Illuminate\Contracs\View\View;
//use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\SeriesActivas;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\User;

class ReprodController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*
    public function __construct()
    {
        $this->middleware('auth');
    } */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        return view('home');
    }

    //Controlaremos el acceso al sistema con un formulario para
    //loging del usuario
    public function inicio(){
    	return view('auth/login'); //agro_bienvenida' 
    }

    public function temporada_monta(Request $request, $id_finca){

    	$finca = \App\Models\sgfinca::findOrFail($id_finca);

    	if (! empty($request->temporada) ) {
    		$temp_reprod = DB::table('sgtempreprods')
    		->where('id_finca','=',$id_finca)
    		->where('nombre','like',$request->temporada."%")
    		->paginate(5);
    	} else {
    		$temp_reprod = \App\Models\sgtempreprod::where('id_finca','=',$id_finca)
    		->paginate(5);	
    	}
    	
    	return view('reproduccion.temporada_ciclo',compact('finca','temp_reprod'));
    }

    public function crear_temporada(Request $request, $id_finca)
    {

        $request->validate([
            'nombre'=> [
                'required',
                'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
            'fecini'=> [
                'required',
            ],
        ]);

        $temporadaNueva = new \App\Models\sgtempreprod;

        $temporadaNueva->nombre = $request->nombre;
        $temporadaNueva->fecini = $request->fecini;
        $temporadaNueva->fecfin = $request->fecfin;
        $temporadaNueva->id_finca = $id_finca;

        $temporadaNueva-> save(); 

        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_temporada($id_finca, $id)
    {
            //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        return view('reproduccion.editar_temporada_ciclo', compact('finca','temp_reprod'));
    } 

    public function update_temporada(Request $request, $id, $id_finca)
    {

            //Valida que  las series sean requeridos y que no se repitan.
        $request->validate([
            'nombre'=> [
                'required',
            ],

        ]);

        $temporadaUpdate = \App\Models\sgtempreprod::findOrFail($id);

        $temporadaUpdate->nombre = $request->nombre;
            //$temporadaUpdate->fecini = $request->fecini;
        $temporadaUpdate->fecfin = $request->fecfin;

        $temporadaUpdate-> save(); 

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_temporada($id_finca, $id)
    {

        $temporadaEliminar = \App\Models\sgtempreprod::findOrFail($id);

        try {
            $temporadaEliminar->delete();
            return back()->with('mensaje', 'ok');     
        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }

    }

    public function cierre_temporada(Request $request, $id_finca, $id)
    {


        $temporadaCierre = \App\Models\sgtempreprod::findOrFail($id);

        $fechacierre = Carbon::now()->format('Y-m-d');

        $temporadaCierre->fecdefcierre = $fechacierre;


            #Aqui debemos hacer la actualización de temporada activa
            #para liberar la serie de la temporada.


        try {

            $temporadaCierre-> save();
            
            $cierreCiclo = DB::table('sgciclos')
            ->where('id_temp_reprod',$temporadaCierre->id)
            ->update(['fecfincierre'=>$fechacierre]); 
            
            return back()->with('msje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('msje', 'error');
        }
    }



    public function temporada_detalle(Request $request, $id_finca, $id)
    {
            //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        if (! empty($request->ciclo) ) {
           $ciclo = DB::table('sgciclos')
           ->join('sgtipomontas','sgtipomontas.id','=','sgciclos.id_tipomonta')
           ->where('sgciclos.id_finca','=',$id_finca)
           ->where('sgciclos.ciclo','like',$request->ciclo."%")
           ->where('sgciclos.id_temp_reprod','=',$temp_reprod->id)
           ->get();
       } else {
           $ciclo = DB::table('sgciclos')
           ->join('sgtipomontas','sgtipomontas.id','=','sgciclos.id_tipomonta')
           ->where('sgciclos.id_finca','=',$id_finca)
           ->where('sgciclos.id_temp_reprod','=',$temp_reprod->id)
           ->get();	
       }

       return view('reproduccion.vista_general_ciclo', compact('finca','temp_reprod','ciclo'));
   } 


   public function ciclo(Request $request, $id_finca, $id){

      $finca = \App\Models\sgfinca::findOrFail($id_finca);

      $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

    		//Muestra todos los lotes de Temporada
      $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
      ->where('tipo', '=', "Temporada")->get();

      $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
      ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
      ->get();

      $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
      ->get();	

      $ciclo = \App\Models\sgciclo::where('sgciclos.id_finca','=',$id_finca)
      ->join('sgtipomontas','sgtipomontas.id','=','sgciclos.id_tipomonta')
      ->where('sgciclos.id_temp_reprod','=',$temp_reprod->id)
      ->paginate(3);	



      $fechafin = Carbon::parse($temp_reprod->fecini)->addDay(90)->format('Y-m-d');

    		/*
    		*se restan los meses para obtener los meses transcurridos. 
    		*/
         $months = Carbon::parse($temp_reprod->fecini)->diffInMonths($fechafin) + 1;

	        $dt = $months * 30; //días Transcurridos

	        //dd($dt);

	        $day = Carbon::parse($temp_reprod->fecini)->diffInDays($fechafin)-$dt;

	        $duracion = $months."-".$day;
    		//**************************************************************************** 


         return view('reproduccion.crear_ciclo',compact('finca','temp_reprod','ciclo','lote','sublote', 'tipomonta','fechafin','duracion' ));
     }

     public function crear_ciclo(Request $request, $id_finca, $id)
     {


        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $request->validate([
            'ciclo'=> [
                'required',
                'unique:sgciclos,ciclo,NULL,NULL,id_temp_reprod,'. $id,
            ],
            'tipomonta'=> [
                'required',
            ],
        ]);

            /*
  			* Se realiza obtienen la fechas con la finalidad de hacer
  			* el corrido de las mismas.
  			*/
              $comienzo = Carbon::parse($temp_reprod->fecini)->format('Y-m-d');

              $final = Carbon::parse($temp_reprod->fecfin)->format('Y-m-d');

              $periodo = CarbonPeriod::create($comienzo,'1 days' ,$final);

              $tmp = $periodo->toArray();


            //Con esto buscanos el nombre del tipo de monta para agregarlo en la tabla de Monta

              $nombremonta = \App\Models\sgtipomonta::findOrFail($request->tipomonta);

              $cicloNuevo = new \App\Models\sgciclo;

              $cicloNuevo->ciclo = $request->ciclo;
              $cicloNuevo->fechainicialciclo = $request->fechainicialciclo;
              $cicloNuevo->fechafinalciclo = $request->fechafinalciclo;
              $cicloNuevo->duracion = $request->duracion;
              $cicloNuevo->id_tipomonta = $request->tipomonta;
              $cicloNuevo->id_temp_reprod = $id;
              $cicloNuevo->id_finca = $id_finca;
              $cicloNuevo->tipomonta = $nombremonta->nombre;

              $cicloNuevo-> save(); 

              $ultimociclo = DB::table('sgciclos')
              ->select(DB::raw('MAX(id_ciclo) as ultimociclo'))
              ->where('id_finca','=',$id_finca)
              ->where('id_temp_reprod', '=', $id)
              ->get();

              foreach ($ultimociclo as $key) {
                  $idciclo = $key->ultimociclo;
              }

			//return $idciclo; 

              $cont = count($periodo);

              for($i=0; $i < $cont; $i++){

               $histTempReproNuevo = new \App\Models\sghistoricotemprepro;

               $histTempReproNuevo->fecharegistro = $tmp[$i];

               $histTempReproNuevo->id_ciclo = $idciclo;
               $histTempReproNuevo->id_finca = $id_finca;

               $histTempReproNuevo-> save();   	

           }

           return back()->with('msj', 'Registro agregado satisfactoriamente');
       }

       public function editar_ciclo($id_finca, $id, $id_ciclo)
       {

        	//dd($id_ciclo);

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    		//Muestra todos los lotes de Temporada
        $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Temporada")->get();

        $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
        ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
        ->get();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

        $fechafin = Carbon::parse($temp_reprod->fecini)->addDay(90)->format('Y-m-d');

    		/*
    		*se restan los meses para obtener los meses transcurridos. 
    		*/
         $months = Carbon::parse($temp_reprod->fecini)->diffInMonths($fechafin) + 1;

	        $dt = $months * 30; //días Transcurridos

	        //dd($dt);

	        $day = Carbon::parse($temp_reprod->fecini)->diffInDays($fechafin)-$dt;

	        $duracion = $months."-".$day;

    		//*************************************************************************

            return view('reproduccion.editar_ciclo', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion'));
        }

        public function update_ciclo(Request $request, $id, $id_finca, $id_ciclo)
        {

            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([
                'ciclo'=> [
                    'required',
                ],
                
            ]);

            $tipomonta = \App\Models\sgtipomonta::findOrFail($request->tipomonta);

            $cicloUpdate = \App\Models\sgciclo::findOrFail($id_ciclo);

            $cicloUpdate->ciclo = $request->ciclo;
            $cicloUpdate->fechainicialciclo = $request->fechainicialciclo;
            $cicloUpdate->fechafinalciclo = $request->fechafinalciclo;
            $cicloUpdate->tipomonta = $tipomonta->nombre;
            $cicloUpdate->duracion = $request->duracion;
            $cicloUpdate->id_tipomonta = $request->tipomonta;
            $cicloUpdate->id_temp_reprod = $id;
            $cicloUpdate->id_finca = $id_finca;

            $cicloUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

        public function eliminar_ciclo($id_finca, $id, $id_ciclo)
        {

            $cicloEliminar = \App\Models\sgciclo::findOrFail($id_ciclo);

            try {

                $histTempReprod = DB::table('sghistoricotemprepros')
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_finca','=',$id_finca)
                ->delete(); 
                
                $cicloEliminar->delete();

                return back()->with('mensaje', 'ok');     

            }catch (\Illuminate\Database\QueryException $e){
                return back()->with('mensaje', 'error');
            }

        }

	/*
	*	Aquí se colca la funcion para mostrar la vista detalle de ciclo.
	*/

	public function detalle_ciclo($id_finca, $id, $id_ciclo)
    {

        	//dd($id_ciclo);

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    		//Muestra todos los lotes de Temporada
        $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Temporada")->get();

        $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
        ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
        ->get();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();


        $lotemonta = DB::table('sglotemontas')
        ->join('sgciclos', 'sgciclos.id_ciclo', '=', 'sglotemontas.id_ciclo')
        ->where('sglotemontas.id_ciclo','=',$id_ciclo)
        ->get();	
    		//return $lotemonta;	
  			/*
  			* Se realiza obtienen la fechas con la finalidad de hacer
  			* el corrido de las mismas.
  			*/
              $comienzo = Carbon::parse($temp_reprod->fecini)->format('Y-m-d');

              $final = Carbon::parse($temp_reprod->fecfin)->format('Y-m-d');

              $periodo = CarbonPeriod::create($comienzo,'1 days' ,$final);

              $tmp = $periodo->toArray();

              $historicoTemporada = \App\Models\sghistoricotemprepro::where('id_ciclo', '=', $id_ciclo)
              ->where('fecharegistro', '>=', $comienzo) 
              ->where('id_finca', '=', $id_finca)->get(); 


              $seriesparareproduccion = DB::table('sgmontas')
              ->select('sgmontas.id_serie', 'sgmontas.serie', 'sganims.sexo', 'sgmontas.tipologia_salida', 'sganims.pesoactual', 'sgmontas.id_lotemonta', 'sgtipologias.nombre_tipologia','sganims.tipo as tipoactual')
              ->join('sglotemontas','sglotemontas.id_lotemonta','=','sgmontas.id_lotemonta')
              ->join('sganims','sganims.id','=','sgmontas.id_serie')
              ->join('sgtipologias','sgtipologias.id_tipologia','=','sgmontas.idtipoentrante')
              ->where('sglotemontas.id_ciclo','=',$id_ciclo)
              ->where('sganims.destatado','=',1)
              ->orderBy('sgmontas.serie','ASC')
              ->get();

              return view('reproduccion.detalle_ciclo', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta', 'periodo','historicoTemporada','seriesparareproduccion','lotemonta'));
          }

/*
* 	Fin de detalle de ciclo 
*/

        #Crear el CRUD de Lotes de Montas donde se asocian con el Ciclo 

public function lotemonta(Request $request, $id_finca, $id, $id_ciclo){

  $finca = \App\Models\sgfinca::findOrFail($id_finca);

  $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

    		//Muestra todos los lotes de Temporada
  $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
  ->where('tipo', '=', "Temporada")->get();

  $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
  ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
  ->get();

  $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
  ->get();	

  $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);


  $lotemonta = \App\Models\sglotemonta::where('sglotemontas.id_ciclo','=',$id_ciclo)
  ->join('sgciclos','sgciclos.id_ciclo','=','sglotemontas.id_ciclo')
  ->paginate(7);		


  $fechafin = Carbon::parse($temp_reprod->fecini)->addDay(90)->format('Y-m-d');

    		/*
    		*se restan los meses para obtener los meses transcurridos. 
    		*/
         $months = Carbon::parse($temp_reprod->fecini)->diffInMonths($fechafin) + 1;

	        $dt = $months * 30; //días Transcurridos

	        //dd($dt);

	        $day = Carbon::parse($temp_reprod->fecini)->diffInDays($fechafin)-$dt;

	        $duracion = $months."-".$day;


         return view('reproduccion.crear_lote_monta',compact('finca','temp_reprod','ciclo','lote','sublote', 'tipomonta','fechafin','duracion','lotemonta' ));
     }

     public function crear_lotemonta(Request $request, $id_finca, $id, $id_ciclo)
     {

        $request->validate([
            'lote'=> [
                'required',
                'unique:sglotemontas,id_lote,NULL,NULL,id_ciclo,'. $id_ciclo,
            ],
            'sublote'=> [
                'unique:sglotemontas,sub_lote,NULL,NULL,id_ciclo,'. $id_ciclo,
            ],

        ]);


        $anho1 = Carbon::parse($request->fechainicialciclo)->format('Y');

        $anho2 = Carbon::parse($request->fechafinalciclo)->format('Y');

        $nombrelote = \App\Models\sglote::findOrFail($request->lote); 

        $lotemontaNuevo = new \App\Models\sglotemonta;

        $lotemontaNuevo->fechainirea = $request->fechainicialciclo;
        $lotemontaNuevo->fechafinrea = $request->fechafinalciclo;
        $lotemontaNuevo->anho1 = $anho1;
        $lotemontaNuevo->anho2 = $anho2;
        $lotemontaNuevo->id_lote = $request->lote;
        $lotemontaNuevo->nombre_lote = $nombrelote->nombre_lote;
        $lotemontaNuevo->sub_lote = $request->sublote;
        $lotemontaNuevo->id_ciclo = $id_ciclo;           

        $lotemontaNuevo-> save(); 

        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }


    public function editar_lotemonta($id_finca, $id, $id_ciclo, $id_lotemonta)
    {

     $finca = \App\Models\sgfinca::findOrFail($id_finca);

     $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

    		//Muestra todos los lotes de Temporada
     $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
     ->where('tipo', '=', "Temporada")->get();

     $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
     ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
     ->get();

     $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
     ->get();	

     $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);


     $lotemonta = \App\Models\sglotemonta::findOrFail($id_lotemonta);


     $fechafin = Carbon::parse($temp_reprod->fecini)->addDay(90)->format('Y-m-d');

    		/*
    		*se restan los meses para obtener los meses transcurridos. 
    		*/
         $months = Carbon::parse($temp_reprod->fecini)->diffInMonths($fechafin) + 1;

	        $dt = $months * 30; //días Transcurridos

	        //dd($dt);

	        $day = Carbon::parse($temp_reprod->fecini)->diffInDays($fechafin)-$dt;

	        $duracion = $months."-".$day;



            return view('reproduccion.editar_lote_monta', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion','lotemonta'));
        }

        public function update_lotemonta(Request $request, $id, $id_finca, $id_ciclo, $id_lotemonta)
        {

            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([
                'lote'=> [
                    'required',
                ],
                
            ]);

            $nombrelote = \App\Models\sglote::findOrFail($request->lote);           
            $lotemontaUpdate = \App\Models\sglotemonta::findOrFail($id_lotemonta);

            $lotemontaUpdate->id_lote = $request->lote;
            $lotemontaUpdate->nombre_lote = $nombrelote->nombre_lote;
            $lotemontaUpdate->sub_lote = $request->sublote;

            $lotemontaUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

        public function eliminar_lotemonta($id_finca, $id, $id_ciclo, $id_lotemonta)
        {

            $lotemontaEliminar = \App\Models\sglotemonta::findOrFail($id_lotemonta);

            try {
                $lotemontaEliminar->delete();
                return back()->with('mensaje', 'ok');     

            }catch (\Illuminate\Database\QueryException $e){
                return back()->with('mensaje', 'error');
            }

        }

        public function serieslotemonta(Request $request, $id_finca, $id, $id_ciclo){

        	//return $request->all();

          $finca = \App\Models\sgfinca::findOrFail($id_finca);

          $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

          $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

          $edadMaxTipologia = DB::table('sgtipologias')
          ->select(DB::raw('MAX(edad) as edadmax'))
          ->where('id_finca', '=', $id_finca)
          ->get();

          foreach ($edadMaxTipologia as $key ) {
             $edadmax = $key->edadmax; 
         }	


         if ($ciclo->id_tipomonta == 1) {
				# Si se  trata de una inseminación artificial, solo se muestra las hembras que seran
				# fertilizadas.
				//return ("Es Insiminación");
            if (! empty($request->serie) ) {
              $seriesrepro = DB::table('sganims')
              ->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
              ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
              ->where('sganims.status', '=', 1)
              ->where('sganims.destatado','=',1)
		                ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas
		                ->where('sgtipologias.edad','>=',$edadmax) //Mayores a 365
		                ->whereNull('sganims.monta_activa') 
		                //->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.id_finca', '=', $finca->id_finca)
                       ->where('sganims.serie', 'like', $request->serie."%")
                       ->take(7)->paginate(7);
                   } else {

                      $seriesrepro = DB::table('sganims')
                      ->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
                      ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
                      ->where('sganims.status', '=', 1)
                      ->where('sganims.destatado','=',1)
		                ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas
		                ->where('sgtipologias.edad','>=',$edadmax) //Mayores a 365
		                ->whereNull('sganims.monta_activa') 
		                //->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->take(7)->paginate(7);
                  }

              }

			//return $seriesrepro; 

              if ($ciclo->id_tipomonta == 2) {
				#Se trata de una reproduccion con ambos métodos
				//return ("Es Mixta");

                if (! empty($request->serie) ) {
                  $seriesrepro = DB::table('sganims')
                  ->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
                  ->where('sganims.serie', 'like', $request->serie."%")
                  ->where('sganims.status', '=', 1)
                  ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas
		               // ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
                  } else {
                      $seriesrepro = DB::table('sganims')
                      ->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
                      ->where('sganims.serie', 'like', $request->serie."%")
                      ->where('sganims.status', '=', 1)
                      ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas
		             //   ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
                  }	
              }

			/*
			if ($ciclo->id_tipomonta == 2) {
				# Se trata de una reproduccion basado en el método natural
				# Aquí el Animal detecta el momento exacto del celo para realizar la monta
		
				if (! empty($request->serie) ) {

            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas 
		                ->where('sgtipologias.edad','>=',$edadmax) //Mayores a 365
		               // ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
        		} else {
            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sgtipologias.prenada','sgtipologias.edad','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		            	->where('sganims.serie', 'like', $request->serie."%")
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		                ->where('sgtipologias.prenada','=',0) //Que sean hembras no preñadas
		                ->where('sgtipologias.edad','>',$edadmax) //Mayores a 365
		             //   ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
        		}	
			}
			*/   
			$fechanow= Carbon::now()->format('Y-m-d');

    		//Muestra todos los lotes de Temporada
			$lote = \App\Models\sglotemonta::where('id_ciclo', '=', $id_ciclo)
          ->get();

          $sublote = \App\Models\sglotemonta::where('id_ciclo', '=', $id_ciclo)
          ->get();

          if (! empty($request->lote) ) {

              $monta = DB::table('sgmontas')
              ->join('sglotemontas', 'sglotemontas.id_lotemonta', '=', 'sgmontas.id_lotemonta')
              ->join('sgciclos', 'sgciclos.id_ciclo', '=', 'sglotemontas.id_ciclo')
              ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sgmontas.idtipoentrante')
              ->where('sgciclos.id_ciclo','=',$id_ciclo)
              ->get();
          } else {

            $monta = DB::table('sgmontas')
            ->join('sglotemontas', 'sglotemontas.id_lotemonta', '=', 'sgmontas.id_lotemonta')
            ->join('sgciclos', 'sgciclos.id_ciclo', '=', 'sglotemontas.id_ciclo')
            ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sgmontas.idtipoentrante')
            ->where('sgciclos.id_ciclo','=',$id_ciclo)
            ->get();
        }

        return view('reproduccion.series_lote_monta',compact('finca','temp_reprod','ciclo','lote','sublote', 'seriesrepro' ,'monta'));
    }


    public function asignarserieslotemonta(Request $request, $id_finca, $id, $id_ciclo)
    {

       $finca = \App\Models\sgfinca::findOrFail($id_finca);

                //Validamos los campos Nombre de lote y las series a través de su id
       $request->validate([
         'lote'=>[
          'required',
      ],
      'id'=>[
          'required',
      ],
  ]);

    			/*
    			 * Tiempo o cantidad de Dias que dura la monta.
    			 * Proviene del Calculo de la Diferenecia entre fecha inicial del ciclo y la 
    			 *  Fecha final del ciclo.
    			 */

             $day = Carbon::parse($request->fechainicialciclo)->diffInDays($request->fechafinalciclo);

             $loteMonta = \App\Models\sglotemonta::findOrFail($request->lote); 

             $nombrelote = \App\Models\sglote::findOrFail($loteMonta->id_lote); 

            	/*
            	* Se agrega una variable para diferenciar la serie que se encuentra en estatus activas. 
            	* 0 = serie no está en temporada de monta. 1 = pertenece a unamonta activa.
            	* Este variable pasará a 0 al momento que se haga un cierre de temporada de reproducción.
            	*/ 

            	$montaActiva = 1; 

                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){

                    $series = \App\Models\sganim::findOrFail($request->id[$i]);

                   // $fecregistro = Carbon::now();

                    $montaNuevo = new \App\Models\sgmonta;

                    $montaNuevo->id_serie = $request->id[$i];
                    $montaNuevo->serie = $series->serie;
                    $montaNuevo->finim = $request->fechainicialciclo;
                    $montaNuevo->ffinm = $request->fechafinalciclo;
                    $montaNuevo->tiempo = $day;
                    $montaNuevo->id_lotemonta = $request->lote;
                    $montaNuevo->sub_lote = $request->sublote;
                    $montaNuevo->idtipoentrante = $series->id_tipologia;

                    $montaNuevo-> save(); 

                    /*Aqui ubicamos la cantidad de monta que tiene cada serie y
                    * actualizamos el campo nro_monta
                    */ 

                    $nroMonta = DB::table('sgmontas')
                    ->where('id_serie',$request->id[$i])
                    ->count();

                    $asignarserielotemonta = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['ltemp'=>$nombrelote->nombre_lote,
                     'monta_activa'=>$montaActiva,
                     'nro_monta'=>$nroMonta]);    
                }   

                return back()->with('msj', 'Serie (s) asignada satisfactoriamente');
            }  
/*
***********************************************************************************
		---|> CONTROLES PARA CADA PORCESO DE MONTA <|---	
***********************************************************************************
*/

     public function celos(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
     {

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    		//Muestra todos los lotes de Temporada
        $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Temporada")
        ->get();

        $sublote = DB::table('sgsublotes')
        ->where('sgsublotes.id_finca','=',$id_finca)
        ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
        ->get();

        $usuario = \App\Models\User::all();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

    		/*
    		* ->| Se calculan las fechas y la duración del ciclo.
    		*/	

    		$fechafin = Carbon::parse($temp_reprod->fecini)->addDay(90)->format('Y-m-d');
    		
    		//se restan los meses para obtener los meses transcurridos. 
         $months = Carbon::parse($temp_reprod->fecini)->diffInMonths($fechafin) + 1;

	        $dt = $months * 30; //días Transcurridos

	        $day = Carbon::parse($temp_reprod->fecini)->diffInDays($fechafin)-$dt;

	        $duracion = $months."-".$day;

    		/*
    		*->| Fin 
    		*/
    		
            $series = \App\Models\sganim::findOrFail($id_serie);

            $raza = \App\Models\sgraza::findOrFail($series->idraza);

            $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_finca','=',$id_finca)
            ->paginate(5);
            
            $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_finca','=',$id_finca)->get();

            $prenhez = \App\Models\sgprenhez::where('id_serie','=',$id_serie)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_finca','=',$id_finca)->get();

            /*
            * Con esta consulta ubicamos el parametros días entre celo 
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
            	//$dec = Días entre Celo
            	$dec = $key->diasentrecelo; 
            }

            return view('reproduccion.formulario_celos', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion','celos','series','usuario', 'raza', 'dec'));
        }


        public function crear_celos(Request $request, $id_finca, $id, $id_ciclo, $id_serie)

        {

        	$ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

            $request->validate([
                'resp'=> [
                    'required',
             //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                ],
                'fregistro'=> [
                    'required',
                ],
            ]);            
            /*
            * Identifica si el registro proviene de una temporada
            * 0 = Registro no es de temporada / 1 = Registro es de una temporada
            */
            $estemporada= 1; 
			/*
			* ->| Se registran los nuevos Celos
			*/
            $celoNuevo = new \App\Models\sgcelo;

            $celoNuevo->id_serie = $id_serie;
            $celoNuevo->serie = $request->serie;
            $celoNuevo->fechr = $request->fregistro;
            $celoNuevo->dias = $request->ier;
            $celoNuevo->resp = $request->resp;
            $celoNuevo->fecestprocel  = $request->fproxcelo;
            $celoNuevo->intdiaabi = $request->ida;
            $celoNuevo->estemporada = $estemporada;
            $celoNuevo->id_ciclo = $id_ciclo;
            $celoNuevo->id_finca = $id_finca;

            $celoNuevo-> save(); 
            /*
			* ->| Se registran los nuevos Celos en el historial. 
			*/
			$historias = 0;

            $celoHistorial = new \App\Models\sghistcelo;

            $celoHistorial->id_serie = $id_serie;
            $celoHistorial->serie = $request->serie;
            $celoHistorial->fechr = $request->fregistro;
            $celoHistorial->dias = $request->ier;
            $celoHistorial->resp = $request->resp;
            $celoHistorial->fecestprocel  = $request->fproxcelo;
            $celoHistorial->intdiaabi = $request->ida;
            $celoHistorial->estemporada = $estemporada;
            $celoHistorial->id_ciclo = $id_ciclo;
            $celoHistorial->nciclo = $ciclo->ciclo;
            $celoHistorial->historias= $historias;

            $celoHistorial-> save(); 
            /*
            * Se cuentan la cantidad de celos por la fecha de registro.
            */
            $countcelo =  DB::table('sgcelos')
            ->where('fechr','=',$request->fregistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nrocelo = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$request->fregistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nrocelo'=>$countcelo]);     
            /*
            * Actualiza el campo fecha del último celo. 
            */
            $ultimocelo = DB::table('sganims')
            ->where('id','=',$request->idserie)
            ->where('id_finca','=', $id_finca)
            ->update(['fecuc'=>$request->fregistro]); 

            return back()->with('msj', 'Registro agregado satisfactoriamente');
        }

        public function editar_celos($id_finca, $id, $id_ciclo, $id_serie, $id_celo)
        {

        	$finca = \App\Models\sgfinca::findOrFail($id_finca);

           $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

           $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

           $celos = \App\Models\sgcelo::findOrFail($id_celo);	

           $series = \App\Models\sganim::findOrFail($celos->id_serie);

           $raza = \App\Models\sgraza::findOrFail($series->idraza);

           $usuario = \App\Models\User::all();

    		/*
            * Con esta consulta ubicamos el parametros días entre celo 
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
            	//$dec = Días entre Celo
            	$dec = $key->diasentrecelo; 
            }

            return view('reproduccion.editar_celo', compact('ciclo','finca', 'temp_reprod','celos','series','raza','usuario', 'dec'));
        }

        public function update_celos(Request $request, $id, $id_finca, $id_ciclo, $id_serie, $id_celo)
        {

            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([

             'fregistro'=> [
                'required',
            ],
            'resp'=>[
             'required',
         ],

     ]);


 			$estemporada = 1; //Proviene de una Temporada la actualizacion	

            $celosUpdate = \App\Models\sgcelo::findOrFail($id_celo);

            $fecha= $celosUpdate->fechr;

            $celosUpdate->fechr = $request->fregistro;
            $celosUpdate->dias = $request->ier;
            $celosUpdate->resp = $request->resp;
            $celosUpdate->fecestprocel  = $request->fproxcelo;
            $celosUpdate->intdiaabi = $request->ida;
            $celosUpdate->estemporada = $estemporada;
            $celosUpdate->id_ciclo = $id_ciclo;
            $celosUpdate->id_finca = $id_finca;

            $celosUpdate-> save(); 

            $celoHistUpdate = \App\Models\sghistcelo::findOrFail($id_celo);

            $celoHistUpdate->fechr = $request->fregistro;
            $celoHistUpdate->dias = $request->ier;
            $celoHistUpdate->resp = $request->resp;
            $celoHistUpdate->fecestprocel  = $request->fproxcelo;
            $celoHistUpdate->intdiaabi = $request->ida;
            $celoHistUpdate->estemporada = $estemporada;
            $celoHistUpdate->id_ciclo = $id_ciclo;

            $celoHistUpdate-> save(); 

            /*
            * Se cuentan la cantidad de celos por la fecha de registro.
            */
            $countcelo =  DB::table('sgcelos')
            ->where('fechr','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nroceloantes = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nrocelo'=>$countcelo]);          

            $countceloahora =  DB::table('sgcelos')
            ->where('fechr','=',$request->fregistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count();         

            $nrocelo = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$request->fregistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nrocelo'=>$countceloahora]);  
            /*
            * Actualiza el campo fecha del último celo. 
            */
            $ultimocelo = DB::table('sganims')
            ->where('id','=',$request->idserie)
            ->where('id_finca','=', $id_finca)
            ->update(['fecuc'=>$request->fregistro]);  

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

        public function eliminar_celo($id_finca, $id, $id_ciclo, $id_serie, $id_celo)
        {

           $series = \App\Models\sganim::findOrFail($id_serie);

           $celoEliminar = \App\Models\sgcelo::findOrFail($id_celo);
           $celoHistEliminar = \App\Models\sghistcelo::findOrFail($id_celo);

           $fecha= $celoEliminar->fechr;    
           try {
            $celoEliminar->delete();
            $celoHistEliminar->delete();
             /*
            * Se cuentan la cantidad de celos por la fecha de registro.
            */
             $countcelo =  DB::table('sgcelos')
             ->where('fechr','=',$fecha)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->count(); 

             $nrocelo = DB::table('sghistoricotemprepros')
             ->where('fecharegistro','=',$fecha)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->update(['nrocelo'=>$countcelo]);     

             $ultimafechacelo = DB::table('sgcelos')
             ->select(DB::raw('MAX(fechr) as ultfechacelo'))
             ->where('serie', '=', $series->serie)
             ->get();
			/*
			*->| Comprueba el ultimo celo y actualiza el campo Fecha ultimo celo en la tabla sganims.  
			*/	
			foreach ($ultimafechacelo as $key) {
             $ultfechacelo = $key->ultfechacelo;
         }	

         $ultimocelo = DB::table('sganims')
         ->where('id','=',$id_serie)
         ->where('id_finca','=', $id_finca)
         ->update(['fecuc'=>$ultfechacelo]);	


         return back()->with('mensaje', 'ok');     

     }catch (\Illuminate\Database\QueryException $e){
        return back()->with('mensaje', 'error');
    }

}

     /*
     *--> Registros de Servicios
     */  
     public function servicio(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
     {

  			/*
  			*-> Aquí debe ir un procedimiento que busque un celo registrado menos de un día
  			para que pueda registrar el servicio. Sino se envía un mensaje informandoq ue se
  			debe registrar primero un celo y luego hacer el servicio
  			*/

            //Se busca la finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

            $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    		//Muestra todos los lotes de Temporada
            $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
            ->where('tipo', '=', "Temporada")->get();

            $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
            ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
            ->get();

            $usuario = \App\Models\User::all();


            $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
            ->get();

            $status=1;

            $tipologia = DB::table('sgtipologias')
            ->select(DB::raw('MAX(peso) as pesomax'))
            ->where('id_finca','=',$id_finca)
            ->get(); 

            foreach ($tipologia as $key) {
               $pesotipo = $key->pesomax; 	
           }	 

           $series = \App\Models\sganim::findOrFail($id_serie);

            //*************************************************
		        //Se calcula con la herramienta carbon la edad
           $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
           $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
           $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
           $edad = $year."-".$months;
		    //*************************************************

           $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

           $raza = \App\Models\sgraza::findOrFail($series->idraza);

           $servicio = \App\Models\sgserv::where('sgservs.id_serie','=',$id_serie)
           ->select('sgservs.id','sgservs.serie', 'sgservs.fecha', 'sgservs.toro', 'sgservs.paju','sgservs.snro','sgservs.edad','sgservs.peso','sgservs.nomi','sgtipologias.nomenclatura')
           ->join('sgtipologias','sgtipologias.id_tipologia','=','sgservs.id_tipologia')
           ->where('sgservs.id_ciclo','=',$id_ciclo)
           ->where('sgservs.id_finca','=',$id_finca)
           ->paginate(5);

           $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
           ->where('id_ciclo','=',$id_ciclo)
           ->where('id_finca','=',$id_finca)->get();

           $prenhez = \App\Models\sgprenhez::where('id_serie','=',$id_serie)
           ->where('id_ciclo','=',$id_ciclo)
           ->where('id_finca','=',$id_finca)->get();

           $pajuela = \App\Models\sgpaju::where('cant', '>', 0)->get();

           $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
           ->where('pesoactual','>=',$pesotipo)
	            ->where('sexo','=',1) //Sexo macho
	            ->where('destatado','=',1) //Que se encuentre destetado
	            ->where('status','=',$status)->get();	

                return view('reproduccion.formulario_servicio', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','servicio','series','usuario', 'raza','condicorpo','pajuela','serietoro','edad'));
            }

            public function crear_servicio(Request $request, $id_finca, $id, $id_ciclo, $id_serie)

            {

       	//Valida que el serial provenga de una Serie Toro o Pajuela.
                $seriepadre = ($request->serie_macho=="1")?($seriepadre=null):($seriepadre=$request->seriepadre);       
                $codpajuela = ($request->serie_macho=="0")?($codpajuela=null):($codpajuela = $request->paju);

                $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

                $series = \App\Models\sganim::findOrFail($id_serie);

                $tipologia = \App\Models\sgtipologia::findOrFail($series->id_tipologia);

                if ($request->serie_macho=="1") {

                  $request->validate([
                     'paju'=> [
                         'required',
                     ],
                     'cantpaju'=> [
                         'required',
                     ],
                     'resp'=> [
                         'required',
                     ],
                     'fregistro'=> [
                         'required',
                     ],
                 ]);      	   
              } else {
                  $request->validate([
                     'seriepadre'=> [
                         'required',
                     ],
                     'fregistro'=> [
                         'required',
                     ],
                 ]);
              }

              $snro = DB::table('sgservs')
              ->select(DB::raw('MAX(snro) as snro'))
              ->where('id_serie', '=', $id_serie)
              ->where('id_finca','=',$id_finca)
              ->get();

              foreach ($snro as $key) {
                 $numeroServicio = $key->snro;
             }

             $numeroServicio = $numeroServicio + 1;
        /*
        * Identifica si el registro proviene de una temporada
        * 0 = Registro no es de temporada / 1 = Registro es de una temporada
        */
        $estemporada= 1; 
		/*
		* ->| Se registran los nuevos Celos
		*/
        $servicioNuevo = new \App\Models\sgserv;

        $servicioNuevo->id_serie = $id_serie;
        $servicioNuevo->serie = $request->serie;
        $servicioNuevo->fecha = $request->fregistro;
        $servicioNuevo->toro = $seriepadre;
        $servicioNuevo->paju = $codpajuela;
        $servicioNuevo->espajuela = $request->serie_macho;
        $servicioNuevo->marca = $request->marca; //Este campo no existe
        $servicioNuevo->snro  = $numeroServicio;
        $servicioNuevo->nomi = $request->resp;
        $servicioNuevo->iers = $request->ier;
        $servicioNuevo->edad = $request->edad;
        $servicioNuevo->peso = $request->pesoactual;
        $servicioNuevo->id_ciclo = $id_ciclo;
        $servicioNuevo->id_finca = $id_finca;
        $servicioNuevo->id_tipologia = $series->id_tipologia;

        $servicioNuevo-> save(); 
        /*
		* ->| Se registran los nuevos servicios en el historial. 
		*/
		$historias = 0;

        $servicioHistorial = new \App\Models\sgserv_historico;

        $servicioHistorial->id_serie = $id_serie;
        $servicioHistorial->serie = $request->serie;
        $servicioHistorial->fecha = $request->fregistro;
        $servicioHistorial->toro = $seriepadre;
        $servicioHistorial->paju = $codpajuela;
        $servicioHistorial->espajuela = $request->serie_macho;
        $servicioHistorial->marca = $request->marca; //Este campo no existe
        $servicioHistorial->snro  = $numeroServicio;
        $servicioHistorial->nomi = $request->resp;
        $servicioHistorial->iers = $request->ier;
        $servicioHistorial->edad = $request->edad;
        $servicioHistorial->peso = $request->pesoactual;
        $servicioHistorial->id_ciclo = $id_ciclo;
        $servicioHistorial->id_finca = $id_finca;
        $servicioHistorial->id_tipologia = $series->id_tipologia;
        $servicioHistorial->historias = $historias;
        $servicioHistorial->nciclo = $ciclo->ciclo;
        
        $servicioHistorial-> save(); 

    	/*
        * Se cuentan la cantidad de servicios por la fecha de registro.
        */
        $countserv =  DB::table('sgservs')
        ->where('fecha','=',$request->fregistro)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->count(); 

        $nroservicio = DB::table('sghistoricotemprepros')
        ->where('fecharegistro','=',$request->fregistro)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->update(['nroservicio'=>$countserv]);     
        /*
        * Actualiza el campo fecha del último servicio. 
        */
        $ultimoServicio = DB::table('sganims')
        ->where('id','=',$id_serie)
        ->where('id_finca','=', $id_finca)
        ->update(['fecus'=>$request->fregistro,
         'nservi'=>$numeroServicio]); 

        if ($request->serie_macho=="1") {
	        /*
	    	*-> Calculamos la cantidad disponible de pajuela
	    	*/
	    	$cantdispaju = DB::table('sgpajus')
            ->select('cant')
            ->where('serie','=',$request->paju)
            ->where('id_finca','=', $id_finca)
            ->get();

            foreach ($cantdispaju as $item) {
             $disponible= (int) $item->cant;
         }

         $canttotal = $disponible - $request->cantpaju;   
        /*
        * Actualiza el campo cant de pajuela con la variable $canttotal
        */      

        $cantpajuela = DB::table('sgpajus')
        ->where('serie','=',$request->paju)
        ->where('id_finca','=', $id_finca)
        ->update(['cant'=>$canttotal]);
    } 
        /*
        * Actualizamos a tabla mvmadres   
        */
        #Buscamos el Numero de parto que tiene la serie
        $nroParto = DB:: table('sgpartos')
        ->where('id_finca','=',$id_finca)
        ->where('id_serie','=',$id_serie)
        ->get();

        #Buscamos el Numero de abortos que tiene la serie
        $nroAborto = DB:: table('sgabors')
        ->where('id_finca','=',$id_finca)
        ->where('id_serie','=',$id_serie)
        ->get();

        #Buscamos el Numero de abortos que tiene la serie
        $nroServicios = DB:: table('sgservs')
        ->where('id_finca','=',$id_finca)
        ->where('id_serie','=',$id_serie)
        ->get();        

        $npartos = $nroParto->count(); 
        $nabortos = $nroAborto->count();
        $nservicios = $nroServicios->count(); 
        /*
        * Actualizamos la tabla mvmadres
        */
        $fecsistema = Carbon::now();
        /* 
        * Para Crear el registro primero se verifica que la serie no tenga
        * Un Registro en la tabla. 
        */
        $buscaMvMadre = \App\Models\sgmvmadre::where('codmadre','=',$series->serie)
        ->where('id_finca','=',$id_finca)
        ->get();

        foreach ($buscaMvMadre as $key ) {
            $codmadre= $key->codmadre; 
        }   

        if ($buscaMvMadre->count()>0) {
                # Si existe, actualizamos los registros 
            try{
                //$prenezNueva-> save();
                $updateMvMadre = DB::table('sgmvmadres')
                ->where('codmadre','=',$codmadre)
                ->update(['fnac'=>$series->fnac,
                 'tipologia'=>$series->tipo,
                 'id_tipologia'=>$tipologia->id_tipologia,
                 'npartos'=>$npartos,
                 'nabortos'=>$nabortos,
                 'nservicios'=>$nservicios,
                 'lote'=>$series->lote,
                 'observacion'=>$series->observa,
                 'faproxparto'=>$request->faproparto,
                 'IDA'=>$request->ida,
                 'fepre'=>$request->festipre,
                 'fecs'=>$fecsistema,
                 'fecup'=>$request->fecharegistro,
                 'vaquera'=>null,    
                 'id_finca'=>$id_finca]); 
            }catch (\Illuminate\Database\QueryException $e){
                return back()->with('mensaje', 'error');
            }       
        } else {

            $mvMadreNueva = new \App\Models\sgmvmadre;

            $mvMadreNueva->codmadre = $series->serie;
            $mvMadreNueva->fnac = $series->fnac;
            $mvMadreNueva->tipologia = $series->tipo;
            $mvMadreNueva->id_tipologia = $tipologia->id_tipologia;
            $mvMadreNueva->npartos = $request->nroparto;
            $mvMadreNueva->nabortos = $request->nroaborto;
            $mvMadreNueva->nservicios = $nservicios;
            $mvMadreNueva->lote = $series->lote;
            $mvMadreNueva->observacion = $series->observa;
            $mvMadreNueva->faproxparto = $request->faproparto;
            $mvMadreNueva->IDA = $request->ida;
            $mvMadreNueva->fepre = $request->festipre;
            $mvMadreNueva->fecs = $fecsistema;
            $mvMadreNueva->fecup = $request->fecharegistro;
            $mvMadreNueva->vaquera = null;
            $mvMadreNueva->id_finca = $id_finca;

            $mvMadreNueva->save();  
        }

        return back()->with('msj', 'Registro agregado satisfactoriamente');

    }

    public function editar_servicio($id_finca, $id, $id_ciclo, $id_serie, $id_servicio)
    {

     $finca = \App\Models\sgfinca::findOrFail($id_finca);

     $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

     $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

     $servicio = \App\Models\sgserv::findOrFail($id_servicio);	

     $series = \App\Models\sganim::findOrFail($servicio->id_serie);

     $raza = \App\Models\sgraza::findOrFail($series->idraza);

     $tipologia = \App\Models\sgtipologia::findOrFail($servicio->id_tipologia);

     $usuario = \App\Models\User::all();

     $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
     $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
     $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
     $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
     $edad = $year."-".$months;
		    //*************************************************
     $status = 1; 

     $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
     ->where('codpadre','<>',Null)
	            ->where('id_tipologia','=',18) //hardcod
	            ->where('status','=',$status)->get();	    

              $pajuela = \App\Models\sgpaju::where('cant', '>', 0)->get();

              return view('reproduccion.editar_servicio', compact('ciclo','finca', 'temp_reprod','servicio','series','raza','usuario','tipologia','edad','condicorpo','serietoro','pajuela'));
          }

          public function update_servicio(Request $request, $id, $id_finca, $id_ciclo, $id_serie, $id_servicio)
          {


        	//Valida que el serial provenga de una Serie Toro o Pajuela.
             $seriepadre = ($request->serie_macho=="1")?($seriepadre=null):($seriepadre=$request->seriepadre);

             $codpajuela = ($request->serie_macho=="0")?($codpajuela=null):($codpajuela = $request->paju);

             if ($request->serie_macho=="1") {

               $request->validate([
                  'paju'=> [
                      'required',
                  ],
                  'cantpaju'=> [
                      'required',
                  ],
                  'resp'=> [
                      'required',
                  ],
                  'fregistro'=> [
                      'required',
                  ],
              ]);
           } else {
               $request->validate([
                  'seriepadre'=> [
                      'required',
                  ],
                  'fregistro'=> [
                      'required',
                  ],
              ]);
           }

 			$estemporada = 1; //Proviene de una Temporada la actualizacion	

            $servicioUpdate = \App\Models\sgserv::findOrFail($id_servicio);

            $fecha = $servicioUpdate->fecha; 

            $servicioUpdate->fecha = $request->fregistro;
            $servicioUpdate->toro = $seriepadre;
            $servicioUpdate->paju = $codpajuela;
            $servicioUpdate->espajuela = $request->serie_macho;
	        $servicioUpdate->marca = $request->marca; //Este campo no existe
	       // $servicioUpdate->snro  = $numeroServicio;
	        $servicioUpdate->nomi = $request->resp;
	        $servicioUpdate->iers = $request->ier;
	        $servicioUpdate->edad = $request->edad;
	        $servicioUpdate->peso = $request->pesoactual;

            $servicioUpdate-> save(); 


            $servicioHistUpdate = \App\Models\sgserv_historico::findOrFail($id_servicio);

            $servicioHistUpdate->fecha = $request->fregistro;
            $servicioHistUpdate->toro = $seriepadre;
            $servicioHistUpdate->paju = $codpajuela;
            $servicioHistUpdate->espajuela = $request->serie_macho;
	        $servicioHistUpdate->marca = $request->marca; //Este campo no existe
	        //$servicioHistUpdate->snro  = $numeroServicio;
	        $servicioHistUpdate->nomi = $request->resp;
	        $servicioHistUpdate->iers = $request->ier;
	        $servicioHistUpdate->edad = $request->edad;
	        $servicioHistUpdate->peso = $request->pesoactual;
	        
	        $servicioHistUpdate-> save(); 

	        /*
	        * Se cuentan la cantidad de servicios por la fecha de registro.
	        */
	        $countserv =  DB::table('sgservs')
         ->where('fecha','=',$fecha)
         ->where('id_finca','=', $id_finca)
         ->where('id_ciclo','=', $id_ciclo)
         ->count(); 

         $nroservicioantes = DB::table('sghistoricotemprepros')
         ->where('fecharegistro','=',$fecha)
         ->where('id_finca','=', $id_finca)
         ->where('id_ciclo','=', $id_ciclo)
         ->update(['nroservicio'=>$countserv]);          

         $countservahora =  DB::table('sgservs')
         ->where('fecha','=',$request->fregistro)
         ->where('id_finca','=', $id_finca)
         ->where('id_ciclo','=', $id_ciclo)
         ->count();                     

         $nroservicio = DB::table('sghistoricotemprepros')
         ->where('fecharegistro','=',$request->fregistro)
         ->where('id_finca','=', $id_finca)
         ->where('id_ciclo','=', $id_ciclo)
         ->update(['nroservicio'=>$countservahora]);

            /*
            * Actualiza el campo fecha del último servicio y nro_monta.
            * Ya que un servicio es una monta 
            */
            $ultimoservicio = DB::table('sganims')
            ->where('id','=',$request->id_serie)
            ->where('id_finca','=', $id_finca)
            ->update(['fecus'=>$request->fregistro,
             'nservi'=>$countservahora]);  

            if ($request->cantpaju > 0) {
	            /*
		    	*-> Calculamos la cantidad disponible de pajuela
		    	*/
		    	$cantdispaju = DB::table('sgpajus')
             ->select('cant')
             ->where('serie','=',$request->paju)
             ->where('id_finca','=', $id_finca)
             ->get();

             foreach ($cantdispaju as $item) {
              $disponible= (int) $item->cant;
          }

          $canttotal = $disponible - $request->cantpaju;  

		        /*
		        * Actualiza el campo cant de pajuela con la variable $canttotal
		        */      
		        $cantpajuela = DB::table('sgpajus')
              ->where('serie','=',$request->paju)
              ->where('id_finca','=', $id_finca)
              ->update(['cant'=>$canttotal]);                        
          }                        

          return back()->with('msj', 'Registro actualizado satisfactoriamente');
      }

      public function eliminar_servicio($id_finca, $id, $id_ciclo, $id_serie, $id_servicio)
      {

       $series = \App\Models\sganim::findOrFail($id_serie);

       $servicioEliminar = \App\Models\sgserv::findOrFail($id_servicio);
       $servicioHistEliminar = \App\Models\sgserv_historico::findOrFail($id_servicio);

       $fecha = $servicioEliminar->fecha; 	                
       try {

        $servicioEliminar->delete();
        $servicioHistEliminar->delete();

            /*
	        * Se cuentan la cantidad de servcios por la fecha de registro.
	        */
            $countserv =  DB::table('sgservs')
            ->where('fecha','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nroservicio = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nroservicio'=>$countserv]); 	
            
            $ultimafechaservicio = DB::table('sgservs')
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('id_finca','=',$id_finca)
            ->where('serie', '=', $series->serie)
            ->get();
			/*
			*->| Comprueba el ultimo celo y actualiza el campo Fecha ultimo celo en la tabla sganims.  
			*/	
			foreach ($ultimafechaservicio as $key) {
             $ultfechaservicio = $key->ultservicio;
         }	

         $ultimoserv = DB::table('sganims')
         ->where('id','=',$id_serie)
         ->where('id_finca','=', $id_finca)
         ->update(['fecus'=>$ultfechaservicio,
             'nservi'=>$countserv]);	

         return back()->with('mensaje', 'ok');     

     }catch (\Illuminate\Database\QueryException $e){
        return back()->with('mensaje', 'error');
    }
} 
    /*
    *--> Registros de palpaciones
    */  

    public function palpacion(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
    {
            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    		//Muestra todos los lotes de Temporada
        $lote = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Temporada")->get();

        $sublote = DB::table('sgsublotes')->where('sgsublotes.id_finca','=',$id_finca)
        ->join('sglotes', 'sglotes.nombre_lote', '=', 'sgsublotes.nombre_lote')
        ->get();

        $usuario = \App\Models\User::all();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

        $status=1;

        $series = \App\Models\sganim::findOrFail($id_serie);

            //*************************************************
		        //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
		    //*************************************************

        $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

        $raza = \App\Models\sgraza::findOrFail($series->idraza);

        $servicio = \App\Models\sgserv::where('sgservs.id_serie','=',$id_serie)
        ->select('sgservs.id','sgservs.serie', 'sgservs.fecha', 'sgservs.toro', 'sgservs.paju','sgservs.snro','sgservs.edad','sgservs.peso','sgservs.nomi','sgtipologias.nomenclatura')
        ->join('sgtipologias','sgtipologias.id_tipologia','=','sgservs.id_tipologia')
        ->where('sgservs.id_ciclo','=',$id_ciclo)
        ->where('sgservs.id_finca','=',$id_finca)
        ->paginate(5);

        $palpacion = \App\Models\sgpalp::where('id_serie','=',$id_serie)
        ->join('sgdiagnosticpalpaciones','sgdiagnosticpalpaciones.id_diagnostico','=','sgpalps.id_diagnostico')
        ->where('sgpalps.id_ciclo','=',$id_ciclo)
        ->where('sgpalps.id_finca','=',$id_finca)->paginate(5);	


        $diagnostico =	\App\Models\sgdiagnosticpalpaciones::where('id_finca','=',$id_finca)->get();

        $patologia = \App\Models\sgpatologia::where('id_finca','=',$id_finca)->get();	

        $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->get();

        $prenhez = \App\Models\sgprenhez::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->get();

        $pajuela = \App\Models\sgpaju::where('cant', '>', 0)->get();

        $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
        ->where('codpadre','<>',Null)
        ->where('id_tipologia','=',18)
        ->where('status','=',$status)->get();	

        return view('reproduccion.formulario_palpacion', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','servicio','series','usuario', 'raza','condicorpo','pajuela','serietoro','edad','palpacion','diagnostico','patologia'));
    }

    public function crear_palpacion(Request $request, $id_finca, $id, $id_ciclo, $id_serie)

    {

       	//return $request; 

    	$ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    	$series = \App\Models\sganim::findOrFail($id_serie);

      $request->validate([
         'fecharegistro'=> [
             'required',
         ],
         'diagnostico'=> [
             'required',
         ],
         'resp'=> [
             'required',
         ],
     ]);      	   


      $estemporada= 1; 
		/*
		* ->|Se registran las palpaciones.
		*/
        $palpacionNueva = new \App\Models\sgpalp;

        $palpacionNueva->id_serie = $id_serie;
        $palpacionNueva->serie = $request->serie;
        $palpacionNueva->fechr = $request->fecharegistro;
        $palpacionNueva->resp = $request->resp;
        $palpacionNueva->eval = $request->eval;
        $palpacionNueva->prcita = $request->prcita;
        $palpacionNueva->id_diagnostico = $request->diagnostico;
        $palpacionNueva->id_ciclo = $id_ciclo;
        $palpacionNueva->id_finca = $id_finca;
        $palpacionNueva->patologia = $request->patologia;

        $palpacionNueva-> save(); 

        /*
        * Se cuentan la cantidad de palpaciones por la fecha de registro.
        */
        $countpalps =  DB::table('sgpalps')
        ->where('fechr','=',$request->fecharegistro)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->count(); 

        $nropalpaciones = DB::table('sghistoricotemprepros')
        ->where('fecharegistro','=',$request->fecharegistro)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->update(['nropalpa'=>$countpalps]);     


        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_palpacion($id_finca, $id, $id_ciclo, $id_serie, $id_palpacion)
    {  			
        	//dd($id_finca, $id, $id_ciclo, $id_serie, $id_celo); 

     $finca = \App\Models\sgfinca::findOrFail($id_finca);

     $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

     $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

     $palpacion = \App\Models\sgpalp::findOrFail($id_palpacion);	

     $series = \App\Models\sganim::findOrFail($palpacion->id_serie);

     $raza = \App\Models\sgraza::findOrFail($series->idraza);

     $usuario = \App\Models\User::all();

     $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
     $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
     $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
     $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
     $edad = $year."-".$months;
		    //*************************************************
     $status = 1; 

     $pajuela = \App\Models\sgpaju::where('cant', '>', 0)->get();


     $diagnostico =	\App\Models\sgdiagnosticpalpaciones::all();

     $diagnosticopalpa =	DB::table('sgpalps')
     ->join('sgdiagnosticpalpaciones','sgdiagnosticpalpaciones.id_diagnostico','=','sgpalps.id_diagnostico')
     ->where('sgpalps.id','=',$id_palpacion)
     ->get();

     $patologia = \App\Models\sgpatologia::where('id_finca','=',$id_finca)->get();


     return view('reproduccion.editar_palpacion', compact('ciclo','finca', 'temp_reprod','series','raza','usuario','edad','condicorpo','pajuela','palpacion','diagnostico','patologia','diagnosticopalpa'));
 }

 public function update_palpacion(Request $request, $id, $id_finca, $id_ciclo, $id_serie, $id_palpacion)
 {

        	//return $request; 

   $request->validate([
     'fecharegistro'=> [
         'required',
     ],
     'diagnostico'=> [
         'required',
     ],
     'resp'=> [
         'required',
     ],
 ]);    

 			$estemporada = 1; //Proviene de una Temporada la actualizacion	

            $palpacionUpdate = \App\Models\sgpalp::findOrFail($id_palpacion);

            $fecha= $palpacionUpdate->fechr;

            $palpacionUpdate->fechr = $request->fecharegistro;
            $palpacionUpdate->resp = $request->resp;
            $palpacionUpdate->eval = $request->eval;
            $palpacionUpdate->prcita = $request->prcita;
            $palpacionUpdate->id_diagnostico = $request->diagnostico;
            $palpacionUpdate->patologia = $request->patologia;
            
            $palpacionUpdate-> save(); 
            /*
	        * Se cuentan la cantidad de servicios por la fecha de registro.
	        */
            $countpalps =  DB::table('sgpalps')
            ->where('fechr','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nropalpsantes = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropalpa'=>$countpalps]);          

            $countpalpsahora =  DB::table('sgpalps')
            ->where('fechr','=',$request->fecharegistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count();                     

            $nropalpaciones = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$request->fecharegistro)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropalpa'=>$countpalpsahora]);

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }


        public function eliminar_palpacion($id_finca, $id, $id_ciclo, $id_serie, $id_palpacion)
        {

           $series = \App\Models\sganim::findOrFail($id_serie);

           $palpacionEliminar = \App\Models\sgpalp::findOrFail($id_palpacion);

           $fecha= $palpacionEliminar->fechr;     

           try {

            $palpacionEliminar->delete();

            /*
	        * Se cuentan la cantidad de celos por la fecha de registro.
	        */
            $countpalps =  DB::table('sgpalps')
            ->where('fechr','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nropalps = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropalpa'=>$countpalps]); 	

            return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    } 	

/*
*--> Controladores de Preñez
*/
public function prenez(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
{
            //Se busca la finca por su id - Segun modelo
    $finca = \App\Models\sgfinca::findOrFail($id_finca);

    $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

    $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);
    
    $usuario = \App\Models\User::all();

    $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
    ->get(); 	

    $series = \App\Models\sganim::findOrFail($id_serie);

    $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

    $metodo = DB::table('sgtipomontas')
    ->where('id','=',$ciclo->id_tipomonta)
    ->get();

    foreach ($metodo as $key) {
        $idtipomonta = $key->id;
    }	
    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
    $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
    $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
    $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
    $edad = $year."-".$months;
		    //*************************************************


    $raza = \App\Models\sgraza::findOrFail($series->idraza);

    $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
    ->where('id_ciclo','=',$id_ciclo)
    ->where('id_finca','=',$id_finca)
    ->paginate(5);

    $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
    ->where('id_ciclo','=',$id_ciclo)
    ->where('id_finca','=',$id_finca)->get();

    $prenhez = \App\Models\sgprenhez::where('id_serie','=',$id_serie)
    ->where('id_ciclo','=',$id_ciclo)
    ->where('id_finca','=',$id_finca)->paginate(5);
            /*
            * Identificamos que la serie que se le intenta registrar la preñez no esta preñada
            */

            /*
          	* Aqui actualizamos la Tipologia en caso de una preñez
          	* ya que es un proceso que conlleva a eso.
          	*/
        	#Buscamos la tipologia actual 
          	$tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();

          	#Obtenemos todos parametros de la tipologia

          	foreach ($tipoActual as $key ) {
          		$tipologiaName = $key->nombre_tipologia;
          		$edad = $key->edad;
          		$peso = $key->peso;
          		$destetado = $key->destetado;
          		$sexo = $key->sexo;
          		$nro_monta = $key->nro_monta;
          		$prenada = $key->prenada;
          		$parida = $key->parida;
          		$tienecria = $key->tienecria;
          		$criaviva = $key->criaviva;
          		$ordenho = $key->ordenho;
          		$detectacelo = $key->detectacelo;
          		$idtipo = $key->id_tipologia;
          	}
            /*
            *-> Se crea un identificador para saber si la serie se le ha practicado
            * un servicio en menos de 90 días.
            */	
            $servicioReciente = DB::table('sgservs')  
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($servicioReciente as $key) {
             $ultservicio = $key->ultservicio;
         }		

            /*
            * Con el Valor de la feha del ultimo servicio se calcula la diferencia en días 
            * con Carbon y ver si es menor a 45 días.. 
            */
            $diasServicio = Carbon::parse($ultservicio)->diffInDays(Carbon::now());

            if (!($ultservicio==null) and $diasServicio<45) {
             $servicioActivo = 1; 
           		//return "Es inseminacion";
         } else {
             $servicioActivo = 0;
           		//return "Monta Natural";
         }
            /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tgesta = $key->tiempogestacion; 
            }
            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pP = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pP as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tsecado = $key->diassecado; 
            }

            return view('reproduccion.formulario_prenez', compact('ciclo','finca', 'temp_reprod','tipomonta','edad','celos','series','usuario', 'raza','condicorpo','prenhez','diasServicio','tgesta','tsecado','servicioActivo','idtipomonta'));
        }


        public function crear_prenez(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
        {

        	

        	$ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

        	$tipomonta = \App\Models\sgtipomonta::findOrFail($request->metodo_prenez);

        	$series = \App\Models\sganim::findOrFail($id_serie);
        	/*
        	* Aquí consultamos el último servicio realizado para la serie
        	* Consultada.
        	*/
        	$ultimoservicio = DB::table('sgservs')
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
				/*
				*->| Comprueba el ultimo servicio 
				*/
				foreach ($ultimoservicio as $key) {
                  $fechaultimoservicio = $key->ultservicio;
              }	
				/*
				* Aquí hacemos la consulta eloquent donde obtendremos el JSON de la tabla basado en el criterio de consulta anterior
				*/	
				$servicio = DB::table('sgservs')
                 ->where('serie', '=', $series->serie)
                 ->where('fecha', '=', $fechaultimoservicio)
                 ->where('id_finca','=',$id_finca)
                 ->get();
				/*
				*-|> Fin de Consulta de Servicio
				*/	
        	 /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
             $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $id_finca)->get();

             foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
               $tgesta = $key->tiempogestacion; 
           }

           $metodo = $tipomonta->nombre; 

            #Aqui se comprueba el tipo de métdos para asi validar los campos
           if ($request->metodo_prenez == 1) {
                # Viene del método inseminación artificial/ Monta Controlada 
            $request->validate([
                'diaprenez'=> [
                    'required',
                 //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                ],
                'fecharegistro'=> [
                    'required',
                ],
            ]);
                /*
                * Se hardcod el métodop porque se presume que no cambian con 
                * el tiempo
                */
                /*
                * se recorre el JSON para Obtener los valores obtenidos.
                */  
                foreach ($servicio as $item) {
                    $toropaj = $item->paju;
                    $torotemp = $item->toro;
                    $nomi = $item->nomi; 
                }  
            } else {
                # Viene del méodo Monta Libre
                $request->validate([
                    'mesesprenez'=> [
                        'required',
                 //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                    ],
                    'fecharegistro'=> [
                        'required',
                    ],
                ]);
                /*Se hardcod el métodop porque se presume que no cambian con 
                * el tiempo
                */
                //$metodo = $tipomonta->nombre;

                /*
                * Se pasa los valores a nulo porque se trata de una monta natural 
                * Se desconoce los valores del Toro Padre o Pajuela. 
                */
                $toropaj = null;
                $torotemp = null;
                $nomi = null; 
                
            }
			/* 
        	* Para Crear una preñez, primero se verifica que la serie no tenga
        	* Un Registro de preñez en curso con tiempo de gestación menor al 
        	* Parametro Configurado
        	*/
        	$buscaPrenez = \App\Models\sgprenhez::where('id_serie','=',$id_serie)
          ->where('id_finca','=',$id_finca)
          ->get();

          foreach ($buscaPrenez as $key ) {
           $fep = $key->fepre;
           $idprenez= (int) $key->id; 
       }	

        	# Si existe la preñez		
       if ($buscaPrenez->count()>0) {
        		# Si exite calculamos los días transcurridos de gestción.
        		$tgc = Carbon::parse($request->fecharegistro)->diffInDays($fep);//Tiempo de Gestación Trasncurridos
        		
        		if ($tgc < $tgesta) {
        				#Se envía el mensaje
                  return back()->with('info', 'ok');  
              } else {

        			/*
		            * Identifica si el registro proviene de una temporada
		            * 0 = Registro no es de temporada / 1 = Registro es de una temporada
		            */

                 $estemporada= 1; 
					/*
					* ->| Se registran las nuevas preñez (Actualiza el campo)
					*/
                  try{
		         		//$prenezNueva-> save();
                      $updatePreñez = DB::table('sgprenhezs')
                      ->where('id','=',$idprenez)
                      ->update(['fecap'=>$request->faproparto,
                       'fecas'=>$request->faprosecado,
                       'fecser'=>$request->fecus,
                       'toropaj'=>$toropaj,
                       'nomi'=>$nomi,
                       'torotemp'=>$torotemp,
                       'fregp'=>$request->fecharegistro,
                       'intdiaabi'=>$request->ida,
                       'intestpar'=>$request->ier,
                       'pesopre'=>$request->pesoactual,
                       'mesespre'=>$request->mesesprenez,
                       'dias_prenez'=>$request->diaprenez,
                       'metodo'=>$metodo,    
                       'fepre'=>$request->festipre]); 
                      $prenez = 1;  	
                  }catch (\Illuminate\Database\QueryException $e){
                   $prenez = 0; 
                   return back()->with('mensaje', 'error');
               }

		            /*
					* ->| Se registran las nuevas Preñez en el historial. 
					*/
					$historias = 0;

                  $prenezHistorial = new \App\Models\sgprenhez_historico;

                  $prenezHistorial->id_serie = $id_serie;
                  $prenezHistorial->serie = $request->serie;
                  $prenezHistorial->fecap = $request->faproparto;
                  $prenezHistorial->fecas = $request->faprosecado;
                  $prenezHistorial->fecser = $request->fecus;

                  $prenezHistorial->toropaj = $toropaj;
                  $prenezHistorial->nomi = $nomi;
                  $prenezHistorial->torotemp = $torotemp;

                  $prenezHistorial->fregp = $request->fecharegistro;
                  $prenezHistorial->intdiaabi = $request->ida;
                  $prenezHistorial->intestpar = $request->ier;
                  $prenezHistorial->pesopre = $request->pesoactual;
                  $prenezHistorial->dias_prenez = $request->diaprenez;
                  $prenezHistorial->mesespre = $request->mesesprenez;
                  $prenezHistorial->metodo = $metodo;
                  $prenezHistorial->fepre = $request->festipre;

                  $prenezHistorial->id_ciclo = $id_ciclo;
                  $prenezHistorial->id_finca = $id_finca;

                  $prenezHistorial-> save(); 

		            /*
			        * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
			        */
                   $countprenez =  DB::table('sgprenhez_historicos')
                   ->where('fregp','=',$request->fecharegistro)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->count(); 

                   $nroprenez = DB::table('sghistoricotemprepros')
                   ->where('fecharegistro','=',$request->fecharegistro)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->update(['nropre'=>$countprenez]);   			                                
		           	/*
		          	* Aqui actualizamos la Tipologia en caso de una preñez
		          	* ya que es un proceso que conlleva a eso.
		          	*/
	            	#Buscamos la tipologia actual 
		          	$tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();

		          	#Obtenemos todos parametros de la tipologia

		          	foreach ($tipoActual as $key ) {
		          		$tipologiaName = $key->nombre_tipologia;
		          		$edad = $key->edad;
		          		$peso = $key->peso;
		          		$destetado = $key->destetado;
		          		$sexo = $key->sexo;
		          		$nro_monta = $key->nro_monta;
		          		$prenada = $key->prenada;
		          		$parida = $key->parida;
		          		$tienecria = $key->tienecria;
		          		$criaviva = $key->criaviva;
		          		$ordenho = $key->ordenho;
		          		$detectacelo = $key->detectacelo;
		          		$idtipo = $key->id_tipologia;
		          	}

			        #Actualizamos la tipologia
	                #Obteneos la tipologia anterior
		          	$tipoAnterior = $tipologiaName;
		          	
		          	$nroMonta = $series->nro_monta;


	            	# Actualizamos si se efectua la preñez.
                  $tipologia= DB::table('sgtipologias')
                  ->where('edad','=',$edad)
                  ->where('peso','=',$peso)
                  ->where('destetado','=',$destetado)
                  ->where('sexo','=',$sexo)
                  ->where('nro_monta','<=',$nroMonta)
                  ->where('prenada','=',$prenez)
                  ->where('parida','=',$parida)
                  ->where('tienecria','=',$tienecria)
                  ->where('criaviva','=',$criaviva)
                  ->where('ordenho','=',$ordenho)
                  ->where('detectacelo','=',$detectacelo)
                  ->where('id_finca','=',$id_finca)
                  ->get();

                  foreach ($tipologia as $key ) {
                      $tipologiaName = $key->nombre_tipologia;
                      $idtipo = $key->id_tipologia;
                      $prenada = $key->prenada;
                      $parida = $key->parida;
                      $tienecria = $key->tienecria;
                      $criaviva = $key->criaviva;
                      $ordenho = $key->ordenho;
                      $detectacelo = $key->detectacelo;
                  }	

                  $idTipologiaNueva = $idtipo;
                  $nuevaTipologiaName = $tipologiaName; 

                  $loteMonta = DB::table('sglotemontas')
                  ->where('id_ciclo','=',$id_ciclo)
                  ->get();

                  foreach ($loteMonta as $key ) {

                     $id_lotemonta = $key->id_lotemonta;

                     $monta = DB::table('sgmontas')
                     ->where('id_serie','=',$id_serie)
                     ->where('id_lotemonta','=', $id_lotemonta)
                     ->get();

                     if ($monta->count()>0) {
				        /*
			            * Actualizamos la tabla de monta con el nombre de tipologia nueva o saliente
			            */	
                     $tipoSaliente = DB::table('sgmontas')
                     ->where('id_serie','=',$id_serie)
                     ->where('id_lotemonta','=', $id_lotemonta)
                     ->update(['tipologia_salida'=>$nuevaTipologiaName]);		
                 }
             }	
		            /*
		            * Actualizamos a tabla mvmadres   
		            */
		        	#Buscamos el Numero de parto que tiene la serie
                   $nroParto = DB:: table('sgpartos')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();

		        	#Buscamos el Numero de abortos que tiene la serie
                   $nroAborto = DB:: table('sgabors')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();

		        	#Buscamos el Numero de abortos que tiene la serie
                   $nroServicios = DB:: table('sgservs')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();		

                   $npartos = $nroParto->count(); 
                   $nabortos = $nroAborto->count();
                   $nservicios = $nroServicios->count(); 
		        	/*
		        	* Actualizamos la tabla mvmadres
		        	*/
		        	$fecsistema = Carbon::now();
		        	/* 
		        	* Para Crear el registro primero se verifica que la serie no tenga
		        	* Un Registro en la tabla. 
		        	*/
		        	$buscaMvMadre = \App\Models\sgmvmadre::where('codmadre','=',$series->serie)
                    ->where('id_finca','=',$id_finca)
                    ->get();

                    foreach ($buscaMvMadre as $key ) {
                      $codmadre= $key->codmadre; 
                  }	

                  if ($buscaMvMadre->count()>0) {
			        		# Si existe, actualizamos los registros 
                     try{
					         		//$prenezNueva-> save();
                       $updateMvMadre = DB::table('sgmvmadres')
                       ->where('codmadre','=',$codmadre)
                       ->update(['fnac'=>$series->fnac,
                          'tipologia'=>$nuevaTipologiaName,
                          'id_tipologia'=>$idTipologiaNueva,
                          'npartos'=>$npartos,
                          'nabortos'=>$nabortos,
                          'nservicios'=>$nservicios,
                          'lote'=>$series->lote,
                          'observacion'=>$series->observa,
                          'faproxparto'=>$request->faproparto,
                          'IDA'=>$request->ida,
                          'fepre'=>$request->festipre,
                          'fecs'=>$fecsistema,
                          'fecup'=>$request->fecharegistro,
                          'vaquera'=>null,    
                          'id_finca'=>$id_finca]); 
                   }catch (\Illuminate\Database\QueryException $e){
                     return back()->with('mensaje', 'error');
                 }		
             } else {

                 $mvMadreNueva = new \App\Models\sgmvmadre;

                 $mvMadreNueva->codmadre = $series->serie;
                 $mvMadreNueva->fnac = $series->fnac;
                 $mvMadreNueva->tipologia = $nuevaTipologiaName;
                 $mvMadreNueva->id_tipologia = $idTipologiaNueva;
                 $mvMadreNueva->npartos = $request->nroparto;
                 $mvMadreNueva->nabortos = $request->nroaborto;
                 $mvMadreNueva->nservicios = $nservicios;
                 $mvMadreNueva->lote = $series->lote;
                 $mvMadreNueva->observacion = $series->observa;
                 $mvMadreNueva->faproxparto = $request->faproparto;
                 $mvMadreNueva->IDA = $request->ida;
                 $mvMadreNueva->fepre = $request->festipre;
                 $mvMadreNueva->fecs = $fecsistema;
                 $mvMadreNueva->fecup = $request->fecharegistro;
                 $mvMadreNueva->vaquera = null;
                 $mvMadreNueva->id_finca = $id_finca;

                 $mvMadreNueva->save();	
             }
		        	# FIN mvmadres

		        	# Actualizamos la tabla sgmv1

		        	$caso = "Preñez"; //hardcode
		        	$mv1Nueva = new \App\Models\sgmv1;

                  $mv1Nueva->codmadre = $series->serie;
                  $mv1Nueva->serie_hijo = null;
                  $mv1Nueva->caso = $caso;

                  $mv1Nueva->id_finca = $id_finca;						

                  $mv1Nueva->save();	

		        	# Fin de Tabla sgmv1

                  $ultimaPrenez = DB::table('sganims')
                  ->where('id','=',$request->idserie)
                  ->where('id_finca','=', $id_finca)
                  ->update(['fecupre'=>$request->fecharegistro,
                      'tipo'=>$nuevaTipologiaName,
                      'id_tipologia'=>$idTipologiaNueva,
                      'tipoanterior'=>$tipoAnterior,
                      'prenada'=>$prenada,
                      'parida'=>$parida,
                      'tienecria'=>$tienecria,
                      'criaviva'=>$criaviva,
                      'ordenho'=>$ordenho,
                      'detectacelo'=>$detectacelo]);                         

                  return back()->with('msj', 'Registro agregado satisfactoriamente');	
              }
          }else{


        		//return "La preñez no existe, se puede crear los registros";
        		/*
	            * Identifica si el registro proviene de una temporada
	            * 0 = Registro no es de temporada / 1 = Registro es de una temporada
	            */

                $estemporada= 1; 
				/*
				* ->| Se registran los nuevos Celos
				*/

             $prenezNueva = new \App\Models\sgprenhez;

             $prenezNueva->id_serie = $id_serie;
             $prenezNueva->serie = $request->serie;
             $prenezNueva->fecap = $request->faproparto;
             $prenezNueva->fecas = $request->faprosecado;
             $prenezNueva->fecser = $request->fecus;

             $prenezNueva->toropaj = $toropaj;
             $prenezNueva->nomi = $nomi;
             $prenezNueva->torotemp = $torotemp;

             $prenezNueva->fregp = $request->fecharegistro;
             $prenezNueva->intdiaabi = $request->ida;
             $prenezNueva->intestpar = $request->ier;
             $prenezNueva->pesopre = $request->pesoactual;
             $prenezNueva->dias_prenez = $request->diaprenez;
             $prenezNueva->mesespre = $request->mesesprenez;
             $prenezNueva->metodo = $metodo;
             $prenezNueva->fepre = $request->festipre;

             $prenezNueva->id_ciclo = $id_ciclo;
             $prenezNueva->id_finca = $id_finca;

             try{
                $prenezNueva-> save();
                $prenez = 1;  	
            }catch (\Illuminate\Database\QueryException $e){
               $prenez = 0; 
               return back()->with('mensaje', 'error');
           }
	            /*
				* ->| Se registran los nuevos Celos en el historial. 
				*/

				$historias = 0;

             $prenezHistorial = new \App\Models\sgprenhez_historico;

             $prenezHistorial->id_serie = $id_serie;
             $prenezHistorial->serie = $request->serie;
             $prenezHistorial->fecap = $request->faproparto;
             $prenezHistorial->fecas = $request->faprosecado;
             $prenezHistorial->fecser = $request->fecus;

             $prenezHistorial->toropaj = $toropaj;
             $prenezHistorial->nomi = $nomi;
             $prenezHistorial->torotemp = $torotemp;

             $prenezHistorial->fregp = $request->fecharegistro;
             $prenezHistorial->intdiaabi = $request->ida;
             $prenezHistorial->intestpar = $request->ier;
             $prenezHistorial->pesopre = $request->pesoactual;
             $prenezHistorial->dias_prenez = $request->diaprenez;
             $prenezHistorial->mesespre = $request->mesesprenez;
             $prenezHistorial->metodo = $metodo;
             $prenezHistorial->fepre = $request->festipre;

             $prenezHistorial->id_ciclo = $id_ciclo;
             $prenezHistorial->id_finca = $id_finca;


             $prenezHistorial-> save(); 

	            #Buscamos la tipologia actual 
             $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();

		          	#Obtenemos todos parametros de la tipologia

             foreach ($tipoActual as $key ) {
              $tipologiaName = $key->nombre_tipologia;
              $edad = $key->edad;
              $peso = $key->peso;
              $destetado = $key->destetado;
              $sexo = $key->sexo;
              $nro_monta = $key->nro_monta;
              $prenada = $key->prenada;
              $parida = $key->parida;
              $tienecria = $key->tienecria;
              $criaviva = $key->criaviva;
              $ordenho = $key->ordenho;
              $detectacelo = $key->detectacelo;
              $idtipo = $key->id_tipologia;
          }

		          	#Obteneos la tipologia anterior
          $tipoAnterior = $tipologiaName;

          $nroMonta = $series->nro_monta;

	            	# Actualizamos si se efectua la preñez.
          $tipologia= DB::table('sgtipologias')
          ->where('edad','=',$edad)
          ->where('peso','=',$peso)
          ->where('destetado','=',$destetado)
          ->where('sexo','=',$sexo)
          ->where('nro_monta','<=',$nroMonta)
          ->where('prenada','=',$prenez)
          ->where('parida','=',$parida)
          ->where('tienecria','=',$tienecria)
          ->where('criaviva','=',$criaviva)
          ->where('ordenho','=',$ordenho)
          ->where('detectacelo','=',$detectacelo)
          ->where('id_finca','=',$id_finca)
          ->get();

          foreach ($tipologia as $key ) {
              $tipologiaName = $key->nombre_tipologia;
              $idtipo = $key->id_tipologia;
          }	

          $idTipologiaNueva = $idtipo;
          $nuevaTipologiaName = $tipologiaName; 	
	            	# Actualizamos si se efectua la preñez.

          $loteMonta = DB::table('sglotemontas')
          ->where('id_ciclo','=',$id_ciclo)
          ->get();

          foreach ($loteMonta as $key ) {

              $id_lotemonta = $key->id_lotemonta;

              $monta = DB::table('sgmontas')
              ->where('id_serie','=',$id_serie)
              ->where('id_lotemonta','=', $id_lotemonta)
              ->get();

              if ($monta->count()>0) {
				        /*
			            * Actualizamos la tabla de monta con el nombre de tipologia nueva o saliente
			            */	
                     $tipoSaliente = DB::table('sgmontas')
                     ->where('id_serie','=',$id_serie)
                     ->where('id_lotemonta','=', $id_lotemonta)
                     ->update(['tipologia_salida'=>$nuevaTipologiaName]);		
                 }
             }	
	          	/*
		        * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
		        */
              $countprenez =  DB::table('sgprenhez_historicos')
              ->where('fregp','=',$request->fecharegistro)
              ->where('id_finca','=', $id_finca)
              ->where('id_ciclo','=', $id_ciclo)
              ->count(); 

              $nroprenez = DB::table('sghistoricotemprepros')
              ->where('fecharegistro','=',$request->fecharegistro)
              ->where('id_finca','=', $id_finca)
              ->where('id_ciclo','=', $id_ciclo)
              ->update(['nropre'=>$countprenez]);   
	                /*
		            * Actualizamos a tabla mvmadres   
		            */

		        	#Buscamos el Numero de parto que tiene la serie
                   $nroParto = DB:: table('sgpartos')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();

		        	#Buscamos el Numero de abortos que tiene la serie
                   $nroAborto = DB:: table('sgabors')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();

		        	#Buscamos el Numero de abortos que tiene la serie
                   $nroServicios = DB:: table('sgservs')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->get();		

                   $npartos = $nroParto->count(); 
                   $nabortos = $nroAborto->count();
                   $nservicios = $nroServicios->count(); 

		        	/*
		        	* Actualizamos la tabla mvmadres
		        	*/
		        	$fecsistema = Carbon::now();
		        	/* 
		        	* Para Crear el registro primero se verifica que la serie no tenga
		        	* Un Registro en la tabla. 
		        	*/
		        	$buscaMvMadre = \App\Models\sgmvmadre::where('codmadre','=',$series->serie)
                    ->where('id_finca','=',$id_finca)
                    ->get();

                    foreach ($buscaMvMadre as $key ) {
                      $codmadre= $key->codmadre; 
                  }	

                  if ($buscaMvMadre->count()>0) {
			        		# Si existe, actualizamos los registros 
                     try{
					         		//$prenezNueva-> save();
                       $updateMvMadre = DB::table('sgmvmadres')
                       ->where('codmadre','=',$codmadre)
                       ->update(['fnac'=>$series->fnac,
                          'tipologia'=>$nuevaTipologiaName,
                          'id_tipologia'=>$idTipologiaNueva,
                          'npartos'=>$npartos,
                          'nabortos'=>$nabortos,
                          'nservicios'=>$nservicios,
                          'lote'=>$series->lote,
                          'observacion'=>$series->observa,
                          'faproxparto'=>$request->faproparto,
                          'IDA'=>$request->ida,
                          'fepre'=>$request->festipre,
                          'fecs'=>$fecsistema,
                          'fecup'=>$request->fecharegistro,
                          'vaquera'=>null,    
                          'id_finca'=>$id_finca]); 
                   }catch (\Illuminate\Database\QueryException $e){
                     return back()->with('mensaje', 'error');
                 }		
             } else {

                 $mvMadreNueva = new \App\Models\sgmvmadre;

                 $mvMadreNueva->codmadre = $series->serie;
                 $mvMadreNueva->fnac = $series->fnac;
                 $mvMadreNueva->tipologia = $nuevaTipologiaName;
                 $mvMadreNueva->id_tipologia = $idTipologiaNueva;
                 $mvMadreNueva->npartos = $npartos;
                 $mvMadreNueva->nabortos = $nabortos;
                 $mvMadreNueva->nservicios = $nservicios;
                 $mvMadreNueva->lote = $series->lote;
                 $mvMadreNueva->observacion = $series->observa;
                 $mvMadreNueva->faproxparto = $request->faproparto;
                 $mvMadreNueva->IDA = $request->ida;
                 $mvMadreNueva->fepre = $request->festipre;
                 $mvMadreNueva->fecs = $fecsistema;
                 $mvMadreNueva->fecup = $request->fecharegistro;
                 $mvMadreNueva->vaquera = null;
                 $mvMadreNueva->id_finca = $id_finca;

                 $mvMadreNueva->save();	
             }
		        	# FIN mvmadres

		        	# Actualizamos la tabla sgmv1

		        	$caso = "Preñez"; //hardcode
		        	$mv1Nueva = new \App\Models\sgmv1;

                  $mv1Nueva->codmadre = $series->serie;
                  $mv1Nueva->serie_hijo = null;
                  $mv1Nueva->caso = $caso;

                  $mv1Nueva->id_finca = $id_finca;

                  $mv1Nueva->save();	

		        	# Fin de Tabla sgmv1
	            /*
	            * Actualiza el campo fecha del último Preñez y la tipologia . 
	            */

	            $ultimaPrenez = DB::table('sganims')
             ->where('id','=',$request->idserie)
             ->where('id_finca','=', $id_finca)
             ->update(['fecupre'=>$request->fecharegistro,
              'tipo'=>$nuevaTipologiaName,
              'id_tipologia'=>$idTipologiaNueva,
              'tipoanterior'=>$tipoAnterior]); 
             return back()->with('msj', 'Registro agregado satisfactoriamente');
         }	

     }

     public function editar_prenez($id_finca, $id, $id_ciclo, $id_serie, $id_prenez)
     {

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

        $usuario = \App\Models\User::all();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

        $series = \App\Models\sganim::findOrFail($id_serie);

        $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
		    //*************************************************

        $raza = \App\Models\sgraza::findOrFail($series->idraza);

        $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)
        ->paginate(5);

        $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->get();

        $prenhez = \App\Models\sgprenhez::findOrFail($id_prenez);

        $metodo = DB::table('sgtipomontas')
        ->where('nombre','=',$prenhez->metodo)
        ->where('id_finca','=',$id_finca)
        ->get();

        foreach ($metodo as $key) {
            $idtipomonta = $key->id;
        }

            /*
            *-> Se crea un identificador para saber si la serie se le ha practicado
            * un servicio en menos de 90 días.
            */	

            $servicioReciente = DB::table('sgservs')  
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($servicioReciente as $key) {
             $ultservicio = $key->ultservicio;
         }		
			/*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
         $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();

         foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
             $tgesta = $key->tiempogestacion; 
         }

            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pP = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pP as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tsecado = $key->diassecado; 
            }
            /*
			* Se calcula el tiempo del ciclo de monta $tm = Tiempo de monta
			*/	
            $tm = Carbon::parse($ciclo->fechainicialciclo)->diffInDays($ciclo->fechafinalciclo);	
            
            /*
            * Con el Valor de la feha del ultimo servicio se calcula la diferencia en días 
            * con Carbon y ver si es menor al tiempo de monga.. 
            */
            $diasServicio = Carbon::parse($ultservicio)->diffInDays(Carbon::now());

            if (!($ultservicio==null) and $diasServicio<$tm) {
                $servicioActivo = 1;
            } else { 
                $servicioActivo = 0;
            }

            return view('reproduccion.editar_prenez', compact('ciclo','finca', 'temp_reprod','tipomonta','edad','celos','series','usuario', 'raza','condicorpo','prenhez','diasServicio','tgesta','tsecado','servicioActivo','idtipomonta'));
        }

        public function update_prenez(Request $request, $id, $id_finca, $id_ciclo, $id_serie, $id_prenez)
        {

        	$ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

        	$tipomonta = \App\Models\sgtipomonta::findOrFail($request->metodo_prenez);

        	$series = \App\Models\sganim::findOrFail($id_serie);

        	/*
        	* Aquí consultamos el último servicio realizado para la serie
        	* Consultada.
        	*/
        	$ultimoservicio = DB::table('sgservs')
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

				/*
				*->| Comprueba el ultimo servicio 
				*/
				foreach ($ultimoservicio as $key) {
                  $fechaultimoservicio = $key->ultservicio;
              }	
				/*
				* Aquí hacemos la consulta eloquent donde obtendremos el JSON de la tabla basado en el criterio de consulta anterior
				*/	
				$servicio = DB::table('sgservs')
             ->where('serie', '=', $series->serie)
             ->where('fecha', '=', $fechaultimoservicio)
             ->where('id_finca','=',$id_finca)
             ->get();

				/*
				*-|> Fin de Consulta de Servicio
				*/	
        	 /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
             $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $id_finca)->get();

             foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
               $tgesta = $key->tiempogestacion; 
           }

           if ($request->metodo_prenez == 1) {
                # Viene del método inseminación artificial/ Monta Controlada 
            $request->validate([
                'diaprenez'=> [
                    'required',
                 //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                ],
                'fecharegistro'=> [
                    'required',
                ],
            ]);
                /*
                * Se hardcod el métodop porque se presume que no cambian con 
                * el tiempo
                */
                $metodo = $tipomonta->nombre;
                /*
                * se recorre el JSON para Obtener los valores obtenidos.
                */  
                foreach ($servicio as $item) {
                    $toropaj = $item->paju;
                    $torotemp = $item->toro;
                    $nomi = $item->nomi; 
                }   

            } else {
                # Viene del méodo Monta Libre
                $request->validate([
                    'mesesprenez'=> [
                        'required',
                 //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                    ],
                    'fecharegistro'=> [
                        'required',
                    ],
                ]);
                /*Se hardcod el métodop porque se presume que no cambian con 
                * el tiempo
                */
                $metodo = $tipomonta->nombre;
                /*
                * se recorre el JSON para Obtener los valores obtenidos.
                */  
                $toropaj = null;
                $torotemp = null;
                $nomi = null; 
            }

         		   /*
		            * Identifica si el registro proviene de una temporada
		            * 0 = Registro no es de temporada / 1 = Registro es de una temporada
		            */
                 $estemporada= 1; 
					/*
					* ->| Se registran los nuevos Celos
					*/
                  $prenezUpdate = \App\Models\sgprenhez::findOrFail($id_prenez);


		        	# Aquí almacenamos la fecha de Registro de Preñez
                  $fechaRegistroPrenez = $prenezUpdate->fregp;


                  $prenezUpdate->fecap = $request->faproparto;
                  $prenezUpdate->fecas = $request->faprosecado;
                  $prenezUpdate->fecser = $request->fecus;

                  $prenezUpdate->toropaj = $toropaj;
                  $prenezUpdate->nomi = $nomi;
                  $prenezUpdate->torotemp = $torotemp;

                  $prenezUpdate->fregp = $request->fecharegistro;
                  $prenezUpdate->intdiaabi = $request->ida;
                  $prenezUpdate->intestpar = $request->ier;
                  $prenezUpdate->pesopre = $request->pesoactual;
                  $prenezUpdate->dias_prenez = $request->diaprenez;
                  $prenezUpdate->mesespre = $request->mesesprenez;
                  $prenezUpdate->metodo = $metodo;
                  $prenezUpdate->fepre = $request->festipre;

                  $prenezUpdate->id_ciclo = $id_ciclo;
                  $prenezUpdate->id_finca = $id_finca;

                  $prenezUpdate-> save(); 
		            /*
					* ->| Se registran los nuevos Celos en el historial. 
					*/
					$historias = 0;



                  $updateHistoriaPrenez = DB::table('sgprenhez_historicos')
                  ->where('id_serie','=', $id_serie)
                  ->where('fregp','=',$fechaRegistroPrenez)
                  ->update(['fecap'=>$request->faproparto,
                   'fecas'=>$request->faprosecado,
                   'fecser'=>$request->fecus,
                   'toropaj'=>$request->toropaj,
                   'nomi'=>$nomi,
                   'torotemp'=>$torotemp,
                   'fregp'=>$request->fecharegistro,
                   'intdiaabi'=>$request->ida,
                   'intestpar'=>$request->ier,
                   'pesopre'=>$request->pesoactual,
                   'mesespre'=>$request->mesesprenez,
                   'dias_prenez'=>$request->diaprenez,
                   'metodo'=>$metodo,    
                   'fepre'=>$request->festipre]); 
		            /*
			        * Se cuentan la cantidad de servicios por la fecha de registro.
			        */
                   $countprenez =  DB::table('sgprenhez_historicos')
                   ->where('fregp','=',$fechaRegistroPrenez)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->count(); 

                   $nroprenezantes = DB::table('sghistoricotemprepros')
                   ->where('fecharegistro','=',$fecha)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->update(['nropre'=>$countprenez]);          

                   $countprenezahora =  DB::table('sgprenhez_historicos')
                   ->where('fregp','=',$request->fecharegistro)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->count();                     

                   $nroprenez = DB::table('sghistoricotemprepros')
                   ->where('fecharegistro','=',$request->fecharegistro)
                   ->where('id_finca','=', $id_finca)
                   ->where('id_ciclo','=', $id_ciclo)
                   ->update(['nropre'=>$countprenezahora]);
		            /*
		            * Actualiza el campo fecha del última preñez. 
		            */
		            $ultimaPrenez = DB::table('sganims')
                  ->where('id','=',$request->idserie)
                  ->where('id_finca','=', $id_finca)
                  ->update(['fecupre'=>$request->fecharegistro]); 

                  return back()->with('msj', 'Registro agregado satisfactoriamente');     
              }

              public function eliminar_prenez($id_finca, $id, $id_ciclo, $id_serie, $id_prenez)
              {

               $series = \App\Models\sganim::findOrFail($id_serie);

               $prenezEliminar = \App\Models\sgprenhez::findOrFail($id_prenez);

               $fechaRegistroPrenez = $prenezEliminar->fregp;

               try {
                $prenezEliminar->delete();
            //$prenezHistoricoEliminar->delete();
                $prenezHistoricoEliminar = DB::table('sgprenhez_historicos')
                ->where('id_serie','=',$id_serie)
                ->where('fregp','=',$prenezEliminar->fregp)
                ->delete();
             /*
	        * Se cuentan la cantidad de celos por la fecha de registro.
	        */
             $countprenez =  DB::table('sgprenhez_historicos')
             ->where('fregp','=',$fechaRegistroPrenez)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->count(); 

             $nroprenez = DB::table('sghistoricotemprepros')
             ->where('fecharegistro','=',$fechaRegistroPrenez)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->update(['nropre'=>$countprenez]); 			

            /*
            * Recalcular el numero de preñez y actualizar en la tabla sganim
            */

            $ultimafechaprenez = DB::table('sgprenhez_historicos')
            ->select(DB::raw('MAX(fepre) as ultprenez'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
			/*
			*->| Comprueba el ultimo celo y actualiza el campo Fecha ultimo celo en la tabla sganims.  
			*/	
			foreach ($ultimafechaprenez as $key) {
             $ultprenez = $key->ultprenez;
         }	
            /*
            * Uicamos la serie en la tabla monta segun el ciclo para 
            * Actualizar su Tipologia  
            */	

            $loteMonta = DB::table('sglotemontas')
            ->where('id_ciclo','=',$id_ciclo)
            ->get();

            foreach ($loteMonta as $key ) {

                $id_lotemonta = $key->id_lotemonta;

                $monta = DB::table('sgmontas')
                ->where('id_serie','=',$id_serie)
                ->where('id_lotemonta','=', $id_lotemonta)
                ->get();

                foreach ($monta as $key) {
                    $idtipoentrante = $key->idtipoentrante;
                    $tipologia_salida = $key->tipologia_salida;
                }        

                $tipologia = \App\Models\sgtipologia::findOrFail($idtipoentrante);


                if ($monta->count()>0) {
			        /*
		            * Actualizamos la tabla de monta con el nombre de tipologia nueva o saliente a null ya que la tipologia saliente depende de la preñez.
		            */	
                    $tipoSaliente = DB::table('sgmontas')
                    ->where('id_serie','=',$id_serie)
                    ->where('id_lotemonta','=', $id_lotemonta)
                    ->update(['tipologia_salida'=>null]);		
                }
            }
	       	/*
       		* Actualizamos la tabla sganims y los parametros tipologicos.
       		*/
       		$ultimovezprenada = DB::table('sganims')
            ->where('id','=',$id_serie)
            ->where('id_finca','=', $id_finca)
            ->update(['fecupre'=>$ultprenez,
             'id_tipologia'=>$idtipoentrante,
             'tipo'=>$tipologia->nombre_tipologia,
             'tipoanterior'=>null,
             'prenada'=>$tipologia->prenada,
             'parida'=>$tipologia->parida,
             'tienecria'=>$tipologia->tienecria,
             'criaviva'=>$tipologia->criaviva,
             'ordenho'=>$tipologia->ordenho,
             'detectacelo'=>$tipologia->detectacelo]);


            return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }

    }
    /*Fin - Preñez*/    

/*
*--> Controladores de Parto
*/
public function parto(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
{

            //Se busca la finca por su id - Segun modelo
    $finca = \App\Models\sgfinca::findOrFail($id_finca);

    $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

    $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);
    
    $usuario = \App\Models\User::all();

    $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
    ->get();

    $series = \App\Models\sganim::findOrFail($id_serie);

    $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

    $condiCorpoCria = \App\Models\sgcondicioncorporal::all();

    $loteEstrategico = \App\Models\sglote::where('id_finca', '=', $id_finca)
    ->where('tipo', '=', "Estrategico")->get();

    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
    $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
    $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
    $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
    $edad = $year."-".$months;
		    //*************************************************

    $causamuerte = \App\Models\sgcausamuerte::all(); 

    $raza = \App\Models\sgraza::findOrFail($series->idraza);

    $razacria = \App\Models\sgraza::all(); 

    $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
    ->where('id_ciclo','=',$id_ciclo)
    ->where('id_finca','=',$id_finca)
    ->paginate(5);

    $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
    ->where('id_ciclo','=',$id_ciclo)
    ->where('id_finca','=',$id_finca)->paginate(7);

    $colorpelaje = \App\Models\colorescampo::where('id_finca', '=', $finca->id_finca)
    ->get();	
            /*
            * Aquí se obtiene los datos de la última preñez.
            */	
            $ultimaprenez = DB::table('sgprenhezs')  
            ->select(DB::raw('MAX(fregp) as ultprenez'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($ultimaprenez as $t ) {
             $ultprenez = $t->ultprenez;
         }

         $prenhez = \App\Models\sgprenhez::where('fregp','=',$ultprenez)
         ->where('serie', '=', $series->serie)
         ->where('id_finca','=',$id_finca)
         ->get();

         foreach ($prenhez as $key) {
           $festipre = $key->fepre;
       }	

			/*
            *-> Se crea un identificador para saber si la serie se le ha practicado
            * un servicio en menos de 90 días.
            */	
            $servicioReciente = DB::table('sgservs')  
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($servicioReciente as $key) {
             $ultservicio = $key->ultservicio;
         }		


			/*
			* Se calcula el tiempo del ciclo de monta $tm = Tiempo de monta
			*/	
            $tm = Carbon::parse($ciclo->fechainicialciclo)->diffInDays($ciclo->fechafinalciclo);
            /*
            * Con el Valor de la feha del ultimo servicio se calcula la diferencia en días 
            * con Carbon y ver si está dentro del tipo del ciclo monta 
            */
            $diasServicio = Carbon::parse($ultservicio)->diffInDays(Carbon::now());

            if (!($ultservicio==null) and $diasServicio<$tm) {
             $servicioActivo = 1;
         } else {
             $servicioActivo = 0;
         }
            /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tgesta = $key->tiempogestacion; 
            }

            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pP = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pP as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tsecado = $key->diassecado; 
            }	

			/*
			*Aquí se comprueba que exista un registro de preñez para poder
			*registrar parto.	
			*/
			if (empty($ultprenez) or ($ultprenez==null)) {
				
				return back()->with('info', 'ok');
				
			} else {
				/*
		        * Se calcula el tiempo de preñez, ya que existe, es decir, verificar que la preñez no sea  antigua para que se registre una preñez nueva
		        */
              $tp = Carbon::parse($festipre)->diffInDays(Carbon::now());  	
					//hardcode un año			
              if ($tp>365) {
                 return back()->with('info', 'oka');
             } else {
                    # $tgesta se cambia por 180 hardcode, ya que es el final el 2do Trimestre
                 if ($tp<=180) {
						# Se comprueba que no esté en el 3er Trimestre.
                    return back()->with('info', 'int');
                }else{
					#Si está en el 3er Trimestre que registre el parto   
                 $prenhez = \App\Models\sgprenhez::where('fregp','=',$ultprenez)
                 ->where('serie', '=', $series->serie)
                 ->where('id_finca','=',$id_finca)
                 ->get();

                 foreach ($prenhez as $key) {
                   $ieep = $key->intestpar;
                   $ida = $key->intdiaabi;
                   $faprosecado = $key->fecas; 
                   $faproparto = $key->fecap;
               }
	            	/*
	            	* Esto nos dará los días y los meses de preñez que lleva la serie.
	            	*/
	            	$diasprenez = Carbon::parse($festipre)->diffInDays(Carbon::now()); 
                  $mesesprenez = Carbon::parse($festipre)->diffInMonths(Carbon::now());

                  if ($mesesprenez<9) {
                     $mesesprenez=$mesesprenez;
                 } else {
                     $mesesprenez =9;
                 }

		            //$key->mesespre;
                 return view('reproduccion.formulario_parto', 
                     compact('ciclo','finca', 'temp_reprod',
                       'tipomonta','edad','celos','series','usuario', 
                       'raza','condicorpo','prenhez','diasServicio',
                       'tgesta','tsecado','servicioActivo', 'ieep','ida','festipre','faprosecado','faprosecado','faproparto','diasprenez','mesesprenez','razacria','condiCorpoCria','loteEstrategico','parto','causamuerte','colorpelaje'));
             }
         }
     }
 }

public function crear_parto(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
{

    $finca = \App\Models\sgfinca::findOrFail($id_finca);

    $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

    $tipomonta = \App\Models\sgtipomonta::findOrFail($ciclo->id_tipomonta);

    $series = \App\Models\sganim::findOrFail($id_serie);

    $raza = \App\Models\sgraza::findOrFail($series->idraza);

    $condicion = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

	/*
	* 1-> Validamos que el parto no sea morocho y este en condicion vivo
	*/
	if (!($request->tipoparto=="on") and ($request->condicionnac1==1)) {
		# Validamos los campos que utilizaremos 	
        $request->validate([
            'seriecria1'=> [
                'required',
             //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
            'razacria1'=> [
                'required',
            ],
            'pesoicria1'=> [
                'required',
            ],
            'lotecria1'=> [
                'required',
            ],
            'condicorpocria1'=> [
                'required',
            ],
            'fnac'=> [
                'required',
            ],
        ]);
    	# Aquí colocamos la Marca Vi para clasificar que ha nacido vivo y Mu que
    	# ha nacido muerto
    	$marca = "Vi"; 	 // hardcod
    	/*
    	* es importante buscar la tipología actual que es la misma que tiene
    	*antes del parto
    	*/
    	$tipoActual = $series->tipo;
    	/*
    	* 2-> Guardamos en la tabla de partos los registros del form. 
    	*/	 
    	$caso = "Parto"; //hardcod
    	/*
    	* Agregamos el parto y luego ubicamos la tipologia 
    	*/
        $partoNuevo = new \App\Models\sgparto;

        $partoNuevo->id_serie = $id_serie;
        $partoNuevo->serie = $request->serie;
        $partoNuevo->tipo = null;
        $partoNuevo->estado = $request->condicorpo;
        $partoNuevo->edad = $request->edad;
        $partoNuevo->tipoap = $tipoActual = $series->tipo;
        $partoNuevo->fecup = $request->fecup;

        # Comienza los datos de la Cría 1 #
        $partoNuevo->fecpar = $request->fnac;
        $partoNuevo->sexo = $request->sexocria1;
        $partoNuevo->becer = $request->seriecria1;
        $partoNuevo->lotebecerro = $request->lotecria1;
        $partoNuevo->obspar = $request->observa;
        $partoNuevo->edobece = $request->condicorpocria1;
        $partoNuevo->razabe = $request->razacria1;
        $partoNuevo->pesoib = $request->pesoicria1;
        $partoNuevo->ientpar = $request->ier;
        $partoNuevo->marcabec1 = $marca;
        $partoNuevo->color_pelaje = $request->colorpelaje;

        $partoNuevo->id_ciclo = $id_ciclo;
        $partoNuevo->id_finca = $id_finca;

        try{

            $partoNuevo-> save();
            #Se Cambian los parametros tipologicos para cambio e tipologia
            $pario = 1;  
            $tienesucria = 1; 
            $crianacioviva = 1; 
            $prenez = 0;  	
        
        }catch (\Illuminate\Database\QueryException $e){
            #Se devuelven los cambios en caso de haber un error.
            $pario = 1;  
            $tienesucria = 1;
            $crianacioviva = 1; 
            $prenez = 1;
         
            return back()->with('mensaje', 'error');
        }
        /*
        * Se cuentan la cantidad de partos que se registran a la fecha por la fecha de registro.
        */
    	$countparto =  DB::table('sgpartos')
                    ->where('fecpar','=',$request->fnac)
                    ->where('id_finca','=', $id_finca)
                    ->where('id_ciclo','=', $id_ciclo)
                    ->count(); 

        $nroparto = DB::table('sghistoricotemprepros')
                  ->where('fecharegistro','=',$request->fnac)
                  ->where('id_finca','=', $id_finca)
                  ->where('id_ciclo','=', $id_ciclo)
                  ->update(['nropart'=>$countparto]);  
    	/*
      	* Aqui actualizamos la Tipologia en caso de una preñez
      	* ya que es un proceso que conlleva a eso.
      	*/
    	#Buscamos la tipologia actual 
      	$tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
              	
        #Obtenemos todos parametros de la tipologia
              	
        foreach ($tipoActual as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $edad = $key->edad;
            $peso = $key->peso;
            $destetado = $key->destetado;
            $sexo = $key->sexo;
            $nro_monta = $key->nro_monta;
            $prenada = $key->prenada;
            $parida = $key->parida;
            $tienecria = $key->tienecria;
            $criaviva = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
            $idtipo = $key->id_tipologia;
        }
        #Actualizamos la tipologia
        #Obtenemos la tipologia anterior
        $tipoAnterior = $tipologiaName;
        $nroMonta = $series->nro_monta;

    	# Actualizamos si se efectua el parto.
        $tipologia= DB::table('sgtipologias')
                ->where('edad','=',$edad)
                ->where('peso','=',$peso)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$sexo)
       			->where('nro_monta','=',$nroMonta) //Revisar aqui
       			->where('prenada','=',$prenez)
       			->where('parida','=',$pario)
       			->where('tienecria','=',$tienesucria)
       			->where('criaviva','=',$crianacioviva)
       			->where('ordenho','=',$ordenho)
       			->where('detectacelo','=',$detectacelo)
       			->where('id_finca','=',$id_finca)
       			->get();

        foreach ($tipologia as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $idtipo = $key->id_tipologia;
            $prenada =$key->prenada;
            $tcria = $key->tienecria;
            $criav = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
        }	

        $idTipologiaNueva = $idtipo;
        $nuevaTipologiaName = $tipologiaName;
        $prenhada = $prenada;
        $tienecria = $tcria;
        $criaViva = $criav;
        $ordeNho = $ordenho;
        $detectaCelo = $detectacelo;
   		/*
   		* Actualizamos el campo tipo con la tipologia final
   		*/
   		$tipologiaParto= DB::table('sgpartos')
                   ->where('id_finca','=',$id_finca)
                   ->where('id_ciclo','=',$id_ciclo)
                   ->where('id_serie','=',$id_serie)            
                   ->update(['tipo'=>$nuevaTipologiaName]);  		
   		/*
   		* Buscamos la fecha del perimer servicio
   		*/			
   		$servicio = DB::table('sgservs')
                  ->select(DB::raw('MIN(fecha) as fpserv'))
                  ->where('id_serie','=',$id_serie)
                  ->where('id_finca','=',$id_finca)
                  ->get();
		/*
		* Si tenemos registros buscamos la fecha del primer servicio
		*/	
		if ($servicio->count()>0) {
			#Si existe el servicio buscamo la fecha del primer servicio.
			foreach ($servicio as $key) {
               $fechaPrimerServicio = $key->fpserv; 	
            }
        } else {
            $fechaPrimerServicio = null; 
        }
    	
        # Con la fecha del primer servicio buscamo la tipologia primer servicio
        $tipoPrimerServicio = DB::table('sgservs')
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=',$fechaPrimerServicio)
                ->where('id_finca','=',$id_finca)
                ->get();

        if ($tipoPrimerServicio->count()>0) {
    	    #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
            foreach ($tipoPrimerServicio as $key) {
               $id_tipologia = $key->id_tipologia;
               $pesops = $key->peso;  	
            }
           	# Con id ubicamos la Tipoloiga en la tabla
            $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
    	    #Obtenemos el Nombre de la Tipologia	
            $tipops= $tipologia->nombre_tipologia;
    	    #Obtenemos el peso que tiene la serie en el primer servicio
            $pesops = $pesops; 
        } else {
       		$tipops= null; //No existe
       		$pesops = null; //no existe
        } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio

        # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
        $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
             ->select(DB::raw('MIN(fecser) as fespr'))
             ->where('id_finca', '=',$id_finca)
             ->where('id_serie','=',$id_serie)
             ->where('toropaj','<>',null)
             ->orWhere('torotemp','<>',null)
             ->get();  

        # Comprobamos si existe el servicio que generó la preñez	
        if ( $servicioPrimerPrenez->count()>0) {
           	#Si existe, obtenemos fecha de primer servicio 
            foreach ($servicioPrimerPrenez as $key) {
               $fechasPr = $key->fespr; 
           }

        } else {
          $fechasPr = null; 
        }      		
		/*
   		Con la fechasPr creamos una consulta para verificar 
   		si se trata de una preñez por toropajuela o torotempt 
   		*/
   		$prenezHistorico = DB::table('sgprenhez_historicos')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecser','=',$fechasPr)
                  ->get();  
        # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp. 	
        if ($prenezHistorico->count()>0) {
                foreach ($prenezHistorico as $key) {
                   $toropaj = $key->toropaj;
                   $nomi = $key->nomi;
                   $torotemp = $key->torotemp; 
                }
        } else {
           $toropaj = null;
           $nomi = null;
           $torotemp = null;
        }
    	#Con los valores anteriores identificamos la pajuela
        $pajuela = DB::table('sgpajus')
              ->where('id_finca','=',$id_finca)
              ->where('serie','=',$toropaj)
              ->get();
    	       	# Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre 
        if ($pajuela->count()>0) {
       	    #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
            $espajuela = 1; 
            foreach ($pajuela as $key) {
               $idpaju = $key->id;
               $razapaju = $key->nombreraza;
               $fechanac = $key->fnac;
               $nombrepa = $key->nomb; 
            }

           $nombrepadre = $nombrepa;
           $razapadre = $razapaju;
           $tipopadre = null;
           $fechanacpadre = $fechanac;

        } else {
       		#Si no existe la pajuela, sus valores pasan a null.
            $idpaju = null;
            $razapaju = null;
            $fechanac = null;
            $nombrepa = null;

            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
	       	#Como la pajuela no existe entonces marcamos a falso 
            $espajuela = 0; 
            }
    	    # Ubicamos si es Toro en caso de existir la Preñez Historico				
            $toro = DB::table('sganims')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$torotemp)
                ->get();
    	       	# Verificamos que el $torotemp exista
            if ($toro->count()>0) {
    	        #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
                $espajuela = 0; 
                
                foreach ($toro as $key) {
                    $razatoro = $key->idraza;
                    $idtipo = $key->id_tipologia;
                    $fecnacPadre = $key->fnac;
                  }
              
                $raza = \App\Models\sgraza::findOrFail($razatoro);
                $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);

                $razapadre = $raza->nombreraza;
                $tipopadre = $tipotoro->nombre_tipologia;
                $fechanacpadre = $fecnacPadre;
    	       	$nombrepadre = null; //el nombre del padre no existe en la tabla sganims
    	    } else {
    	       	 #Si no existe el Toro, entonces se asume que fue una monta natural	
                $razapadre = null;
                $tipopadre = null;
                $fechanacpadre = null;
                $nombrepadre = null;
            }
    	        #Actualizamos las variables si proviene de Pajuela o Toro.
        $fechasPr = $fechasPr; 
        $codtpajuela = $toropaj;
        $nomi = $nomi;
        $torotemporada = $torotemp;

        $razapadre = $razapadre;
        $tipopadre = $tipopadre;
        $fechanacpadre = $fechanacpadre;
        $nombrepadre = $nombrepadre;
        $espajuela = $espajuela; 
   		/*
   		* Ubicamos el primer servicio
   		*/
   		$primerServicio = DB::table('sgservs')
          ->select(DB::raw('MIN(fecha) as fpservicio'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get();
   		/*
   		* Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
   		*/
   		if ( $primerServicio->count()>0 ) {
   			foreach ($primerServicio as $key) {
   				$fecha = $key->fpservicio;
   			}
   		} else {
   			# No tiene servicio creado
   			$fecha=null; //no existe;
   		}
   		# Ubicamosla Edad primer servicio
        $edadPrimerServicio = DB::table('sgservs')
              ->where('id_finca', '=',$id_finca)
              ->where('id_serie','=',$id_serie)
              ->where('fecha','=', $fecha)
              ->get();		

        if ($edadPrimerServicio->count()>0) {
                foreach ($edadPrimerServicio as $key ) {
                    $edadPservicio = $key->edad;
                }
            } else {
    	       	$edadPservicio = null; //es decir no existe 
        }
   		/*
   		* Ubicamos la fecha del Primer parto
   		*/	
        $fechaPrimerParto = DB::table('sgpartos')
                ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 

        if ($fechaPrimerParto->count()>0) {
        
            foreach ($fechaPrimerParto as $key) {
               $fpParto = $key->fprimerParto; 
            }       		
        
        } else {
           		$fpParto=null; // no existe
        }       			 	 
   		/*
   		* La edad del primer Parto
   		*/
        $edadPrimerParto = DB::table('sgpartos')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecpar','=',$fpParto)
                  ->get();

        if ($edadPrimerParto->count()>0) {
            
            foreach ($edadPrimerParto as $key ) {
                   $edadPp = $key->edad; 
            }

        } else {
            $edadPp=null; 
        }
   		/*
   		* Ubicamos El numero de celos por la temporada de monta
   		*/
   		$celos = DB::table('sgcelos')
          ->where('id_finca','=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->get();

          $nroCelos = $celos->count(); 	
   		/*
   		* Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
   		*/
   		$fechaPrimerCelo = DB::table('sgcelos')
          ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->get(); 
           		//if ( ($fechaPrimerCelo==null) or empty($fechaPrimerCelo) ) {
        if ( $fechaPrimerCelo->count()>0) {

            foreach ($fechaPrimerCelo as $key) {
                $fPrimerCelo = $key->fecPrimerCelo;
            }

           $fpCelo = $fPrimerCelo;

       		//*************************************************
		        //Se calcula con la herramienta carbon la edad
           $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
           $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
           $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
           $edadpc = $year."-".$months;
    		    	//*************************************************	           			
        } else {
            $fpCelo = null; 
           	$edadpc = null; // no exsite;
        }
        $fechaUltimoCelo = DB::table('sgcelos')
                  ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_ciclo','=',$id_ciclo)
                  ->where('id_serie','=',$id_serie)
                  ->get(); 
   		/*
   		* Comprobamos si el ultimo celo existe que lo entrege sino que sea null
   		*/
        if ( $fechaUltimoCelo->count()>0 ) {

           	foreach ($fechaUltimoCelo as $key) {
           		$fuCelo = $key->fecUltimoCelo;
           	}

           	$fuc = $fuCelo;
        
        } else {
           	$fuc = null;
        }	
   		/*
   		* Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
   		*/
   		$ultimoCelo = DB::table('sgcelos')
              ->where('id_finca', '=',$id_finca)
              ->where('id_ciclo','=',$id_ciclo)
              ->where('id_serie','=',$id_serie)
              ->where('fechr','=',$fuc)
              ->get(); 

        if ( ($ultimoCelo->count()>0) ) {
            foreach ($ultimoCelo as $key ) {
                       $ientcel = $key->dias; 
           }	
           $ientcelos = $ientcel;

        } else {
            $ientcelos= null; 
        }	
   		/*
   		* Ubicamos el ultimo servicio
   		*/
   		$ultServicio = DB::table('sgservs')
              ->select(DB::raw('MAX(fecha) as fultservicio'))
              ->where('id_finca', '=',$id_finca)
              ->where('id_serie','=',$id_serie)
              ->get();
        if ($ultServicio->count()>0) {
                      
            foreach ($ultServicio as $key) {
                       $fUltserv = $key->fultservicio;
            }
               
        } else {
   			# No tiene servicio creado
   			$fUltserv = null; //es decir no existe 
        }
   		# Ubicamosla iserv del ultimo servicio
   		$intServicio = DB::table('sgservs')
              ->where('id_finca', '=',$id_finca)
              ->where('id_serie','=',$id_serie)
              ->where('fecha','=', $fUltserv)
              ->get();		
        
        if ($intServicio->count()>0 ) {
        
            foreach ($intServicio as $key ) {
                $intEntreServ = $key->iers; 
            }	
        
        } else {
       		$intEntreServ=null; //no existe.
       	}
   		/*
   		* Buscamo la preñez actual para saber el tiempo de secado
   		*/	
        $prenezActual = DB::table('sgprenhezs')
                  ->where('id_finca','=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->get(); 
        
        if ($prenezActual->count()>0) {

            foreach ($prenezActual as $key ) {
           		# Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                $fechaAproxSecado = $key->fecas; 
            }	
        
        } else {
                   $fechaAproxSecado = null; 
               }
   		/*
   		* Fecha del ultimo parto
   		*/
   		$fechaUltimoParto = DB::table('sgpartos')
                  ->select(DB::raw('MAX(fecpar) as fultParto'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->get();  
        if ($fechaUltimoParto->count()>0 ) {

            foreach ($fechaUltimoParto as $key) {
                $fultParto = $key->fultParto; 
            }	
        
        } else {
           	$fultParto=null; //No existe
        }
        
        $intervaloEntreParto =  DB::table('sgpartos')
                   ->where('id_finca', '=',$id_finca)
                   ->where('id_serie','=',$id_serie)
                   ->where('fecpar','=',$fultParto)
                   ->get();		  	       		
        
        if ($intervaloEntreParto->count()>0) {
            
            foreach ($intervaloEntreParto as $key) {
                $intentpart = $key->ientpar; 
            }
        
        } else {
           	$intentpart = null; //ya que no existe;
        }
   		/*
   		* Con esto calculamos los valores IPARPC e IPARPS
   		*/
        if ( ($intentpart>0) and !($fpCelo==null)  ) {
   		
        	# si el Intervalo entre parto existe.
   			$difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
   			$iparpc = $intentpart - $difdias;
        
        } else {
           	# De lo contrario
           			$iparpc = null; // Es decir no existe 
        }
   		/********************************************************/
   		/*
   		* Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
   		*/	
   		$sghprodNuevo = new \App\Models\sghprenhez;

   		$sghprodNuevo->id_serie = $id_serie;
   		$sghprodNuevo->serie = $series->serie;
   		$sghprodNuevo->tipo = $tipoAnterior;

   		#Condicion de la madres
   		$sghprodNuevo->estado = $condicion->nombre_condicion;
   		$sghprodNuevo->raza = $raza->nombreraza;
   		$sghprodNuevo->idraza = $raza->idraza;
   		
   		$sghprodNuevo->edad = $request->edad;
   		$sghprodNuevo->nservi = $series->nservi;
   		$sghprodNuevo->tipops = $tipops;
   		$sghprodNuevo->pesps = $pesops;
   		$sghprodNuevo->fecps = $fechaPrimerServicio;
   		$sghprodNuevo->edadps = $edadPservicio;

   		$sghprodNuevo->fecspr = $fechasPr;
   		$sghprodNuevo->codtp = $codtpajuela;
   		$sghprodNuevo->respi = $nomi;
   		$sghprodNuevo->torotemp = $torotemporada;

   		$sghprodNuevo->tipoap = $series->tipoanterior;
   		$sghprodNuevo->fecup = $fultParto;
   		$sghprodNuevo->edadpp = $edadPp;
   		$sghprodNuevo->fecpar = $request->fnac; //La fecha en que nace la cria

   		/*
   		* Datos del animal cría 1
   		*/
   		$sghprodNuevo->sexo = $request->sexocria1;
        $sghprodNuevo->becer = $request->seriecria1;
        $sghprodNuevo->obspar = $request->observa;
        $sghprodNuevo->edobece = $request->condicorpocria1;
        $sghprodNuevo->razabe = $request->razacria1;
        $sghprodNuevo->pesoib = $request->pesoicria1;
        $sghprodNuevo->ientpar = $request->ier;
        $sghprodNuevo->marcabec1 = $marca;

 		#Verificamos si viene el padre es pajuela o torotemporada.
        if (!$codtpajuela==null) {
        
            $codpadre = $codtpajuela;

        } else {
            $codpadre = $torotemporada;
        
        }
        
        if (($codtpajuela==null) and ($torotemporada==null)) {
    	 	$codpadre = null; //Se desconoce el valor del codigo del padre; 
    	}

 		$sghprodNuevo->codp = $codpadre;
 		$sghprodNuevo->razapadre = $razapadre;
 		$sghprodNuevo->nombrepadre = $nombrepadre;
 		$sghprodNuevo->tipopadre = $tipopadre;
 		$sghprodNuevo->fechanacpadre = $fechanacpadre;
 		
 		$sghprodNuevo->espajuela = $espajuela;

 		$sghprodNuevo->fecas = $fechaAproxSecado;

 		$sghprodNuevo->ncelos = $nroCelos;
 		$sghprodNuevo->fecpc = $fpCelo;
 		$sghprodNuevo->edadpc = $edadpc;
 		$sghprodNuevo->fecuc = $fuc;

 		$sghprodNuevo->ientcel = $ientcelos;
 		$sghprodNuevo->iserv = $intEntreServ;
 		$sghprodNuevo->ientpar = $intentpart; 

 		$sghprodNuevo->iparps = $iparpc;
 		$sghprodNuevo->iparpc = $iparpc; 


 		$sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
 		$sghprodNuevo->nciclo = $id_ciclo;
        $sghprodNuevo->id_finca = $id_finca;

        $sghprodNuevo->save(); 

    	/* -----------------------------------------------------*
    	*  Fin de Actualización Tabla de sghprenez = sghprod
    	--------------------------------------------------------*/       
        $fecsistema = Carbon::now(); 
        /*
        * Se actualiza la tabla mv1 manejo de vientre 
        */
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        $mv1Nuevo->serie_hijo = $request->seriecria1;
        $mv1Nuevo->codpadre = 	$codpadre;

    	# Como se trata de un parto nuevo vivo, la tipologia viene por calcualda asi
        $tipologiaPartoNuevo = DB::table('sgtipologias')
    	    		->where('edad','=', 0) //hadcode, ya que es un animal que no tiene edad
    	    		->where('sexo','=',$request->sexocria1)
    	    		->where('peso','<=',$request->pesoicria1)
    	    		->where('destetado','=',0) //hadcode, Animal no destetado
    	    		->get();

    	foreach ($tipologiaPartoNuevo as $key) {
              $idtipoPartNuevo = $key->id_tipologia;
              $nombreTipo = $key->nombre_tipologia; 
        }
        $mv1Nuevo->tipologia = $nombreTipo;
        $mv1Nuevo->id_tipo = $idtipoPartNuevo;

        $mv1Nuevo->caso = $caso;
        $mv1Nuevo->fecha = $request->fnac;
        $mv1Nuevo->fecs = $fecsistema;

        $mv1Nuevo->id_finca = $id_finca;

        $mv1Nuevo->save();

    	/*
    	* Aqui Actualizamos la tabla datos de Vida Solo faltaria sacar las 
    	* filas sumatorias y promedios para cada serie.
    	*/
    	$datosDeVidaNuevo = new \App\Models\sgdatosvida;

    	$datosDeVidaNuevo->seriem = $series->serie;
    	$datosDeVidaNuevo->fecha = $request->fnac;
    	$datosDeVidaNuevo->caso = $caso;
    	$datosDeVidaNuevo->nservicios = $series->nservi;
    	$datosDeVidaNuevo->pesps = $pesops;
    	$datosDeVidaNuevo->edadps = $edadPservicio;
    	$datosDeVidaNuevo->codp = $codpadre;
    	$datosDeVidaNuevo->edadpp = $edadPp;

    	$datosDeVidaNuevo->serieh = $request->seriecria1;
    	$datosDeVidaNuevo->pespih = $request->pesoicria1;

    	$retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
    	
    	$datosDeVidaNuevo->diapr = $retVal;
    	$datosDeVidaNuevo->ncelos = $nroCelos;
    	$datosDeVidaNuevo->edadpc = $edadpc;

    	$datosDeVidaNuevo->fecas = $fechaAproxSecado;

    	$datosDeVidaNuevo->ientpar = $intentpart; 
    	$datosDeVidaNuevo->ientcel = $ientcelos;
        $datosDeVidaNuevo->iserv = $intEntreServ;
        $datosDeVidaNuevo->iee = $intentpart;

        $datosDeVidaNuevo->id_finca = $id_finca;

        $datosDeVidaNuevo->save();	    	
		/*
		* Aqui se debe actualizar la tabla sganims cuando se realiza el parto
		*/
		$partoRegistro = DB::table('sganims')
             ->where('id_finca','=', $id_finca)
             ->where('id','=',$id_serie)
             ->update(['nparto'=>$countparto,
                        'fecup'=>$fultParto,
                        'tipo'=>$nuevaTipologiaName,
                        'id_tipologia'=>$idTipologiaNueva,
                        'tipoanterior'=>$tipoAnterior,
                         #Actualizamos los parametros tipologicos.
                        'prenada'=>$prenhada,
                        'tienecria'=>$tienecria,
                        'criaviva'=>$criaViva,
                        'ordenho'=>$ordeNho,
                        'detectacelo'=>$detectaCelo]);
		/*
		* Sacamos la Tipologia inicial
		*/	
		$tipoPartoNuevo = DB::table('sgtipologias')
            ->where('sexo','=',$request->sexocria1)
            ->where('edad','=',0)
            ->where('peso','<=',$request->pesoicria1)
            ->get();

        foreach ($tipoPartoNuevo as $key) {
            $nombreTipo = $key->nombre_tipologia;
            $idTipo = $key->id_tipologia;
            $destetado = $key->destetado;
            #Sacamos los parametros tipologicos.
            $nroMonta = $key->nro_monta;
            $prenada = $key->prenada; 
            $parida = $key->parida; 
            $tieneCria = $key->tienecria; 
            $criaViva = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectaCelo = $key->detectacelo;  
        }
        /*
		* Sacamos la Raza
		*/	 
		$razaPartoNuevo = DB::table('sgrazas')
            ->where('nombreraza','=',$request->razacria1)
            ->get();
        
        foreach ($razaPartoNuevo as $key) {
            $idraza = $key->idraza;		
        }

        $condPartoNuevo = DB::table('sgcondicioncorporals')
                ->where('nombre_condicion','=',$request->condicorpocria1)
                ->get();	

        foreach ($condPartoNuevo as $key ) {
            $idcondicion = $key->id_condicion;		
        }	
		/*
		* Por ultimo Creamos la Ficha de Ganado para la nueva Cría
		*/            
    	$nuevaSerieParto = new \App\Models\sganim;

		$nuevaSerieParto->serie = $request->seriecria1;
		$nuevaSerieParto->nombrelote = $series->nombrelote;
		$nuevaSerieParto->codmadre = $series->serie; # Es la Serie que pario
		$nuevaSerieParto->codpadre = $codpadre;
		$nuevaSerieParto->espajuela = $espajuela; #voy a verificarlo
		$nuevaSerieParto->pajuela = $codpadre;
		$nuevaSerieParto->fnac = $request->fnac;
		$nuevaSerieParto->motivo = null; #Lo voy a Sacar
		$nuevaSerieParto->status = 1; #Activo
		$nuevaSerieParto->tipo = $nombreTipo;
		$nuevaSerieParto->color_pelaje = $request->colorpelaje; 
		$nuevaSerieParto->observa = $request->observa;
		$nuevaSerieParto->procede = $finca->nombre;
		$nuevaSerieParto->pesoi = $request->pesoicria1;
		$nuevaSerieParto->destatado = $destetado;
		$nuevaSerieParto->edad = "0-0"; #hardcode.
		$nuevaSerieParto->id_tipologia = $idTipo;
		$nuevaSerieParto->idraza = $idraza;
		$nuevaSerieParto->id_condicion = $idcondicion;
		$nuevaSerieParto->lnaci = $series->nombrelote;
        #Parametros tipologicos 
        $nuevaSerieParto->nro_monta = $nroMonta;
        $nuevaSerieParto->prenada = $prenada; 
        $nuevaSerieParto->parida = $parida; 
        $nuevaSerieParto->tienecria = $tieneCria;
        $nuevaSerieParto->criaviva = $criaViva;
        $nuevaSerieParto->ordenho =  $ordenho;
        $nuevaSerieParto->detectacelo = $detectaCelo;  
		$nuevaSerieParto->id_finca = $id_finca;

		$nuevaSerieParto->save();
    } //.Fin if
	
    /*
	
  * 2-> Validamos que el parto no sea morocho y este en condicion muerto
	*/
	if ( !($request->tipoparto=="on") and ($request->condicionnac1==0) ) {        		
		//return "Es parto unico Muerto";
		# Validamos los campos que utilizaremos
        $request->validate([

            'fnacmuerte'=> [
                'required',
            ],
            'muerterazacria1'=> [
                'required',
            ],
            'causamuerte1'=> [
                'required',
            ],
        ]);
    	# Aquí colocamos la Marca Mu para clasificar que ha nacido vivo y Mu que
    	# ha nacido muerto
    	$marca = "Mu"; 	 // hardcod
    	/*
    	* es importante buscar la tipología actual que es la misma que tiene
    	*antes del parto
    	*/
    	$tipoActual = $series->tipo;

    	/*
    	* 2-> Guardamos en la tabla de partos los registros del form. 
    	*/	 
    	$caso = "Nac. Muerto"; //hardcod

    	$partoNuevo = new \App\Models\sgparto;

        $partoNuevo->id_serie = $id_serie;
        $partoNuevo->serie = $request->serie;
        $partoNuevo->tipo = null;
        $partoNuevo->estado = $request->condicorpo;
        $partoNuevo->edad = $request->edad;
        $partoNuevo->tipoap = $tipoActual = $series->tipo;
        $partoNuevo->fecup = $request->fecup;

 		# Comienza los datos de la Cría 1 #
        $partoNuevo->fecpar = $request->fnacmuerte;
        $partoNuevo->causanm = $request->causamuerte1;
        $partoNuevo->razabe = $request->muerterazacria1;
        $partoNuevo->obsernm = $request->observamuerte1;

        $partoNuevo->ientpar = $request->ier;
        $partoNuevo->marcabec1 = $marca;

        $partoNuevo->id_ciclo = $id_ciclo;
        $partoNuevo->id_finca = $id_finca;

        try{
            $partoNuevo-> save();
                #Se Cambian los parametros tipologicos para cambio e tipologia
            $pario = 1;  
            $tienesucria = 1;
            $crianacioviva = 0; 
            $prenez = 0;    
        }catch (\Illuminate\Database\QueryException $e){
                #Se devuelven los cambios en caso de haber un error.
            $pario = 0;  
            $tienesucria = 0;
            $crianacioviva = 0; 
            $prenez = 1;
            return back()->with('mensaje', 'error');
        }

      /*
      * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
      */
	    $countparto =  DB::table('sgpartos')
             ->where('fecpar','=',$request->fnacmuerte)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->count(); 

        $nroparto = DB::table('sghistoricotemprepros')
             ->where('fecharegistro','=',$request->fnacmuerte)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->update(['nropart'=>$countparto]); 
        /*
        * Aqui actualizamos la Tipologia en caso de una preñez
        * ya que es un proceso que conlleva a eso.
        */
        #Buscamos la tipologia actual 
        $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
        
        #Obtenemos todos parametros de la tipologia
            
        foreach ($tipoActual as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $edad = $key->edad;
            $peso = $key->peso;
            $destetado = $key->destetado;
            $sexo = $key->sexo;
            $nro_monta = $key->nro_monta;
            $prenada = $key->prenada;
            $parida = $key->parida;
            $tienecria = $key->tienecria;
            $criaviva = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
            $idtipo = $key->id_tipologia;
        }
        #Actualizamos la tipologia
        #Obtenemos la tipologia anterior
        $tipoAnterior = $tipologiaName;
        $nroMonta = $series->nro_monta;

        # Actualizamos si se efectua el parto
        $tipologia= DB::table('sgtipologias')
                ->where('edad','=',$edad)
                ->where('peso','=',$peso)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$sexo)
                ->where('nro_monta','=',$nroMonta) //Revisar aqui
                ->where('prenada','=',$prenez)
                ->where('parida','=',$pario)
                ->where('tienecria','=',$tienesucria)
                ->where('criaviva','=',$crianacioviva)
                ->where('ordenho','=',$ordenho)
                ->where('detectacelo','=',$detectacelo)
                ->where('id_finca','=',$id_finca)
                ->get();

        foreach ($tipologia as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $idtipo = $key->id_tipologia;
            $prenada =$key->prenada;
            $tcria = $key->tienecria;
            $criav = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
        }   

        $idTipologiaNueva = $idtipo;
        $nuevaTipologiaName = $tipologiaName;
        $prenhada = $prenada;
        $tienecria = $tcria;
        $criaViva = $criav;
        $ordeNho = $ordenho;
        $detectaCelo = $detectacelo;
        /*
        * Actualizamos el campo tipo con la tipologia final
        */
        $tipologiaParto= DB::table('sgpartos')
        ->where('id_finca','=',$id_finca)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_serie','=',$id_serie)            
        ->update(['tipo'=>$nuevaTipologiaName]);        
        /*
        * Buscamos la fecha del perimer servicio
        */          
        $servicio = DB::table('sgservs')
        ->select(DB::raw('MIN(fecha) as fpserv'))
        ->where('id_serie','=',$id_serie)
        ->where('id_finca','=',$id_finca)
        ->get();
        /*
        * Si tenemos registros buscamos la fecha del primer servicio
        */  
        if ($servicio->count()>0) {
            #Si existe el servicio buscamo la fecha del primer servicio.
            foreach ($servicio as $key) {
                $fechaPrimerServicio = $key->fpserv;    
            }
        } else {
            $fechaPrimerServicio = null; 
        }
        # Con la fecha del primer servicio buscamo la tipologia primer servicio
        $tipoPrimerServicio = DB::table('sgservs')
        ->where('id_serie','=',$id_serie)
        ->where('fecha','=',$fechaPrimerServicio)
        ->where('id_finca','=',$id_finca)
        ->get();
                
        if ($tipoPrimerServicio->count()>0) {
            #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
            foreach ($tipoPrimerServicio as $key) {
                $id_tipologia = $key->id_tipologia;
                $pesops = $key->peso;   
            }
            # Con id ubicamos la Tipoloiga en la tabla
            $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
            #Obtenemos el Nombre de la Tipologia    
            $tipops= $tipologia->nombre_tipologia;
            #Obtenemos el peso que tiene la serie en el primer servicio
            $pesops = $pesops; 

        } else {
            $tipops= null; //No existe
            $pesops = null; //no existe
        } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
                
        # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
        $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
        ->select(DB::raw('MIN(fecser) as fespr'))
        ->where('id_finca', '=',$id_finca)
        ->where('id_serie','=',$id_serie)
        ->where('toropaj','<>',null)
        ->orWhere('torotemp','<>',null)
        ->get();  

        # Comprobamos si existe el servicio que generó la preñez    
        if ( $servicioPrimerPrenez->count()>0) {
            #Si existe, obtenemos fecha de primer servicio 
            foreach ($servicioPrimerPrenez as $key) {
                $fechasPr = $key->fespr; 
            }
        } else {
            $fechasPr = null; 
        }           
        /*
        Con la fechasPr creamos una consulta para verificar 
        si se trata de una preñez por toropajuela o torotempt 
        */
        $prenezHistorico = DB::table('sgprenhez_historicos')
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->where('fecser','=',$fechasPr)
            ->get();  
        # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
        if ($prenezHistorico->count()>0) {
            foreach ($prenezHistorico as $key) {
                $toropaj = $key->toropaj;
                $nomi = $key->nomi;
                $torotemp = $key->torotemp; 
            }
        } else {
            $toropaj = null;
            $nomi = null;
            $torotemp = null;
        }
        #Con los valores anteriores identificamos la pajuela
        $pajuela = DB::table('sgpajus')
            ->where('id_finca','=',$id_finca)
            ->where('serie','=',$toropaj)
            ->get();

        # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
        if ($pajuela->count()>0) {
            #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
            $espajuela = 1; 
            foreach ($pajuela as $key) {
                $idpaju = $key->id;
                $razapaju = $key->nombreraza;
                $fechanac = $key->fnac;
                $nombrepa = $key->nomb; 
            }
            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
        } else {
            #Si no existe la pajuela, sus valores pasan a null.
            $idpaju = null;
            $razapaju = null;
            $fechanac = null;
            $nombrepa = null;

            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
            #Como la pajuela no existe entonces marcamos a falso 
            $espajuela = 0; 
        }
        # Ubicamos si es Toro en caso de existir la Preñez Historico                
        $toro = DB::table('sganims')
            ->where('id_finca','=',$id_finca)
            ->where('serie','=',$torotemp)
            ->get();
                # Verificamos que el $torotemp exista
        if ($toro->count()>0) {
            #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
            $espajuela = 0; 
            foreach ($toro as $key) {
                $razatoro = $key->idraza;
                $idtipo = $key->id_tipologia;
                $fecnacPadre = $key->fnac;
            }
            $raza = \App\Models\sgraza::findOrFail($razatoro);
            $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
            
            $razapadre = $raza->nombreraza;
            $tipopadre = $tipotoro->nombre_tipologia;
            $fechanacpadre = $fecnacPadre;
            $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

        } else {
            #Si no existe el Toro, entonces se asume que fue una monta natural  
            $razapadre = null;
            $tipopadre = null;
            $fechanacpadre = null;
            $nombrepadre = null;       
        }
        #Actualizamos las variables si proviene de Pajuela o Toro.
        $fechasPr = $fechasPr; 
        $codtpajuela = $toropaj;
        $nomi = $nomi;
        $torotemporada = $torotemp;

        $razapadre = $razapadre;
        $tipopadre = $tipopadre;
        $fechanacpadre = $fechanacpadre;
        $nombrepadre = $nombrepadre;
        $espajuela = $espajuela;  
        /*
        * Ubicamos el primer servicio
        */
        $primerServicio = DB::table('sgservs')
        ->select(DB::raw('MIN(fecha) as fpservicio'))
        ->where('id_finca', '=',$id_finca)
        ->where('id_serie','=',$id_serie)
        ->get();
        /*
        * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
        */
        if ( $primerServicio->count()>0 ) {
            foreach ($primerServicio as $key) {
                $fecha = $key->fpservicio;
            }
        } else {
            # No tiene servicio creado
            $fecha=null; //no existe;
        }
        # Ubicamosla Edad primer servicio
        $edadPrimerServicio = DB::table('sgservs')
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->where('fecha','=', $fecha)
            ->get();        

        if ($edadPrimerServicio->count()>0) {
            foreach ($edadPrimerServicio as $key ) {
                $edadPservicio = $key->edad;
            }
        } else {
            $edadPservicio = null; //es decir no existe 
        }
        /*
        * Ubicamos la fecha del Primer parto
        */  
        $fechaPrimerParto = DB::table('sgpartos')
            ->select(DB::raw('MIN(fecpar) as fprimerParto'))
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->get(); 
                
        if ($fechaPrimerParto->count()>0) {
            foreach ($fechaPrimerParto as $key) {
                $fpParto = $key->fprimerParto; 
            }               
        } else {
            $fpParto=null; // no existe
        }                        
        /*
        * La edad del primer Parto
        */
        $edadPrimerParto = DB::table('sgpartos')
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->where('fecpar','=',$fpParto)
            ->get();

        if ($edadPrimerParto->count()>0) {
            foreach ($edadPrimerParto as $key ) {
                $edadPp = $key->edad; 
            }
        } else {
            $edadPp=null; 
        }
        /*
        * Ubicamos El numero de celos por la temporada de monta
        */
        $celos = DB::table('sgcelos')
            ->where('id_finca','=',$id_finca)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_serie','=',$id_serie)
            ->get();

        $nroCelos = $celos->count();    
        /*
        * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
        */
        $fechaPrimerCelo = DB::table('sgcelos')
            ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
            ->where('id_finca', '=',$id_finca)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_serie','=',$id_serie)
            ->get(); 
                
        if ( $fechaPrimerCelo->count()>0) {

            foreach ($fechaPrimerCelo as $key) {
                $fPrimerCelo = $key->fecPrimerCelo;
            }

            $fpCelo = $fPrimerCelo;

            //*************************************************
                //Se calcula con la herramienta carbon la edad
            $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
            $dt = $year*12;
                //se restan los meses para obtener los meses transcurridos. 
            $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                // se pasa a la variable edad, para guardar junto a la información que proviene del form.
            $edadpc = $year."-".$months;
            //*************************************************                     
        } else {
            $fpCelo = null; 
            $edadpc = null; // no exsite;

        }
        $fechaUltimoCelo = DB::table('sgcelos')
            ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
            ->where('id_finca', '=',$id_finca)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_serie','=',$id_serie)
            ->get(); 
        /*
        * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
        */
        if ( $fechaUltimoCelo->count()>0 ) {

            foreach ($fechaUltimoCelo as $key) {
                $fuCelo = $key->fecUltimoCelo;
            }
            $fuc = $fuCelo;
        } else {
            $fuc = null;
        }   
        /*
        * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
        */
        $ultimoCelo = DB::table('sgcelos')
            ->where('id_finca', '=',$id_finca)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_serie','=',$id_serie)
            ->where('fechr','=',$fuc)
            ->get(); 

        if ( ($ultimoCelo->count()>0) ) {
            foreach ($ultimoCelo as $key ) {
                $ientcel = $key->dias; 
            }   
            $ientcelos = $ientcel;

        } else {
            $ientcelos= null; 
        }   
        /*
        * Ubicamos el ultimo servicio
        */
        $ultServicio = DB::table('sgservs')
            ->select(DB::raw('MAX(fecha) as fultservicio'))
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->get();
        if ($ultServicio->count()>0) {
            foreach ($ultServicio as $key) {
                $fUltserv = $key->fultservicio;
            }
        } else {
            # No tiene servicio creado
            $fUltserv = null; //es decir no existe 
        }
        # Ubicamosla iserv del ultimo servicio
        $intServicio = DB::table('sgservs')
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->where('fecha','=', $fUltserv)
            ->get();        
        if ($intServicio->count()>0 ) {
            foreach ($intServicio as $key ) {
                $intEntreServ = $key->iers; 
            }   
        } else {
            $intEntreServ=null; //no existe.
        }
        /*
        * Buscamo la preñez actual para saber el tiempo de secado
        */  
        $prenezActual = DB::table('sgprenhezs')
            ->where('id_finca','=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->get(); 
        if ($prenezActual->count()>0) {

            foreach ($prenezActual as $key ) {
                # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                $fechaAproxSecado = $key->fecas; 
            }   
        } else {
            $fechaAproxSecado = null; 
        }
        /*
        * Fecha del ultimo parto
        */
        $fechaUltimoParto = DB::table('sgpartos')
            ->select(DB::raw('MAX(fecpar) as fultParto'))
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->get();  
        if ($fechaUltimoParto->count()>0 ) {

            foreach ($fechaUltimoParto as $key) {
                $fultParto = $key->fultParto; 
            }   
        } else {
            $fultParto=null; //No existe
        }
        $intervaloEntreParto =  DB::table('sgpartos')
                    ->where('id_finca', '=',$id_finca)
                    ->where('id_serie','=',$id_serie)
                    ->where('fecpar','=',$fultParto)
                    ->get();                        
        if ($intervaloEntreParto->count()>0) {
            foreach ($intervaloEntreParto as $key) {
                $intentpart = $key->ientpar; 
            }
        } else {
                $intentpart = null; //ya que no existe;
            }
        /*
        * Con esto calculamos los valores IPARPC e IPARPS
        */
        if ( ($intentpart>0) and !($fpCelo==null)  ) {
            # si el Intervalo entre parto existe.
            $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
            $iparpc = $intentpart - $difdias;
        } else {
            # De lo contrario
            $iparpc = null; // Es decir no existe 
        }
                
        /********************************************************/
        /*
        * Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
        */  
        $sghprodNuevo = new \App\Models\sghprenhez;

        $sghprodNuevo->id_serie = $id_serie;
        $sghprodNuevo->serie = $series->serie;
        $sghprodNuevo->tipo = $tipoAnterior;

        #Condicion de la madres
        $sghprodNuevo->estado = $condicion->nombre_condicion;
        $sghprodNuevo->raza = $raza->nombreraza;
        $sghprodNuevo->idraza = $raza->idraza;
        
        $sghprodNuevo->edad = $request->edad;
        $sghprodNuevo->nservi = $series->nservi;
        $sghprodNuevo->tipops = $tipops;
        $sghprodNuevo->pesps = $pesops;
        $sghprodNuevo->fecps = $fechaPrimerServicio;
        $sghprodNuevo->edadps = $edadPservicio;

        $sghprodNuevo->fecspr = $fechasPr;
        $sghprodNuevo->codtp = $codtpajuela;
        $sghprodNuevo->respi = $nomi;
        $sghprodNuevo->torotemp = $torotemporada;

        $sghprodNuevo->tipoap = $series->tipoanterior;
        $sghprodNuevo->fecup = $fultParto;
        $sghprodNuevo->edadpp = $edadPp;
        $sghprodNuevo->fecpar = $request->fnacmuerte; //La fecha en que nace la cria
        /*
        * Datos del animal cría 1
        */
        $sghprodNuevo->obsernm = $request->observamuerte1;
        $sghprodNuevo->causanm = $request->causamuerte1;
        $sghprodNuevo->razabe = $request->razacria1;
        $sghprodNuevo->marcabec1 = $marca;
        #Verificamos si viene el padre es pajuela o torotemporada.
        if (!$codtpajuela==null) {
            $codpadre = $codtpajuela;

        } else {
            $codpadre = $torotemporada;
        }
        if (($codtpajuela==null) and ($torotemporada==null)) {
            $codpadre = null; //Se desconoce el valor del codigo del padre; 
        }
        $sghprodNuevo->codp = $codpadre;
        $sghprodNuevo->razapadre = $razapadre;
        $sghprodNuevo->nombrepadre = $nombrepadre;
        $sghprodNuevo->tipopadre = $tipopadre;
        $sghprodNuevo->fechanacpadre = $fechanacpadre;
        
        $sghprodNuevo->espajuela = $espajuela;

        $sghprodNuevo->fecas = $fechaAproxSecado;

        $sghprodNuevo->ncelos = $nroCelos;
        $sghprodNuevo->fecpc = $fpCelo;
        $sghprodNuevo->edadpc = $edadpc;
        $sghprodNuevo->fecuc = $fuc;

        $sghprodNuevo->ientcel = $ientcelos;
        $sghprodNuevo->iserv = $intEntreServ;
        $sghprodNuevo->ientpar = $intentpart; 

        $sghprodNuevo->iparps = $iparpc;
        $sghprodNuevo->iparpc = $iparpc; 


        $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
        $sghprodNuevo->nciclo = $id_ciclo;
        $sghprodNuevo->id_finca = $id_finca;

        $sghprodNuevo->save(); 

        /* --------------------------------------------------------*
        *  Fin de Actualización Tabla de sghprenez = sghprod
        -----------------------------------------------------------*/       
        $fecsistema = Carbon::now(); 
        /*
        * Se actualiza la tabla mv1 manejo de vientre 
        */
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        $mv1Nuevo->caso = $caso;
        $mv1Nuevo->fecha = $request->fnacmuerte;
        $mv1Nuevo->fecs = $fecsistema;

        $mv1Nuevo->id_finca = $id_finca;

        $mv1Nuevo->save();
        /*
        * Aqui Actualizamos la tabla datos de Vida Solo faltaria sacar las 
        * filas sumatorias y promedios para cada serie.
        */
        $datosDeVidaNuevo = new \App\Models\sgdatosvida;

        $datosDeVidaNuevo->seriem = $series->serie;
        $datosDeVidaNuevo->fecha = $request->fnacmuerte;
        $datosDeVidaNuevo->caso = $caso;
        $datosDeVidaNuevo->nservicios = $series->nservi;
        $datosDeVidaNuevo->pesps = $pesops;
        $datosDeVidaNuevo->edadps = $edadPservicio;
        $datosDeVidaNuevo->codp = $codpadre;
        $datosDeVidaNuevo->edadpp = $edadPp;

        $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
        
        $datosDeVidaNuevo->diapr = $retVal;
        $datosDeVidaNuevo->ncelos = $nroCelos;
        $datosDeVidaNuevo->edadpc = $edadpc;

        $datosDeVidaNuevo->fecas = $fechaAproxSecado;

        $datosDeVidaNuevo->ientpar = $intentpart; 
        $datosDeVidaNuevo->ientcel = $ientcelos;
        $datosDeVidaNuevo->iserv = $intEntreServ;
        $datosDeVidaNuevo->iee = $intentpart;

        $datosDeVidaNuevo->id_finca = $id_finca;

        $datosDeVidaNuevo->save();          
        /*
        * Aqui se debe actualizar la tabla sganims cuando se realiza el parto
        */
        $partoRegistro = DB::table('sganims')
                ->where('id_finca','=', $id_finca)
                ->where('id','=',$id_serie)
                ->update(['nparto'=>$countparto,
                  'fecup'=>$fultParto,
                  'tipo'=>$nuevaTipologiaName,
                  'id_tipologia'=>$idTipologiaNueva,
                  'tipoanterior'=>$tipoAnterior,
                  #Actualizamos los parametros tipologicos.
                  'prenada'=>$prenhada,
                  'tienecria'=>$tienecria,
                  'criaviva'=>$criaViva,
                  'ordenho'=>$ordeNho,
                  'detectacelo'=>$detectaCelo]);
    
    } //.Fin if
    
    /*
    * Partos Morochos y las dos crías están vivas.
    */
    if ( ($request->tipoparto=="on") and ($request->condicionnac1==1) and ($request->condicionnac2==1) ) 
      {

        $request->validate([
          'seriecria1'=> [
              'required',
                 // 'unique:sgpartos,becer,NULL,NULL,id_finca,'. $id_finca,
                  //'unique:sganims,serie,NULL,NULL,id_finca,'. $id_finca,
          ],
          'razacria1'=> [
              'required',
          ],
          'pesoicria1'=> [
              'required',
          ],
          'lotecria1'=> [
              'required',
          ],
          'condicorpocria1'=> [
              'required',
          ],
          'fnac'=> [
              'required',
          ],

          'seriecria2'=> [
              'required',
                 // 'unique:sgpartos,becer1,NULL,NULL,id_finca,'. $id_finca,
                  //'unique:sganims,serie,NULL,NULL,id_finca,'. $id_finca,
          ],
          'razacria2'=> [
              'required',
          ],
          'pesoicria2'=> [
              'required',
          ],
          'lotecria2'=> [
              'required',
          ],
          'condicorpocria2'=> [
              'required',
          ],
          'fnac2'=> [
              'required',
          ],
      ]);
    	# Aquí colocamos la Marca Vi para clasificar que ha nacido vivo y Mu que
    	# ha nacido muerto
    	$marca = "Vi"; 	 // hardcod
    	/*
    	* es importante buscar la tipología actual que es la misma que tiene
    	*antes del parto
    	*/
    	$tipoActual = $series->tipo;

    	/*
    	* 2-> Guardamos en la tabla de partos los registros del form. 
    	*/	 
    	$caso = "Parto Morochos"; //hardcod

    	$partoNuevo = new \App\Models\sgparto;

      $partoNuevo->id_serie = $id_serie;
      $partoNuevo->serie = $request->serie;
      $partoNuevo->tipo = null;
      $partoNuevo->estado = $request->condicorpo;
      $partoNuevo->edad = $request->edad;
      $partoNuevo->tipoap = $tipoActual = $series->tipo;
      $partoNuevo->fecup = $request->fecup;
		  # Comienza los datos de la Cría 1 #
      $partoNuevo->fecpar = $request->fnac;
      $partoNuevo->sexo = $request->sexocria1;
      $partoNuevo->becer = $request->seriecria1;
      $partoNuevo->lotebecerro = $request->lotecria1;
      $partoNuevo->obspar = $request->observa;
      $partoNuevo->edobece = $request->condicorpocria1;
      $partoNuevo->razabe = $request->razacria1;
      $partoNuevo->pesoib = $request->pesoicria1;
      $partoNuevo->ientpar = $request->ier;
      $partoNuevo->marcabec1 = $marca;
      $partoNuevo->color_pelaje = $request->colorpelaje;
    	# Comienza los datos de la Cría 2 #
      $partoNuevo->fecpar = $request->fnac2;
      $partoNuevo->sexo1 = $request->sexocria2;
      $partoNuevo->becer1 = $request->seriecria2;
      $partoNuevo->lotebecerro1 = $request->lotecria2;
      $partoNuevo->obspar1 = $request->observa;
      $partoNuevo->edobece1 = $request->condicorpocria2;
      $partoNuevo->razabe = $request->razacria2;
      $partoNuevo->pesoib1 = $request->pesoicria2;
      $partoNuevo->ientpar = $request->ier;
      $partoNuevo->marcabec2 = $marca;
      $partoNuevo->color_pelaje1 = $request->colorpelaje1;

      $partoNuevo->id_ciclo = $id_ciclo;
      $partoNuevo->id_finca = $id_finca;

      try{

        $partoNuevo-> save();
            #Se Cambian los parametros tipologicos para cambio e tipologia
        $pario = 1;  
        $tienesucria = 1;
        $crianacioviva = 1; 
        $prenez = 0;    
      }catch (\Illuminate\Database\QueryException $e){
            #Se devuelven los cambios en caso de haber un error.
        $pario = 0;  
        $tienesucria = 0;
        $crianacioviva = 0; 
        $prenez = 1;
        return back()->with('mensaje', 'error');
      } 

      $countparto =  DB::table('sgpartos')
        ->where('fecpar','=',$request->fnac)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->count(); 

      $nroparto = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$request->fnac)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropart'=>$countparto]); 
      /*
      * Aqui actualizamos la Tipologia en caso de una preñez
      * ya que es un proceso que conlleva a eso.
      */
      #Buscamos la tipologia actual 
      $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
      #Obtenemos todos parametros de la tipologia
      foreach ($tipoActual as $key ) {
          $tipologiaName = $key->nombre_tipologia;
          $edad = $key->edad;
          $peso = $key->peso;
          $destetado = $key->destetado;
          $sexo = $key->sexo;
          $nro_monta = $key->nro_monta;
          $prenada = $key->prenada;
          $parida = $key->parida;
          $tienecria = $key->tienecria;
          $criaviva = $key->criaviva;
          $ordenho = $key->ordenho;
          $detectacelo = $key->detectacelo;
          $idtipo = $key->id_tipologia;
      }
      #Actualizamos la tipologia
      #Obtenemos la tipologia anterior
      $tipoAnterior = $tipologiaName;
      $nroMonta = $series->nro_monta;

      # Actualizamos si se efectua el parto.
      $tipologia= DB::table('sgtipologias')
          ->where('edad','=',$edad)
          ->where('peso','=',$peso)
          ->where('destetado','=',$destetado)
          ->where('sexo','=',$sexo)
          ->where('nro_monta','<=',$nroMonta) //Revisar aqui
          ->where('prenada','=',$prenez)
          ->where('parida','=',$pario)
          ->where('tienecria','=',$tienesucria)
          ->where('criaviva','=',$crianacioviva)
          ->where('ordenho','=',$ordenho)
          ->where('detectacelo','=',$detectacelo)
          ->where('id_finca','=',$id_finca)
          ->get();

          foreach ($tipologia as $key ) {
              $tipologiaName = $key->nombre_tipologia;
              $idtipo = $key->id_tipologia;
              $prenada =$key->prenada;
              $tcria = $key->tienecria;
              $criav = $key->criaviva;
              $ordenho = $key->ordenho;
              $detectacelo = $key->detectacelo;
          }   

          $idTipologiaNueva = $idtipo;
          $nuevaTipologiaName = $tipologiaName;
          $prenhada = $prenada;
          $tienecria = $tcria;
          $criaViva = $criav;
          $ordeNho = $ordenho;
          $detectaCelo = $detectacelo;
          /*
          * Actualizamos el campo tipo con la tipologia final
          */
          $tipologiaParto= DB::table('sgpartos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)            
                ->update(['tipo'=>$nuevaTipologiaName]);        
          /*
          * Buscamos la fecha del perimer servicio
          */          
          $servicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpserv'))
                ->where('id_serie','=',$id_serie)
                ->where('id_finca','=',$id_finca)
                ->get();
          /*
          * Si tenemos registros buscamos la fecha del primer servicio
          */  
          if ($servicio->count()>0) {
              #Si existe el servicio buscamo la fecha del primer servicio.
              foreach ($servicio as $key) {
                  $fechaPrimerServicio = $key->fpserv;    
              }
          } else {
              $fechaPrimerServicio = null; 
          }
          # Con la fecha del primer servicio buscamo la tipologia primer servicio
          $tipoPrimerServicio = DB::table('sgservs')
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=',$fechaPrimerServicio)
                ->where('id_finca','=',$id_finca)
                ->get();
          if ($tipoPrimerServicio->count()>0) {
              #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
              foreach ($tipoPrimerServicio as $key) {
                  $id_tipologia = $key->id_tipologia;
                  $pesops = $key->peso;   
              }
              # Con id ubicamos la Tipoloiga en la tabla
              $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
              #Obtenemos el Nombre de la Tipologia    
              $tipops= $tipologia->nombre_tipologia;
              #Obtenemos el peso que tiene la serie en el primer servicio
              $pesops = $pesops; 
          } else {
              $tipops= null; //No existe
              $pesops = null; //no existe
          } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
          
          # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
          $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
                ->select(DB::raw('MIN(fecser) as fespr'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('toropaj','<>',null)
                ->orWhere('torotemp','<>',null)
                ->get();  
          # Comprobamos si existe el servicio que generó la preñez    
          if ( $servicioPrimerPrenez->count()>0) {
              #Si existe, obtenemos fecha de primer servicio 
              foreach ($servicioPrimerPrenez as $key) {
                  $fechasPr = $key->fespr; 
              }
          } else {
              $fechasPr = null; 
          }           
          /*
          Con la fechasPr creamos una consulta para verificar 
          si se trata de una preñez por toropajuela o torotempt 
          */
          $prenezHistorico = DB::table('sgprenhez_historicos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecser','=',$fechasPr)
                ->get();  
          # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
          if ($prenezHistorico->count()>0) {
              foreach ($prenezHistorico as $key) {
                  $toropaj = $key->toropaj;
                  $nomi = $key->nomi;
                  $torotemp = $key->torotemp; 
              }
          } else {
              $toropaj = null;
              $nomi = null;
              $torotemp = null;
          }
          #Con los valores anteriores identificamos la pajuela
          $pajuela = DB::table('sgpajus')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$toropaj)
                ->get();

            # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
            if ($pajuela->count()>0) {
                #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
                $espajuela = 1; 
                foreach ($pajuela as $key) {
                    $idpaju = $key->id;
                    $razapaju = $key->nombreraza;
                    $fechanac = $key->fnac;
                    $nombrepa = $key->nomb; 
                }
                $nombrepadre = $nombrepa;
                $razapadre = $razapaju;
                $tipopadre = null;
                $fechanacpadre = $fechanac;
            } else {
                #Si no existe la pajuela, sus valores pasan a null.
                $idpaju = null;
                $razapaju = null;
                $fechanac = null;
                $nombrepa = null;

                $nombrepadre = $nombrepa;
                $razapadre = $razapaju;
                $tipopadre = null;
                $fechanacpadre = $fechanac;
                #Como la pajuela no existe entonces marcamos a falso 
                $espajuela = 0; 
            }
            # Ubicamos si es Toro en caso de existir la Preñez Historico                
            $toro = DB::table('sganims')
                  ->where('id_finca','=',$id_finca)
                  ->where('serie','=',$torotemp)
                  ->get();
            # Verificamos que el $torotemp exista
            if ($toro->count()>0) {
                #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
                $espajuela = 0; 
                foreach ($toro as $key) {
                    $razatoro = $key->idraza;
                    $idtipo = $key->id_tipologia;
                    $fecnacPadre = $key->fnac;
                }
                $raza = \App\Models\sgraza::findOrFail($razatoro);
                $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
                
                $razapadre = $raza->nombreraza;
                $tipopadre = $tipotoro->nombre_tipologia;
                $fechanacpadre = $fecnacPadre;
                $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

            } else {
                #Si no existe el Toro, entonces se asume que fue una monta natural  
                $razapadre = null;
                $tipopadre = null;
                $fechanacpadre = null;
                $nombrepadre = null;
            }
                #Actualizamos las variables si proviene de Pajuela o Toro.
                $fechasPr = $fechasPr; 
                $codtpajuela = $toropaj;
                $nomi = $nomi;
                $torotemporada = $torotemp;

                $razapadre = $razapadre;
                $tipopadre = $tipopadre;
                $fechanacpadre = $fechanacpadre;
                $nombrepadre = $nombrepadre;
               
                $espajuela = $espajuela;
                /*
                * Ubicamos el primer servicio
                */
                $primerServicio = DB::table('sgservs')
                    ->select(DB::raw('MIN(fecha) as fpservicio'))
                    ->where('id_finca', '=',$id_finca)
                    ->where('id_serie','=',$id_serie)
                    ->get();
                /*
                * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
                */
                if ( $primerServicio->count()>0 ) {
                    foreach ($primerServicio as $key) {
                        $fecha = $key->fpservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fecha=null; //no existe;
                }
                # Ubicamosla Edad primer servicio
                $edadPrimerServicio = DB::table('sgservs')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecha','=', $fecha)
                  ->get();        

                if ($edadPrimerServicio->count()>0) {
                    foreach ($edadPrimerServicio as $key ) {
                        $edadPservicio = $key->edad;
                    }
                } else {
                    $edadPservicio = null; //es decir no existe 
                }
                /*
                * Ubicamos la fecha del Primer parto
                */  
                $fechaPrimerParto = DB::table('sgpartos')
                    ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                    ->where('id_finca', '=',$id_finca)
                    ->where('id_serie','=',$id_serie)
                    ->get(); 

                if ($fechaPrimerParto->count()>0) {
                    foreach ($fechaPrimerParto as $key) {
                        $fpParto = $key->fprimerParto; 
                    }               
                } else {
                    $fpParto=null; // no existe
                }                        
                /*
                * La edad del primer Parto
                */
                $edadPrimerParto = DB::table('sgpartos')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecpar','=',$fpParto)
                  ->get();

                if ($edadPrimerParto->count()>0) {
                    foreach ($edadPrimerParto as $key ) {
                        $edadPp = $key->edad; 
                    }
                } else {
                    $edadPp=null; 
                }
                /*
                * Ubicamos El numero de celos por la temporada de monta
                */
                $celos = DB::table('sgcelos')
                  ->where('id_finca','=',$id_finca)
                  ->where('id_ciclo','=',$id_ciclo)
                  ->where('id_serie','=',$id_serie)
                  ->get();

                $nroCelos = $celos->count();    
                /*
                * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
                */
                $fechaPrimerCelo = DB::table('sgcelos')
                  ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_ciclo','=',$id_ciclo)
                  ->where('id_serie','=',$id_serie)
                  ->get(); 
                //if ( ($fechaPrimerCelo==null) or empty($fechaPrimerCelo) ) {
                if ( $fechaPrimerCelo->count()>0) {

                    foreach ($fechaPrimerCelo as $key) {
                        $fPrimerCelo = $key->fecPrimerCelo;
                    }

                    $fpCelo = $fPrimerCelo;

                    //*************************************************
                        //Se calcula con la herramienta carbon la edad
                    $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
                    $dt = $year*12;
                        //se restan los meses para obtener los meses transcurridos. 
                    $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
                    $edadpc = $year."-".$months;
                    //*************************************************                     
                } else {
                    $fpCelo = null; 
                    $edadpc = null; // no exsite;

                }
                $fechaUltimoCelo = DB::table('sgcelos')
                  ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_ciclo','=',$id_ciclo)
                  ->where('id_serie','=',$id_serie)
                  ->get(); 
                /*
                * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
                */
                if ( $fechaUltimoCelo->count()>0 ) {

                    foreach ($fechaUltimoCelo as $key) {
                        $fuCelo = $key->fecUltimoCelo;
                    }
                    $fuc = $fuCelo;
                } else {
                    $fuc = null;
                }   
                /*
                * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
                */
                $ultimoCelo = DB::table('sgcelos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->where('fechr','=',$fuc)
                ->get(); 

                if ( ($ultimoCelo->count()>0) ) {
                    foreach ($ultimoCelo as $key ) {
                        $ientcel = $key->dias; 
                    }   
                    $ientcelos = $ientcel;

                } else {
                    $ientcelos= null; 
                }   
                /*
                * Ubicamos el ultimo servicio
                */
                $ultServicio = DB::table('sgservs')
                  ->select(DB::raw('MAX(fecha) as fultservicio'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->get();
                if ($ultServicio->count()>0) {
                    foreach ($ultServicio as $key) {
                        $fUltserv = $key->fultservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fUltserv = null; //es decir no existe 
                }
                # Ubicamosla iserv del ultimo servicio
                $intServicio = DB::table('sgservs')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecha','=', $fUltserv)
                  ->get();        
                if ($intServicio->count()>0 ) {
                    foreach ($intServicio as $key ) {
                        $intEntreServ = $key->iers; 
                    }   
                } else {
                    $intEntreServ=null; //no existe.
                }
                /*
                * Buscamo la preñez actual para saber el tiempo de secado
                */  
                $prenezActual = DB::table('sgprenhezs')
                  ->where('id_finca','=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->get(); 
                if ($prenezActual->count()>0) {
                    foreach ($prenezActual as $key ) {
                        # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                        $fechaAproxSecado = $key->fecas; 
                    }   
                } else {
                    $fechaAproxSecado = null; 
                }
                /*
                * Fecha del ultimo parto
                */
                $fechaUltimoParto = DB::table('sgpartos')
                  ->select(DB::raw('MAX(fecpar) as fultParto'))
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->get();  
                if ($fechaUltimoParto->count()>0 ) {
                    foreach ($fechaUltimoParto as $key) {
                        $fultParto = $key->fultParto; 
                    }   
                } else {
                    $fultParto=null; //No existe
                }
                $intervaloEntreParto =  DB::table('sgpartos')
                  ->where('id_finca', '=',$id_finca)
                  ->where('id_serie','=',$id_serie)
                  ->where('fecpar','=',$fultParto)
                  ->get();                        
                if ($intervaloEntreParto->count()>0) {
                    foreach ($intervaloEntreParto as $key) {
                        $intentpart = $key->ientpar; 
                    }
                } else {
                        $intentpart = null; //ya que no existe;
                    }
                /*
                * Con esto calculamos los valores IPARPC e IPARPS
                */
                if ( ($intentpart>0) and !($fpCelo==null)  ) {
                    # si el Intervalo entre parto existe.
                    $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
                    $iparpc = $intentpart - $difdias;
                } else {
                    # De lo contrario
                    $iparpc = null; // Es decir no existe 
                }
                
                /********************************************************/
                /*
                * Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
                */  
                $sghprodNuevo = new \App\Models\sghprenhez;

                $sghprodNuevo->id_serie = $id_serie;
                $sghprodNuevo->serie = $series->serie;
                $sghprodNuevo->tipo = $tipoAnterior;

                #Condicion de la madres
                $sghprodNuevo->estado = $condicion->nombre_condicion;
                $sghprodNuevo->raza = $raza->nombreraza;
                $sghprodNuevo->idraza = $raza->idraza;
                
                $sghprodNuevo->edad = $request->edad;
                $sghprodNuevo->nservi = $series->nservi;
                $sghprodNuevo->tipops = $tipops;
                $sghprodNuevo->pesps = $pesops;
                $sghprodNuevo->fecps = $fechaPrimerServicio;
                $sghprodNuevo->edadps = $edadPservicio;

                $sghprodNuevo->fecspr = $fechasPr;
                $sghprodNuevo->codtp = $codtpajuela;
                $sghprodNuevo->respi = $nomi;
                $sghprodNuevo->torotemp = $torotemporada;

                $sghprodNuevo->tipoap = $series->tipoanterior;
                $sghprodNuevo->fecup = $fultParto;
                $sghprodNuevo->edadpp = $edadPp;
                $sghprodNuevo->fecpar = $request->fnac; //La fecha en que nace la cria

                /*
                * Datos del animal cría 1
                */
                $sghprodNuevo->sexo = $request->sexocria1;
                $sghprodNuevo->becer = $request->seriecria1;
                $sghprodNuevo->obspar = $request->observa;
                $sghprodNuevo->edobece = $request->condicorpocria1;
                $sghprodNuevo->razabe = $request->razacria1;
                $sghprodNuevo->pesoib = $request->pesoicria1;
               // $sghprodNuevo->ientpar = $request->ier;
                $sghprodNuevo->marcabec1 = $marca;
                /*
                * Datos del animal cria 2
                */
                $sghprodNuevo->sexo1 = $request->sexocria2;
                $sghprodNuevo->becer1 = $request->seriecria2;
                $sghprodNuevo->obsebec1 = $request->observa2;
                $sghprodNuevo->edobece1 = $request->condicorpocria2;
                //$sghprodNuevo->razabe = $request->razacria2;
                $sghprodNuevo->pesoib1 = $request->pesoicria2;
                //$sghprodNuevo->ientpar = $request->ier;
                $sghprodNuevo->marcabec2 = $marca;
                
                #Verificamos si viene el padre es pajuela o torotemporada.
                if (!$codtpajuela==null) {
                    $codpadre = $codtpajuela;

                } else {
                    $codpadre = $torotemporada;
                }
                if (($codtpajuela==null) and ($torotemporada==null)) {
                    $codpadre = null; //Se desconoce el valor del codigo del padre; 
                }

                $sghprodNuevo->codp = $codpadre;
                $sghprodNuevo->razapadre = $razapadre;
                $sghprodNuevo->nombrepadre = $nombrepadre;
                $sghprodNuevo->tipopadre = $tipopadre;
                $sghprodNuevo->fechanacpadre = $fechanacpadre;
                
                $sghprodNuevo->espajuela = $espajuela;

                $sghprodNuevo->fecas = $fechaAproxSecado;

                $sghprodNuevo->ncelos = $nroCelos;
                $sghprodNuevo->fecpc = $fpCelo;
                $sghprodNuevo->edadpc = $edadpc;
                $sghprodNuevo->fecuc = $fuc;

                $sghprodNuevo->ientcel = $ientcelos;
                $sghprodNuevo->iserv = $intEntreServ;
                $sghprodNuevo->ientpar = $intentpart; 

                $sghprodNuevo->iparps = $iparpc;
                $sghprodNuevo->iparpc = $iparpc; 


                $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
                $sghprodNuevo->nciclo = $id_ciclo;
                $sghprodNuevo->id_finca = $id_finca;

                $sghprodNuevo->save(); 

                /* --------------------------------------------------------*
                *  Fin de Actualización Tabla de sghprenez = sghprod
                -----------------------------------------------------------*/       
                $fecsistema = Carbon::now(); 
                /*
                * Se actualiza la tabla mv1 manejo de vientre 
                */
                $mv1Nuevo = new \App\Models\sgmv1;

                $mv1Nuevo->codmadre = $request->serie;
                $mv1Nuevo->serie_hijo = $request->seriecria1;
                $mv1Nuevo->codpadre =   $codpadre;

                # Como se trata de un parto nuevo vivo, la tipologia viene por calcualda asi
                $tipologiaPartoNuevo = DB::table('sgtipologias')
                    ->where('edad','=', 0) //hadcode, ya que es un animal que no tiene edad
                    ->where('sexo','=',$request->sexocria1)
                    ->where('peso','<=',$request->pesoicria1)
                    ->where('destetado','=',0) //hadcode, Animal no destetado
                    ->get();

                foreach ($tipologiaPartoNuevo as $key) {
                   $idtipoPartNuevo = $key->id_tipologia;
                   $nombreTipo = $key->nombre_tipologia; 
                }
                $mv1Nuevo->tipologia = $nombreTipo;
                $mv1Nuevo->id_tipo = $idtipoPartNuevo;

                $mv1Nuevo->caso = $caso;
                $mv1Nuevo->fecha = $request->fnac;
                $mv1Nuevo->fecs = $fecsistema;

                $mv1Nuevo->id_finca = $id_finca;

                $mv1Nuevo->save();

                /*
                * Segunda Cria viva mv1
                */
                /*
                * Se actualiza la tabla mv1 manejo de vientre 
                */
                $mv1Nuevo = new \App\Models\sgmv1;

                $mv1Nuevo->codmadre = $request->serie;
                $mv1Nuevo->serie_hijo = $request->seriecria2;
                $mv1Nuevo->codpadre =   $codpadre;

                # Como se trata de un parto nuevo vivo, la tipologia viene por calcualda asi
                $tipologiaPartoNuevo2 = DB::table('sgtipologias')
                    ->where('edad','=', 0) //hadcode, ya que es un animal que no tiene edad
                    ->where('sexo','=',$request->sexocria2)
                    ->where('peso','<=',$request->pesoicria2)
                    ->where('destetado','=',0) //hadcode, Animal no destetado
                    ->get();

                    foreach ($tipologiaPartoNuevo2 as $key) {
                       $idtipoPartNuevo2 = $key->id_tipologia;
                       $nombreTipo2 = $key->nombre_tipologia;
                   }

                $mv1Nuevo->tipologia = $nombreTipo2;
                $mv1Nuevo->id_tipo = $idtipoPartNuevo2;

                $mv1Nuevo->caso = $caso;
                $mv1Nuevo->fecha = $request->fnac;
                $mv1Nuevo->fecs = $fecsistema;

                $mv1Nuevo->id_finca = $id_finca;

                $mv1Nuevo->save();
                /*
                * Aqui Actualizamos la tabla datos de Vida Solo faltaria sacar las 
                */
                $datosDeVidaNuevo = new \App\Models\sgdatosvida;

                $datosDeVidaNuevo->seriem = $series->serie;
                $datosDeVidaNuevo->fecha = $request->fnac;
                $datosDeVidaNuevo->caso = $caso;
                $datosDeVidaNuevo->nservicios = $series->nservi;
                $datosDeVidaNuevo->pesps = $pesops;
                $datosDeVidaNuevo->edadps = $edadPservicio;
                $datosDeVidaNuevo->codp = $codpadre;
                $datosDeVidaNuevo->edadpp = $edadPp;

                $datosDeVidaNuevo->serieh = $request->seriecria1;
                $datosDeVidaNuevo->pespih = $request->pesoicria1;

                $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
                
                $datosDeVidaNuevo->diapr = $retVal;
                $datosDeVidaNuevo->ncelos = $nroCelos;
                $datosDeVidaNuevo->edadpc = $edadpc;

                $datosDeVidaNuevo->fecas = $fechaAproxSecado;

                $datosDeVidaNuevo->ientpar = $intentpart; 
                $datosDeVidaNuevo->ientcel = $ientcelos;
                $datosDeVidaNuevo->iserv = $intEntreServ;
                $datosDeVidaNuevo->iee = $intentpart;

                $datosDeVidaNuevo->id_finca = $id_finca;

                $datosDeVidaNuevo->save();
                /*
                * Actualizamos nuevamente la tabla Datos de Vida para la cria 2
                */
                $datosDeVidaNuevo = new \App\Models\sgdatosvida;

                $datosDeVidaNuevo->seriem = $series->serie;
                $datosDeVidaNuevo->fecha = $request->fnac;
                $datosDeVidaNuevo->caso = $caso;
                $datosDeVidaNuevo->nservicios = $series->nservi;
                $datosDeVidaNuevo->pesps = $pesops;
                $datosDeVidaNuevo->edadps = $edadPservicio;
                $datosDeVidaNuevo->codp = $codpadre;
                $datosDeVidaNuevo->edadpp = $edadPp;

                $datosDeVidaNuevo->serieh = $request->seriecria2;
                $datosDeVidaNuevo->pespih = $request->pesoicria2;

                $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
                
                $datosDeVidaNuevo->diapr = $retVal;
                $datosDeVidaNuevo->ncelos = $nroCelos;
                $datosDeVidaNuevo->edadpc = $edadpc;

                $datosDeVidaNuevo->fecas = $fechaAproxSecado;

                $datosDeVidaNuevo->ientpar = $intentpart; 
                $datosDeVidaNuevo->ientcel = $ientcelos;
                $datosDeVidaNuevo->iserv = $intEntreServ;
                $datosDeVidaNuevo->iee = $intentpart;

                $datosDeVidaNuevo->id_finca = $id_finca;

                $datosDeVidaNuevo->save();
                /*
                * Aqui se debe actualizar la tabla sganims cuando se realiza el parto
                */
                $partoRegistro = DB::table('sganims')
                    ->where('id_finca','=', $id_finca)
                    ->where('id','=',$id_serie)
                    ->update(['nparto'=>$countparto,
                              'fecup'=>$fultParto,
                              'tipo'=>$nuevaTipologiaName,
                              'id_tipologia'=>$idTipologiaNueva,
                              'tipoanterior'=>$tipoAnterior,
                              #Actualizamos los parametros tipologicos.
                              'prenada'=>$prenhada,
                              'tienecria'=>$tienecria,
                              'criaviva'=>$criaViva,
                              'ordenho'=>$ordeNho,
                              'detectacelo'=>$detectaCelo]);
                /*
                * Sacamos la Tipologia inicial
                */  
                $tipoPartoNuevo = DB::table('sgtipologias')
                  ->where('sexo','=',$request->sexocria1)
                  ->where('edad','=',0)
                  ->where('peso','<=',$request->pesoicria1)
                  ->get();

                foreach ($tipoPartoNuevo as $key) {
                    $nombreTipo = $key->nombre_tipologia;
                    $idTipo = $key->id_tipologia;
                    $destetado = $key->destetado;
                    #Sacamos los parametros tipologicos.
                    $nroMonta = $key->nro_monta;
                    $prenada = $key->prenada; 
                    $parida = $key->parida; 
                    $tieneCria = $key->tienecria; 
                    $criaViva = $key->criaviva;
                    $ordenho = $key->ordenho;
                    $detectaCelo = $key->detectacelo;   
                }
                /*
                * Sacamos la Raza
                */   
                $razaPartoNuevo = DB::table('sgrazas')
                    ->where('nombreraza','=',$request->razacria1)
                    ->get();
                    foreach ($razaPartoNuevo as $key) {
                        $idraza = $key->idraza;     
                    }

                $condPartoNuevo = DB::table('sgcondicioncorporals')
                ->where('nombre_condicion','=',$request->condicorpocria1)
                ->get();    

                foreach ($condPartoNuevo as $key ) {
                    $idcondicion = $key->id_condicion;      
                }   
                /*
                * Por ultimo Creamos la Ficha de Ganado para la nueva Cría
                */            
                $nuevaSerieParto = new \App\Models\sganim;

                $nuevaSerieParto->serie = $request->seriecria1;
                $nuevaSerieParto->sexo = $request->sexocria1;
                $nuevaSerieParto->nombrelote = $series->nombrelote;
                $nuevaSerieParto->codmadre = $series->serie; # Es la Serie que pario
                $nuevaSerieParto->codpadre = $codpadre;
                $nuevaSerieParto->espajuela = $espajuela; #voy a verificarlo
                $nuevaSerieParto->pajuela = $codpadre;
                $nuevaSerieParto->fnac = $request->fnac;
                $nuevaSerieParto->motivo = null; #Lo voy a Sacar
                $nuevaSerieParto->status = 1; #Activo
                $nuevaSerieParto->tipo = $nombreTipo;
                $nuevaSerieParto->color_pelaje = $request->colorpelaje; 
                $nuevaSerieParto->observa = $request->observa;
                $nuevaSerieParto->procede = $finca->nombre;
                $nuevaSerieParto->pesoi = $request->pesoicria1;
                $nuevaSerieParto->destatado = $destetado;
                $nuevaSerieParto->edad = "0-0"; #hardcode.
                $nuevaSerieParto->id_tipologia = $idTipo;
                $nuevaSerieParto->idraza = $idraza;
                $nuevaSerieParto->id_condicion = $idcondicion;
                $nuevaSerieParto->lnaci = $series->nombrelote;
                
                #Sacamos los parametros tipologicos.
                $nuevaSerieParto->nro_monta = $nroMonta;
                $nuevaSerieParto->prenada = $prenada; 
                $nuevaSerieParto->parida = $parida; 
                $nuevaSerieParto->tienecria = $tieneCria; 
                $nuevaSerieParto->criaviva = $criaViva;
                $nuevaSerieParto->ordenho = $ordenho;
                $nuevaSerieParto->detectacelo = $detectaCelo;

                $nuevaSerieParto->id_finca = $id_finca;

                $nuevaSerieParto->save();
                /*
                * Actualizamos para la cria 2.
                */
                /*
                * Sacamos la Tipologia inicial
                */  
                $tipoPartoNuevo2 = DB::table('sgtipologias')
                    ->where('sexo','=',$request->sexocria2)
                    ->where('edad','=',0)
                    ->where('peso','<=',$request->pesoicria2)
                ->get();

                foreach ($tipoPartoNuevo2 as $key) {
                  $nombreTipo2 = $key->nombre_tipologia;
                  $idTipo2 = $key->id_tipologia;
                  $destetado2 = $key->destetado;
                  #Sacamos los parametros tipologicos.
                  $nroMonta2 = $key->nro_monta;
                  $prenada2 = $key->prenada; 
                  $parida2 = $key->parida; 
                  $tieneCria2 = $key->tienecria; 
                  $criaViva2 = $key->criaviva;
                  $ordenho2 = $key->ordenho;
                  $detectaCelo2 = $key->detectacelo;
                }
                /*
                * Sacamos la Raza
                */   
                $razaPartoNuevo2 = DB::table('sgrazas')
                      ->where('nombreraza','=',$request->razacria2)
                      ->get();
                foreach ($razaPartoNuevo2 as $key) {
                    $idraza2 = $key->idraza;     
                }

                $condPartoNuevo2 = DB::table('sgcondicioncorporals')
                      ->where('nombre_condicion','=',$request->condicorpocria2)
                      ->get();    

                foreach ($condPartoNuevo2 as $key ) {
                    $idcondicion2 = $key->id_condicion;      
                }   
                /*
                * Por ultimo Creamos la Ficha de Ganado para la nueva Cría 2
                */            
                $nuevaSerieParto2 = new \App\Models\sganim;

                $nuevaSerieParto2->serie = $request->seriecria2;
                $nuevaSerieParto2->sexo = $request->sexocria2;
                $nuevaSerieParto2->nombrelote = $series->nombrelote;
                $nuevaSerieParto2->codmadre = $series->serie; # Es la Serie que pario
                $nuevaSerieParto2->codpadre = $codpadre;
                $nuevaSerieParto2->espajuela = $espajuela; #voy a verificarlo
                $nuevaSerieParto2->pajuela = $codpadre;
                $nuevaSerieParto2->fnac = $request->fnac;
                $nuevaSerieParto2->motivo = null; #Lo voy a Sacar
                $nuevaSerieParto2->status = 1; #Activo
                $nuevaSerieParto2->tipo = $nombreTipo;
                $nuevaSerieParto2->color_pelaje = $request->colorpelaje1; 
                $nuevaSerieParto2->observa = $request->observa2;
                $nuevaSerieParto2->procede = $finca->nombre;
                $nuevaSerieParto2->pesoi = $request->pesoicria2;
                $nuevaSerieParto2->destatado = $destetado2;
                $nuevaSerieParto2->edad = "0-0"; #hardcode.
                $nuevaSerieParto2->id_tipologia = $idTipo2;
                $nuevaSerieParto2->idraza = $idraza2;
                $nuevaSerieParto2->id_condicion = $idcondicion2;
                $nuevaSerieParto2->lnaci = $series->nombrelote;
                #Sacamos los parametros tipologicos.
                $nuevaSerieParto->nro_monta = $nroMonta2;
                $nuevaSerieParto->prenada = $prenada2; 
                $nuevaSerieParto->parida = $parida2; 
                $nuevaSerieParto->tienecria = $tieneCria2; 
                $nuevaSerieParto->criaviva = $criaViva2;
                $nuevaSerieParto->ordenho = $ordenho2;
                $nuevaSerieParto->detectacelo = $detectaCelo2;

                $nuevaSerieParto2->id_finca = $id_finca;

                $nuevaSerieParto2->save();

    } //Fin

    /*
    * Aquí cuando hay parto morochos naci vivo la primera Cría y la segunda muerta
    */
    if ( ($request->tipoparto=="on") and ($request->condicionnac1==1) and  ($request->condicionnac2==0) ) 
    {
    		#Cría 1 Vivo Cría 2 Muerto

          $request->validate([
            'seriecria1'=> [
                'required',
             //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
            'razacria1'=> [
                'required',
            ],
            'pesoicria1'=> [
                'required',
            ],
            'lotecria1'=> [
                'required',
            ],
            'condicorpocria1'=> [
                'required',
            ],
            'fnac'=> [
                'required',
            ],
            'fnacmuerte2'=> [
                'required',
            ],
            'muerterazacria2'=> [
                'required',
            ],
            'causamuerte2'=> [
                'required',
            ],
        ]);
      	# Aquí colocamos la Marca Vi para clasificar que ha nacido vivo y Mu que
      	# ha nacido muerto
      	$marca = "Vi"; 	 // hardcod
      	$marca2 = "Mu"; 	 // hardcod
      	/*
      	* es importante buscar la tipología actual que es la misma que tiene
      	*antes del parto
      	*/
      	$tipoActual = $series->tipo;
      	/*
      	* 2-> Guardamos en la tabla de partos los registros del form. 
      	*/	 
      	$caso = "Parto Morocho"; //hardcod
        $casoM = "Parto Morocho. Nac. Muerto"; //hardcoe

        $partoNuevo = new \App\Models\sgparto;

        $partoNuevo->id_serie = $id_serie;
        $partoNuevo->serie = $request->serie;
        $partoNuevo->tipo = null;
        $partoNuevo->estado = $request->condicorpo;
        $partoNuevo->edad = $request->edad;
        $partoNuevo->tipoap = $tipoActual = $series->tipo;
        $partoNuevo->fecup = $request->fecup;

		    # Comienza los datos de la Cría 1 #
        $partoNuevo->fecpar = $request->fnac;
        $partoNuevo->sexo = $request->sexocria1;
        $partoNuevo->becer = $request->seriecria1;
        $partoNuevo->lotebecerro = $request->lotecria1;
        $partoNuevo->obspar = $request->observa;
        $partoNuevo->edobece = $request->condicorpocria1;
        $partoNuevo->razabe = $request->razacria1;
        $partoNuevo->pesoib = $request->pesoicria1;
    		//$partoNuevo->ientpar = $request->ier;
        $partoNuevo->marcabec1 = $marca;
        $partoNuevo->color_pelaje = $request->colorpelaje;

		    # Comienza los datos de la Cría 2 #

        $partoNuevo->causanm1 = $request->causamuerte2;
        $partoNuevo->obsernm1 = $request->observamuerte2;
        $partoNuevo->marcabec2 = $marca2;

        $partoNuevo->id_ciclo = $id_ciclo;
        $partoNuevo->id_finca = $id_finca;

        try{

            $partoNuevo-> save();
            #Se Cambian los parametros tipologicos para cambio e tipologia
            $pario = 1;  
            $tienesucria = 1;
            $crianacioviva = 1; 
            $prenez = 0;    
        }catch (\Illuminate\Database\QueryException $e){
            #Se devuelven los cambios en caso de haber un error.
            $pario = 0;  
            $tienesucria = 0;
            $crianacioviva = 0; 
            $prenez = 1;
            return back()->with('mensaje', 'error');
        } 	

        $countparto =  DB::table('sgpartos')
            ->where('fecpar','=',$request->fnac)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

        $nroparto = DB::table('sghistoricotemprepros')
                ->where('fecharegistro','=',$request->fnac)
                ->where('id_finca','=', $id_finca)
                ->where('id_ciclo','=', $id_ciclo)
                ->update(['nropart'=>$countparto]); 
        /*
        * Aqui actualizamos la Tipologia en caso de una preñez
        * ya que es un proceso que conlleva a eso.
        */
        #Buscamos la tipologia actual 
        $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
        #Obtenemos todos parametros de la tipologia
        foreach ($tipoActual as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $edad = $key->edad;
            $peso = $key->peso;
            $destetado = $key->destetado;
            $sexo = $key->sexo;
            $nro_monta = $key->nro_monta;
            $prenada = $key->prenada;
            $parida = $key->parida;
            $tienecria = $key->tienecria;
            $criaviva = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
            $idtipo = $key->id_tipologia;
        }
        #Actualizamos la tipologia
        #Obtenemos la tipologia anterior
        $tipoAnterior = $tipologiaName;
        $nroMonta = $series->nro_monta;

        # Actualizamos si se efectua el parto.
        $tipologia= DB::table('sgtipologias')
                ->where('edad','=',$edad)
                ->where('peso','=',$peso)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$sexo)
                ->where('nro_monta','=',$nroMonta) //Revisar aqui
                ->where('prenada','=',$prenez)
                ->where('parida','=',$pario)
                ->where('tienecria','=',$tienesucria)
                ->where('criaviva','=',$crianacioviva)
                ->where('ordenho','=',$ordenho)
                ->where('detectacelo','=',$detectacelo)
                ->where('id_finca','=',$id_finca)
                ->get();
                    
        foreach ($tipologia as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $idtipo = $key->id_tipologia;
            $prenada =$key->prenada;
            $tcria = $key->tienecria;
            $criav = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
        }   

        $idTipologiaNueva = $idtipo;
        $nuevaTipologiaName = $tipologiaName;
        $prenhada = $prenada;
        $tienecria = $tcria;
        $criaViva = $criav;
        $ordeNho = $ordenho;
        $detectaCelo = $detectacelo;
        /*
        * Actualizamos el campo tipo con la tipologia final
        */
        $tipologiaParto= DB::table('sgpartos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)            
                ->update(['tipo'=>$nuevaTipologiaName]);        
        /*
        * Buscamos la fecha del perimer servicio
        */          
        $servicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpserv'))
                ->where('id_serie','=',$id_serie)
                ->where('id_finca','=',$id_finca)
                ->get();
        /*
        * Si tenemos registros buscamos la fecha del primer servicio
        */  
        if ($servicio->count()>0) {
            #Si existe el servicio buscamo la fecha del primer servicio.
            foreach ($servicio as $key) {
                $fechaPrimerServicio = $key->fpserv;    
            }
        } else {
            $fechaPrimerServicio = null; 
        }
        # Con la fecha del primer servicio buscamo la tipologia primer servicio
        $tipoPrimerServicio = DB::table('sgservs')
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=',$fechaPrimerServicio)
                ->where('id_finca','=',$id_finca)
                ->get();

        if ($tipoPrimerServicio->count()>0) {
            #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
            foreach ($tipoPrimerServicio as $key) {
                $id_tipologia = $key->id_tipologia;
                $pesops = $key->peso;   
            }
            # Con id ubicamos la Tipoloiga en la tabla
            $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
            #Obtenemos el Nombre de la Tipologia    
            $tipops= $tipologia->nombre_tipologia;
            #Obtenemos el peso que tiene la serie en el primer servicio
            $pesops = $pesops; 

        } else {
            $tipops= null; //No existe
            $pesops = null; //no existe
        } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
                
        # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
        $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
                ->select(DB::raw('MIN(fecser) as fespr'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('toropaj','<>',null)
                ->orWhere('torotemp','<>',null)
                ->get();  

        # Comprobamos si existe el servicio que generó la preñez    
        if ( $servicioPrimerPrenez->count()>0) {
            #Si existe, obtenemos fecha de primer servicio 
            foreach ($servicioPrimerPrenez as $key) {
                $fechasPr = $key->fespr; 
            }
        } else {
            $fechasPr = null; 
        }           
        /*
        Con la fechasPr creamos una consulta para verificar 
        si se trata de una preñez por toropajuela o torotempt 
        */
        $prenezHistorico = DB::table('sgprenhez_historicos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecser','=',$fechasPr)
                ->get();  
        # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
        if ($prenezHistorico->count()>0) {
            foreach ($prenezHistorico as $key) {
                $toropaj = $key->toropaj;
                $nomi = $key->nomi;
                $torotemp = $key->torotemp; 
            }
        } else {
            $toropaj = null;
            $nomi = null;
            $torotemp = null;
        }
        #Con los valores anteriores identificamos la pajuela
        $pajuela = DB::table('sgpajus')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$toropaj)
                ->get();
        # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
        if ($pajuela->count()>0) {
            #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
            $espajuela = 1; 
            foreach ($pajuela as $key) {
                $idpaju = $key->id;
                $razapaju = $key->nombreraza;
                $fechanac = $key->fnac;
                $nombrepa = $key->nomb; 
            }
            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
        } else {
            #Si no existe la pajuela, sus valores pasan a null.
            $idpaju = null;
            $razapaju = null;
            $fechanac = null;
            $nombrepa = null;

            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
            #Como la pajuela no existe entonces marcamos a falso 
            $espajuela = 0; 
        }
        # Ubicamos si es Toro en caso de existir la Preñez Historico                
        $toro = DB::table('sganims')
          ->where('id_finca','=',$id_finca)
          ->where('serie','=',$torotemp)
          ->get();
        # Verificamos que el $torotemp exista
        if ($toro->count()>0) {
            #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
            $espajuela = 0; 
            foreach ($toro as $key) {
                $razatoro = $key->idraza;
                $idtipo = $key->id_tipologia;
                $fecnacPadre = $key->fnac;
            }
            $raza = \App\Models\sgraza::findOrFail($razatoro);
            $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
            
            $razapadre = $raza->nombreraza;
            $tipopadre = $tipotoro->nombre_tipologia;
            $fechanacpadre = $fecnacPadre;
            $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

        } else {
            #Si no existe el Toro, entonces se asume que fue una monta natural  
            $razapadre = null;
            $tipopadre = null;
            $fechanacpadre = null;
            $nombrepadre = null;
        }
        #Actualizamos las variables si proviene de Pajuela o Toro.
        $fechasPr = $fechasPr; 
        $codtpajuela = $toropaj;
        $nomi = $nomi;
        $torotemporada = $torotemp;

        $razapadre = $razapadre;
        $tipopadre = $tipopadre;
        $fechanacpadre = $fechanacpadre;
        $nombrepadre = $nombrepadre;
        #Se pasa a falso ya que fue por Monta natural
        $espajuela =$espajuela ; 
        /*
        * Ubicamos el primer servicio
        */
        $primerServicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
        /*
        * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
        */
        if ( $primerServicio->count()>0 ) {
            foreach ($primerServicio as $key) {
                $fecha = $key->fpservicio;
            }
        } else {
            # No tiene servicio creado
            $fecha=null; //no existe;
        }
        # Ubicamosla Edad primer servicio
        $edadPrimerServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fecha)
                ->get();        

        if ($edadPrimerServicio->count()>0) {
            foreach ($edadPrimerServicio as $key ) {
                $edadPservicio = $key->edad;
            }
        } else {
            $edadPservicio = null; //es decir no existe 
        }
        /*
        * Ubicamos la fecha del Primer parto
        */  
        $fechaPrimerParto = DB::table('sgpartos')
                ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
        if ($fechaPrimerParto->count()>0) {
            foreach ($fechaPrimerParto as $key) {
                $fpParto = $key->fprimerParto; 
            }               
        } else {
            $fpParto=null; // no existe
        }                        
        /*
        * La edad del primer Parto
        */
        $edadPrimerParto = DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fpParto)
                ->get();

        if ($edadPrimerParto->count()>0) {
            foreach ($edadPrimerParto as $key ) {
                $edadPp = $key->edad; 
            }
        } else {
            $edadPp=null; 
        }
        /*
        * Ubicamos El numero de celos por la temporada de monta
        */
        $celos = DB::table('sgcelos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get();

        $nroCelos = $celos->count();    
        /*
        * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
        */
        $fechaPrimerCelo = DB::table('sgcelos')
                ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
        if ( $fechaPrimerCelo->count()>0) {

          foreach ($fechaPrimerCelo as $key) {
              $fPrimerCelo = $key->fecPrimerCelo;
          }

            $fpCelo = $fPrimerCelo;

            //*************************************************
                //Se calcula con la herramienta carbon la edad
            $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
            $dt = $year*12;
                //se restan los meses para obtener los meses transcurridos. 
            $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                // se pasa a la variable edad, para guardar junto a la información que proviene del form.
            $edadpc = $year."-".$months;
            //*************************************************                     
        } else {
            $fpCelo = null; 
            $edadpc = null; // no exsite;
        }
        
        $fechaUltimoCelo = DB::table('sgcelos')
                ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
        /*
        * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
        */
        if ( $fechaUltimoCelo->count()>0 ) {

            foreach ($fechaUltimoCelo as $key) {
                $fuCelo = $key->fecUltimoCelo;
            }
            $fuc = $fuCelo;
        } else {
            $fuc = null;
        }   
        /*
        * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
        */
        $ultimoCelo = DB::table('sgcelos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->where('fechr','=',$fuc)
                ->get(); 
        if ( ($ultimoCelo->count()>0) ) {
            foreach ($ultimoCelo as $key ) {
                $ientcel = $key->dias; 
            }   
            $ientcelos = $ientcel;

        } else {
            $ientcelos= null; 
        }   
        /*
        * Ubicamos el ultimo servicio
        */
        $ultServicio = DB::table('sgservs')
                ->select(DB::raw('MAX(fecha) as fultservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
        if ($ultServicio->count()>0) {
            foreach ($ultServicio as $key) {
                $fUltserv = $key->fultservicio;
            }
        } else {
            # No tiene servicio creado
            $fUltserv = null; //es decir no existe 
        }
        # Ubicamosla iserv del ultimo servicio
        $intServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fUltserv)
                ->get();        
        if ($intServicio->count()>0 ) {
            foreach ($intServicio as $key ) {
                $intEntreServ = $key->iers; 
            }   
        } else {
            $intEntreServ=null; //no existe.
        }
        /*
        * Buscamo la preñez actual para saber el tiempo de secado
        */  
        $prenezActual = DB::table('sgprenhezs')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
        if ($prenezActual->count()>0) {

            foreach ($prenezActual as $key ) {
                # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                $fechaAproxSecado = $key->fecas; 
            }   
        } else {
            $fechaAproxSecado = null; 
        }
        /*
        * Fecha del ultimo parto
        */
        $fechaUltimoParto = DB::table('sgpartos')
                ->select(DB::raw('MAX(fecpar) as fultParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();  
        if ($fechaUltimoParto->count()>0 ) {

            foreach ($fechaUltimoParto as $key) {
                $fultParto = $key->fultParto; 
            }   
        } else {
            $fultParto=null; //No existe
        }
        
        $intervaloEntreParto =  DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fultParto)
                ->get();                        
        if ($intervaloEntreParto->count()>0) {
            foreach ($intervaloEntreParto as $key) {
                $intentpart = $key->ientpar; 
            }
        } else {
          $intentpart = null; //ya que no existe;
        }
        /*
        * Con esto calculamos los valores IPARPC e IPARPS
        */
        if ( ($intentpart>0) and !($fpCelo==null)  ) {
            # si el Intervalo entre parto existe.
            $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
            $iparpc = $intentpart - $difdias;
        } else {
            # De lo contrario
            $iparpc = null; // Es decir no existe 
        }
                
        /********************************************************/
                
        # Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
        $sghprodNuevo = new \App\Models\sghprenhez;

        $sghprodNuevo->id_serie = $id_serie;
        $sghprodNuevo->serie = $series->serie;
        $sghprodNuevo->tipo = $tipoAnterior;

        #Condicion de la madres
        $sghprodNuevo->estado = $condicion->nombre_condicion;
        $sghprodNuevo->raza = $raza->nombreraza;
        $sghprodNuevo->idraza = $raza->idraza;
        
        $sghprodNuevo->edad = $request->edad;
        $sghprodNuevo->nservi = $series->nservi;
        $sghprodNuevo->tipops = $tipops;
        $sghprodNuevo->pesps = $pesops;
        $sghprodNuevo->fecps = $fechaPrimerServicio;
        $sghprodNuevo->edadps = $edadPservicio;

        $sghprodNuevo->fecspr = $fechasPr;
        $sghprodNuevo->codtp = $codtpajuela;
        $sghprodNuevo->respi = $nomi;
        $sghprodNuevo->torotemp = $torotemporada;

        $sghprodNuevo->tipoap = $series->tipoanterior;
        $sghprodNuevo->fecup = $fultParto;
        $sghprodNuevo->edadpp = $edadPp;
        $sghprodNuevo->fecpar = $request->fnac; //La fecha en que nace la cria
        /*
        * Datos del animal cría 1
        */
        $sghprodNuevo->sexo = $request->sexocria1;
        $sghprodNuevo->becer = $request->seriecria1;
        $sghprodNuevo->obspar = $request->observa;
        $sghprodNuevo->edobece = $request->condicorpocria1;
        $sghprodNuevo->razabe = $request->razacria1;
        $sghprodNuevo->pesoib = $request->pesoicria1;
       // $sghprodNuevo->ientpar = $request->ier;
        $sghprodNuevo->marcabec1 = $marca;
        /*
        * Datos del animal cria 2
        */
        $sghprodNuevo->obsernm = $request->observamuerte2;
        $sghprodNuevo->causanm = $request->causamuerte2;
        //$sghprodNuevo->razabe = $request->razacria2;
        $sghprodNuevo->marcabec2 = $marca2;
                
        #Verificamos si viene el padre es pajuela o torotemporada.
        if (!$codtpajuela==null) {
            $codpadre = $codtpajuela;
        } else {
            $codpadre = $torotemporada;
        }
        if (($codtpajuela==null) and ($torotemporada==null)) {
            $codpadre = null; //Se desconoce el valor del codigo del padre; 
        }
        $sghprodNuevo->codp = $codpadre;
        $sghprodNuevo->razapadre = $razapadre;
        $sghprodNuevo->nombrepadre = $nombrepadre;
        $sghprodNuevo->tipopadre = $tipopadre;
        $sghprodNuevo->fechanacpadre = $fechanacpadre;
        
        $sghprodNuevo->espajuela = $espajuela;

        $sghprodNuevo->fecas = $fechaAproxSecado;

        $sghprodNuevo->ncelos = $nroCelos;
        $sghprodNuevo->fecpc = $fpCelo;
        $sghprodNuevo->edadpc = $edadpc;
        $sghprodNuevo->fecuc = $fuc;

        $sghprodNuevo->ientcel = $ientcelos;
        $sghprodNuevo->iserv = $intEntreServ;
        $sghprodNuevo->ientpar = $intentpart; 

        $sghprodNuevo->iparps = $iparpc;
        $sghprodNuevo->iparpc = $iparpc; 

        $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
        $sghprodNuevo->nciclo = $id_ciclo;
        $sghprodNuevo->id_finca = $id_finca;

        $sghprodNuevo->save(); 

        /* ----------------------------------------------------------
        *  Fin de Actualización Tabla de sghprenez = sghprod
        -----------------------------------------------------------*/       
        $fecsistema = Carbon::now(); 
        /*
        * Se actualiza la tabla mv1 manejo de vientre Cría 1 Viva
        */
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        $mv1Nuevo->serie_hijo = $request->seriecria1;
        $mv1Nuevo->codpadre =   $codpadre;

        # Como se trata de un parto nuevo vivo, la tipologia viene  calcualda asi
        $tipologiaPartoNuevo = DB::table('sgtipologias')
            ->where('edad','=', 0) //hadcode, ya que es un animal que no tiene edad
            ->where('sexo','=',$request->sexocria1)
            ->where('peso','<=',$request->pesoicria1)
            ->where('destetado','=',0) //hadcode, Animal no destetado
            ->get();

        foreach ($tipologiaPartoNuevo as $key) {
               $idtipoPartNuevo = $key->id_tipologia;
               $nombreTipo = $key->nombre_tipologia;
               $destetado = $key->destetado;
               #Sacamos los parametros tipologicos.
               $nroMonta = $key->nro_monta;
               $prenada = $key->prenada; 
               $parida = $key->parida; 
               $tieneCria = $key->tienecria; 
               $criaViva = $key->criaviva;
               $ordenho = $key->ordenho;
               $detectaCelo = $key->detectacelo; 
        }

       $mv1Nuevo->tipologia = $nombreTipo;
       $mv1Nuevo->id_tipo = $idtipoPartNuevo;

       $mv1Nuevo->caso = $caso;
       $mv1Nuevo->fecha = $request->fnac;
       $mv1Nuevo->fecs = $fecsistema;

       $mv1Nuevo->id_finca = $id_finca;

       $mv1Nuevo->save();

      # Segunda Cria muerta mv1
      # Se actualiza la tabla mv1 manejo de vientre para cría muerta                 
      $mv1Nuevo = new \App\Models\sgmv1;
      
      $mv1Nuevo->codmadre = $request->serie;

      $mv1Nuevo->caso = $casoM;
      $mv1Nuevo->fecha = $request->fnacmuerte2;
      $mv1Nuevo->fecs = $fecsistema;

      $mv1Nuevo->id_finca = $id_finca;

      $mv1Nuevo->save();

      /*
      * Aqui Actualizamos la tabla datos de Vida Solo faltaria sacar las 
      */
      $datosDeVidaNuevo = new \App\Models\sgdatosvida;

      $datosDeVidaNuevo->seriem = $series->serie;
      $datosDeVidaNuevo->fecha = $request->fnac;
      $datosDeVidaNuevo->caso = $caso;
      $datosDeVidaNuevo->nservicios = $series->nservi;
      $datosDeVidaNuevo->pesps = $pesops;
      $datosDeVidaNuevo->edadps = $edadPservicio;
      $datosDeVidaNuevo->codp = $codpadre;
      $datosDeVidaNuevo->edadpp = $edadPp;

      $datosDeVidaNuevo->serieh = $request->seriecria1;
      $datosDeVidaNuevo->pespih = $request->pesoicria1;

      $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
      
      $datosDeVidaNuevo->diapr = $retVal;
      $datosDeVidaNuevo->ncelos = $nroCelos;
      $datosDeVidaNuevo->edadpc = $edadpc;

      $datosDeVidaNuevo->fecas = $fechaAproxSecado;

      $datosDeVidaNuevo->ientpar = $intentpart; 
      $datosDeVidaNuevo->ientcel = $ientcelos;
      $datosDeVidaNuevo->iserv = $intEntreServ;
      $datosDeVidaNuevo->iee = $intentpart;

      $datosDeVidaNuevo->id_finca = $id_finca;

      $datosDeVidaNuevo->save();
      /*
      * Actualizamos nuevamente la tabla Datos de Vida para la cria 2
      */
      $datosDeVidaNuevo2 = new \App\Models\sgdatosvida;

      $datosDeVidaNuevo2->seriem = $series->serie;
      $datosDeVidaNuevo2->fecha = $request->fnacmuerte2;
      $datosDeVidaNuevo2->caso = $casoM;
      $datosDeVidaNuevo2->nservicios = $series->nservi;
      $datosDeVidaNuevo2->pesps = $pesops;
      $datosDeVidaNuevo2->edadps = $edadPservicio;
      $datosDeVidaNuevo2->codp = $codpadre;
      $datosDeVidaNuevo2->edadpp = $edadPp;

      $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
                
      $datosDeVidaNuevo2->diapr = $retVal;
      $datosDeVidaNuevo2->ncelos = $nroCelos;
      $datosDeVidaNuevo2->edadpc = $edadpc;

      $datosDeVidaNuevo2->fecas = $fechaAproxSecado;

      $datosDeVidaNuevo2->ientpar = $intentpart; 
      $datosDeVidaNuevo2->ientcel = $ientcelos;
      $datosDeVidaNuevo2->iserv = $intEntreServ;
      $datosDeVidaNuevo2->iee = $intentpart;

      $datosDeVidaNuevo2->id_finca = $id_finca;

      $datosDeVidaNuevo2->save();
      /*
      * Aqui se debe actualizar la tabla sganims cuando se realiza el parto
      */
      $partoRegistro = DB::table('sganims')
                ->where('id_finca','=', $id_finca)
                ->where('id','=',$id_serie)
                ->update(['nparto'=>$countparto,
                  'fecup'=>$fultParto,
                  'tipo'=>$nuevaTipologiaName,
                  'id_tipologia'=>$idTipologiaNueva,
                  'tipoanterior'=>$tipoAnterior,
                   #Actualizamos los parametros tipologicos.
                  'prenada'=>$prenhada,
                  'tienecria'=>$tienecria,
                  'criaviva'=>$criaViva,
                  'ordenho'=>$ordeNho,
                  'detectacelo'=>$detectaCelo]);
      /*
      * Sacamos la Tipologia inicial
      */  
      $tipoPartoNuevo = DB::table('sgtipologias')
                ->where('sexo','=',$request->sexocria1)
                ->where('edad','=',0)
                ->where('peso','<=',$request->pesoicria1)
                ->get();

      foreach ($tipoPartoNuevo as $key) {
        $nombreTipo = $key->nombre_tipologia;
        $idTipo = $key->id_tipologia;
        $destetado = $key->destetado;
        #Sacamos los parametros tipologicos.
        $nroMonta = $key->nro_monta;
        $prenada = $key->prenada; 
        $parida = $key->parida; 
        $tieneCria = $key->tienecria; 
        $criaViva = $key->criaviva;
        $ordenho = $key->ordenho;
        $detectaCelo = $key->detectacelo;
      }
      /*
      * Sacamos la Raza
      */   
      $razaPartoNuevo = DB::table('sgrazas')
                ->where('nombreraza','=',$request->razacria1)
                ->get();
      foreach ($razaPartoNuevo as $key) {
          $idraza = $key->idraza;     
      }

      $condPartoNuevo = DB::table('sgcondicioncorporals')
                ->where('nombre_condicion','=',$request->condicorpocria1)
                ->get();    

      foreach ($condPartoNuevo as $key ) {
          $idcondicion = $key->id_condicion;      
      }   
      /*
      * Por ultimo Creamos la Ficha de Ganado para la nueva Cría 1 Viva
      */            
      $nuevaSerieParto = new \App\Models\sganim;

      $nuevaSerieParto->serie = $request->seriecria1;
      $nuevaSerieParto->sexo = $request->sexocria1;
      $nuevaSerieParto->nombrelote = $series->nombrelote;
      $nuevaSerieParto->codmadre = $series->serie; # Es la Serie que pario
      $nuevaSerieParto->codpadre = $codpadre;
      $nuevaSerieParto->espajuela = $espajuela; #voy a verificarlo
      $nuevaSerieParto->pajuela = $codpadre;
      $nuevaSerieParto->fnac = $request->fnac;
      $nuevaSerieParto->motivo = null; #Lo voy a Sacar
      $nuevaSerieParto->status = 1; #Activo
      $nuevaSerieParto->tipo = $nombreTipo;
      $nuevaSerieParto->color_pelaje = $request->colorpelaje; 
      $nuevaSerieParto->observa = $request->observa;
      $nuevaSerieParto->procede = $finca->nombre;
      $nuevaSerieParto->pesoi = $request->pesoicria1;
      $nuevaSerieParto->destatado = $destetado;
      $nuevaSerieParto->edad = "0-0"; #hardcode.
      $nuevaSerieParto->id_tipologia = $idTipo;
      $nuevaSerieParto->idraza = $idraza;
      $nuevaSerieParto->id_condicion = $idcondicion;
      $nuevaSerieParto->lnaci = $series->nombrelote;
      $nuevaSerieParto->nro_monta = $nroMonta;
      $nuevaSerieParto->prenada = $prenada; 
      $nuevaSerieParto->parida = $parida; 
      $nuevaSerieParto->tienecria = $tieneCria;
      $nuevaSerieParto->criaviva = $criaViva;
      $nuevaSerieParto->ordenho =  $ordenho;
      $nuevaSerieParto->detectacelo = $detectaCelo;  
      $nuevaSerieParto->id_finca = $id_finca;

      $nuevaSerieParto->save();               
  }
            
  /*
  * Parto Morocho nace muerto la primera Cría y la segunda viva.
  */
  if ( ($request->tipoparto=="on") and ($request->condicionnac1==0) and ($request->condicionnac2==1) ) 
    {
		# Validamos los campos que utilizaremos
		#Cría 1 muerto y Cría 2 vivo	
    $request->validate([
        'seriecria2'=> [
            'required',
         //       'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
        ],
        'razacria2'=> [
            'required',
        ],
        'pesoicria2'=> [
            'required',
        ],
        'lotecria2'=> [
            'required',
        ],
        'condicorpocria2'=> [
            'required',
        ],
        'fnac2'=> [
            'required',
        ],
        'fnacmuerte'=> [
            'required',
        ],
        'muerterazacria1'=> [
            'required',
        ],
        'causamuerte1'=> [
            'required',
        ],
    ]);
  	# Aquí colocamos la Marca Vi para clasificar que ha nacido vivo y Mu que
  	# ha nacido muerto
  	$marca = "Vi"; 	 // hardcod
  	$marca2 = "Mu"; 	 // hardcod
  	/*
  	* es importante buscar la tipología actual que es la misma que tiene
  	*antes del parto
  	*/
  	$tipoActual = $series->tipo;

  	/*
  	* 2-> Guardamos en la tabla de partos los registros del form. 
  	*/	 
  	$caso = "Parto Morocho Vivo"; //hardcod
    $casoM = "Parto Morocho Nac. Muerto"; //hardcod

    $partoNuevo = new \App\Models\sgparto;

    $partoNuevo->id_serie = $id_serie;
    $partoNuevo->serie = $request->serie;
    $partoNuevo->tipo = null;
    $partoNuevo->estado = $request->condicorpo;
    $partoNuevo->edad = $request->edad;
    $partoNuevo->tipoap = $tipoActual = $series->tipo;
    $partoNuevo->fecup = $request->fecup;

    # Comienza los datos de la Cría 2 #
    $partoNuevo->fecpar = $request->fnac2;
    $partoNuevo->sexo1 = $request->sexocria2;
    $partoNuevo->becer1 = $request->seriecria2;
    $partoNuevo->lotebecerro1 = $request->lotecria2;
    $partoNuevo->obspar1 = $request->observa2;
    $partoNuevo->edobece1 = $request->condicorpocria2;
    $partoNuevo->razabe = $request->razacria2;
    $partoNuevo->pesoib1 = $request->pesoicria2;
    $partoNuevo->ientpar = $request->ier;
    $partoNuevo->marcabec2 = $marca;
    $partoNuevo->color_pelaje1 = $request->colorpelaje1;

    # Comienza los datos de la Cría 1 #
    $partoNuevo->causanm = $request->causamuerte1;
    $partoNuevo->obsernm = $request->observamuerte1;
    $partoNuevo->marcabec1 = $marca2;

    $partoNuevo->id_ciclo = $id_ciclo;
    $partoNuevo->id_finca = $id_finca;

    try{

        $partoNuevo-> save();
        #Se Cambian los parametros tipologicos para cambio e tipologia
        $pario = 1;  
        $tienesucria = 1;
        $crianacioviva = 1; 
        $prenez = 0;    
    }catch (\Illuminate\Database\QueryException $e){
        #Se devuelven los cambios en caso de haber un error.
        $pario = 0;  
        $tienesucria = 0;
        $crianacioviva = 0; 
        $prenez = 1;
        return back()->with('mensaje', 'error');
    }   

    $countparto =  DB::table('sgpartos')
        ->where('fecpar','=',$request->fnac2)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->count(); 

    $nroparto = DB::table('sghistoricotemprepros')
        ->where('fecharegistro','=',$request->fnac2)
        ->where('id_finca','=', $id_finca)
        ->where('id_ciclo','=', $id_ciclo)
        ->update(['nropart'=>$countparto]); 
    /*
    * Aqui actualizamos la Tipologia en caso de una preñez
    * ya que es un proceso que conlleva a eso.
    */
    #Buscamos la tipologia actual 
    $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
      #Obtenemos todos parametros de la tipologia
      foreach ($tipoActual as $key ) {
          $tipologiaName = $key->nombre_tipologia;
          $edad = $key->edad;
          $peso = $key->peso;
          $destetado = $key->destetado;
          $sexo = $key->sexo;
          $nro_monta = $key->nro_monta;
          $prenada = $key->prenada;
          $parida = $key->parida;
          $tienecria = $key->tienecria;
          $criaviva = $key->criaviva;
          $ordenho = $key->ordenho;
          $detectacelo = $key->detectacelo;
          $idtipo = $key->id_tipologia;
      }
      #Actualizamos la tipologia
      #Obtenemos la tipologia anterior
      $tipoAnterior = $tipologiaName;
      $nroMonta = $series->nro_monta;

      # Actualizamos si se efectua el parto.
      $tipologia= DB::table('sgtipologias')
          ->where('edad','=',$edad)
          ->where('peso','=',$peso)
          ->where('destetado','=',$destetado)
          ->where('sexo','=',$sexo)
          ->where('nro_monta','<=',$nroMonta) //Revisar aqui
          ->where('prenada','=',$prenez)
          ->where('parida','=',$pario)
          ->where('tienecria','=',$tienesucria)
          ->where('criaviva','=',$crianacioviva)
          ->where('ordenho','=',$ordenho)
          ->where('detectacelo','=',$detectacelo)
          ->where('id_finca','=',$id_finca)
          ->get();
      foreach ($tipologia as $key ) {
          $tipologiaName = $key->nombre_tipologia;
          $idtipo = $key->id_tipologia;
          $prenada =$key->prenada;
          $tcria = $key->tienecria;
          $criav = $key->criaviva;
          $ordenho = $key->ordenho;
          $detectacelo = $key->detectacelo;
      }   

      $idTipologiaNueva = $idtipo;
      $nuevaTipologiaName = $tipologiaName;
      $prenhada = $prenada;
      $tienecria = $tcria;
      $criaViva = $criav;
      $ordeNho = $ordenho;
      $detectaCelo = $detectacelo;
      /*
      * Actualizamos el campo tipo con la tipologia final
      */
      $tipologiaParto= DB::table('sgpartos')
            ->where('id_finca','=',$id_finca)
            ->where('id_ciclo','=',$id_ciclo)
            ->where('id_serie','=',$id_serie)            
            ->update(['tipo'=>$nuevaTipologiaName]);        
      /*
      * Buscamos la fecha del perimer servicio
      */          
      $servicio = DB::table('sgservs')
            ->select(DB::raw('MIN(fecha) as fpserv'))
            ->where('id_serie','=',$id_serie)
            ->where('id_finca','=',$id_finca)
            ->get();
      /*
      * Si tenemos registros buscamos la fecha del primer servicio
      */  
      if ($servicio->count()>0) {
          #Si existe el servicio buscamo la fecha del primer servicio.
          foreach ($servicio as $key) {
              $fechaPrimerServicio = $key->fpserv;    
          }
      } else {
          $fechaPrimerServicio = null; 
      }
      # Con la fecha del primer servicio buscamo la tipologia primer servicio
      $tipoPrimerServicio = DB::table('sgservs')
            ->where('id_serie','=',$id_serie)
            ->where('fecha','=',$fechaPrimerServicio)
            ->where('id_finca','=',$id_finca)
            ->get();
                
      if ($tipoPrimerServicio->count()>0) {
          #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
          foreach ($tipoPrimerServicio as $key) {
              $id_tipologia = $key->id_tipologia;
              $pesops = $key->peso;   
          }
          # Con id ubicamos la Tipoloiga en la tabla
          $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
          #Obtenemos el Nombre de la Tipologia    
          $tipops= $tipologia->nombre_tipologia;
          #Obtenemos el peso que tiene la serie en el primer servicio
          $pesops = $pesops; 

      } else {

          $tipops= null; //No existe
          $pesops = null; //no existe
      } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
                
      # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
      $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
          ->select(DB::raw('MIN(fecser) as fespr'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('toropaj','<>',null)
          ->orWhere('torotemp','<>',null)
          ->get();  

      # Comprobamos si existe el servicio que generó la preñez    
      if ( $servicioPrimerPrenez->count()>0) {
          #Si existe, obtenemos fecha de primer servicio 
          foreach ($servicioPrimerPrenez as $key) {
              $fechasPr = $key->fespr; 
          }
      } else {
          $fechasPr = null; 
      }           
      /*
      Con la fechasPr creamos una consulta para verificar 
      si se trata de una preñez por toropajuela o torotempt 
      */
      $prenezHistorico = DB::table('sgprenhez_historicos')
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('fecser','=',$fechasPr)
          ->get();  
      # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
      if ($prenezHistorico->count()>0) {
            foreach ($prenezHistorico as $key) {
                $toropaj = $key->toropaj;
                $nomi = $key->nomi;
                $torotemp = $key->torotemp; 
            }
      } else {
                $toropaj = null;
                $nomi = null;
                $torotemp = null;
      }
      #Con los valores anteriores identificamos la pajuela
      $pajuela = DB::table('sgpajus')
          ->where('id_finca','=',$id_finca)
          ->where('serie','=',$toropaj)
          ->get();

      # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
      if ($pajuela->count()>0) {
          #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
          $espajuela = 1; 
          foreach ($pajuela as $key) {
              $idpaju = $key->id;
              $razapaju = $key->nombreraza;
              $fechanac = $key->fnac;
              $nombrepa = $key->nomb; 
          }
          $nombrepadre = $nombrepa;
          $razapadre = $razapaju;
          $tipopadre = null;
          $fechanacpadre = $fechanac;
      } else {
          #Si no existe la pajuela, sus valores pasan a null.
          $idpaju = null;
          $razapaju = null;
          $fechanac = null;
          $nombrepa = null;

          $nombrepadre = $nombrepa;
          $razapadre = $razapaju;
          $tipopadre = null;
          $fechanacpadre = $fechanac;
          #Como la pajuela no existe entonces marcamos a falso 
          $espajuela = 0; 
      }
      # Ubicamos si es Toro en caso de existir la Preñez Historico                
      $toro = DB::table('sganims')
          ->where('id_finca','=',$id_finca)
          ->where('serie','=',$torotemp)
          ->get();
      # Verificamos que el $torotemp exista
      if ($toro->count()>0) {
          #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
          $espajuela = 0; 
          foreach ($toro as $key) {
              $razatoro = $key->idraza;
              $idtipo = $key->id_tipologia;
              $fecnacPadre = $key->fnac;
          }
          $raza = \App\Models\sgraza::findOrFail($razatoro);
          $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
          
          $razapadre = $raza->nombreraza;
          $tipopadre = $tipotoro->nombre_tipologia;
          $fechanacpadre = $fecnacPadre;
          $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

      } else {
        #Si no existe el Toro, entonces se asume que fue una monta natural  
        $razapadre = null;
        $tipopadre = null;
        $fechanacpadre = null;
        $nombrepadre = null;
                 
      }
        #Actualizamos las variables si proviene de Pajuela o Toro.
        $fechasPr = $fechasPr; 
        $codtpajuela = $toropaj;
        $nomi = $nomi;
        $torotemporada = $torotemp;

        $razapadre = $razapadre;
        $tipopadre = $tipopadre;
        $fechanacpadre = $fechanacpadre;
        $nombrepadre = $nombrepadre;
        #Se pasa a falso ya que fue por Monta natural
        $espajuela = $espajuela;
        /*
        * Ubicamos el primer servicio
        */
        $primerServicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
        /*
        * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
        */
        if ( $primerServicio->count()>0 ) {
            foreach ($primerServicio as $key) {
                $fecha = $key->fpservicio;
            }
        } else {
            # No tiene servicio creado
            $fecha=null; //no existe;
        }
        # Ubicamosla Edad primer servicio
        $edadPrimerServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fecha)
                ->get();        

        if ($edadPrimerServicio->count()>0) {
            foreach ($edadPrimerServicio as $key ) {
                $edadPservicio = $key->edad;
            }
        } else {
           $edadPservicio = null; //es decir no existe 
        }
        /*
        * Ubicamos la fecha del Primer parto
        */  
        $fechaPrimerParto = DB::table('sgpartos')
                ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
        if ($fechaPrimerParto->count()>0) {
            foreach ($fechaPrimerParto as $key) {
                $fpParto = $key->fprimerParto; 
            }               
        } else {
            $fpParto=null; // no existe
        }                        
        /*
        * La edad del primer Parto
        */
        $edadPrimerParto = DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fpParto)
                ->get();

        if ($edadPrimerParto->count()>0) {
            foreach ($edadPrimerParto as $key ) {
                $edadPp = $key->edad; 
            }
        } else {
            $edadPp=null; 
        }
        /*
        * Ubicamos El numero de celos por la temporada de monta
        */
        $celos = DB::table('sgcelos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get();

        $nroCelos = $celos->count();    
        /*
        * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
        */
        $fechaPrimerCelo = DB::table('sgcelos')
                ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
        if ( $fechaPrimerCelo->count()>0) {

            foreach ($fechaPrimerCelo as $key) {
                $fPrimerCelo = $key->fecPrimerCelo;
            }

            $fpCelo = $fPrimerCelo;
            #Se calcula con la herramienta carbon la edad
              $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                #Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
                $dt = $year*12;
                #se restan los meses para obtener los meses transcurridos. 
                $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                #se pasa a la variable edad, para guardar junto a la información que proviene del form.
                $edadpc = $year."-".$months;
            #---------------------|     
        } else {
            $fpCelo = null; 
            $edadpc = null; // no exsite;
        }

        $fechaUltimoCelo = DB::table('sgcelos')
                ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
        /*
        * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
        */
        if ( $fechaUltimoCelo->count()>0 ) {

            foreach ($fechaUltimoCelo as $key) {
                $fuCelo = $key->fecUltimoCelo;
            }
            $fuc = $fuCelo;
        } else {
            $fuc = null;
        }   
        /*
        * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
        */
        $ultimoCelo = DB::table('sgcelos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->where('fechr','=',$fuc)
                ->get(); 

        if ( ($ultimoCelo->count()>0) ) {
            foreach ($ultimoCelo as $key ) {
                $ientcel = $key->dias; 
            }   
            $ientcelos = $ientcel;

        } else {
            $ientcelos= null; 
        }   
        /*
        * Ubicamos el ultimo servicio
        */
        $ultServicio = DB::table('sgservs')
                ->select(DB::raw('MAX(fecha) as fultservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();

        if ($ultServicio->count()>0) {
            foreach ($ultServicio as $key) {
                $fUltserv = $key->fultservicio;
            }
        } else {
            # No tiene servicio creado
            $fUltserv = null; //es decir no existe 
        }
        # Ubicamosla iserv del ultimo servicio
        $intServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fUltserv)
                ->get();        
        if ($intServicio->count()>0 ) {
            foreach ($intServicio as $key ) {
                $intEntreServ = $key->iers; 
            }   
        } else {
            $intEntreServ=null; //no existe.
        }
        /*
        * Buscamo la preñez actual para saber el tiempo de secado
        */  
        $prenezActual = DB::table('sgprenhezs')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
        if ($prenezActual->count()>0) {

            foreach ($prenezActual as $key ) {
                # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                $fechaAproxSecado = $key->fecas; 
            }   
        } else {
            $fechaAproxSecado = null; 
        }
        /*
        * Fecha del ultimo parto
        */
        $fechaUltimoParto = DB::table('sgpartos')
                ->select(DB::raw('MAX(fecpar) as fultParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();  
        if ($fechaUltimoParto->count()>0 ) {

            foreach ($fechaUltimoParto as $key) {
                $fultParto = $key->fultParto; 
            }   
        } else {
            $fultParto=null; //No existe
        }
        $intervaloEntreParto =  DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fultParto)
                ->get();                        
        if ($intervaloEntreParto->count()>0) {
            foreach ($intervaloEntreParto as $key) {
                $intentpart = $key->ientpar; 
            }
        } else {
            $intentpart = null; //ya que no existe;
        }
        /*
        * Con esto calculamos los valores IPARPC e IPARPS
        */
        if ( ($intentpart>0) and !($fpCelo==null)  ) {
              # si el Intervalo entre parto existe.
              $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
              $iparpc = $intentpart - $difdias;
        } else {
              # De lo contrario
              $iparpc = null; // Es decir no existe 
        }
                
        #********************************************************#
                
        # Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
        $sghprodNuevo = new \App\Models\sghprenhez;

        $sghprodNuevo->id_serie = $id_serie;
        $sghprodNuevo->serie = $series->serie;
        $sghprodNuevo->tipo = $tipoAnterior;

        #Condicion de la madres
        $sghprodNuevo->estado = $condicion->nombre_condicion;
        $sghprodNuevo->raza = $raza->nombreraza;
        $sghprodNuevo->idraza = $raza->idraza;
        
        $sghprodNuevo->edad = $request->edad;
        $sghprodNuevo->nservi = $series->nservi;
        $sghprodNuevo->tipops = $tipops;
        $sghprodNuevo->pesps = $pesops;
        $sghprodNuevo->fecps = $fechaPrimerServicio;
        $sghprodNuevo->edadps = $edadPservicio;

        $sghprodNuevo->fecspr = $fechasPr;
        $sghprodNuevo->codtp = $codtpajuela;
        $sghprodNuevo->respi = $nomi;
        $sghprodNuevo->torotemp = $torotemporada;

        $sghprodNuevo->tipoap = $series->tipoanterior;
        $sghprodNuevo->fecup = $fultParto;
        $sghprodNuevo->edadpp = $edadPp;
        /*
        * Datos del animal cría 2
        */
        $sghprodNuevo->fecpar = $request->fnac2; //La fecha en que nace la cria
        $sghprodNuevo->sexo1 = $request->sexocria2;
        $sghprodNuevo->becer1 = $request->seriecria2;
        $sghprodNuevo->obsebec1 = $request->observa2;
        $sghprodNuevo->edobece1 = $request->condicorpocria2;
        $sghprodNuevo->razabe = $request->razacria2;
        $sghprodNuevo->pesoib1 = $request->pesoicria2;
        // $sghprodNuevo->ientpar = $request->ier;
        $sghprodNuevo->marcabec2 = $marca;
        /*
        * Datos del animal cria 1 Muerto
        */
        $sghprodNuevo->obsernm = $request->observamuerte1;
        $sghprodNuevo->causanm = $request->causamuerte1;
        //$sghprodNuevo->razabe = $request->razacria2;
        $sghprodNuevo->marcabec1 = $marca2;
                
        #Verificamos si viene el padre es pajuela o torotemporada.
        if (!$codtpajuela==null) {
            $codpadre = $codtpajuela;
        } else {
            $codpadre = $torotemporada;
        }
        if (($codtpajuela==null) and ($torotemporada==null)) {
            $codpadre = null; //Se desconoce el valor del codigo del padre; 
        }

        $sghprodNuevo->codp = $codpadre;
        $sghprodNuevo->razapadre = $razapadre;
        $sghprodNuevo->nombrepadre = $nombrepadre;
        $sghprodNuevo->tipopadre = $tipopadre;
        $sghprodNuevo->fechanacpadre = $fechanacpadre;
        
        $sghprodNuevo->espajuela = $espajuela;

        $sghprodNuevo->fecas = $fechaAproxSecado;

        $sghprodNuevo->ncelos = $nroCelos;
        $sghprodNuevo->fecpc = $fpCelo;
        $sghprodNuevo->edadpc = $edadpc;
        $sghprodNuevo->fecuc = $fuc;

        $sghprodNuevo->ientcel = $ientcelos;
        $sghprodNuevo->iserv = $intEntreServ;
        $sghprodNuevo->ientpar = $intentpart; 

        $sghprodNuevo->iparps = $iparpc;
        $sghprodNuevo->iparpc = $iparpc; 

        $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
        $sghprodNuevo->nciclo = $id_ciclo;
        $sghprodNuevo->id_finca = $id_finca;

        $sghprodNuevo->save(); 

        /* ----------------------------------------------------
        *  Fin de Actualización Tabla de sghprenez = sghprod
        -----------------------------------------------------*/       
        $fecsistema = Carbon::now(); 
        /*
        * Se actualiza la tabla mv1 manejo de vientre Cría 2 Viva
        */
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        $mv1Nuevo->serie_hijo = $request->seriecria2;
        $mv1Nuevo->codpadre =   $codpadre;

        # Como se trata de un parto nuevo vivo, la tipologia viene  calcualda asi
        $tipologiaPartoNuevo = DB::table('sgtipologias')
                    ->where('edad','=', 0) //hadcode, ya que es un animal que no tiene edad
                    ->where('sexo','=',$request->sexocria2)
                    ->where('peso','<=',$request->pesoicria2)
                    ->where('destetado','=',0) //hadcode, Animal no destetado
                    ->get();

        foreach ($tipologiaPartoNuevo as $key) {
             $idtipoPartNuevo = $key->id_tipologia;
             $nombreTipo = $key->nombre_tipologia; 
             $destetado = $key->destetado;
             #Sacamos los parametros tipologicos.
             $nroMonta = $key->nro_monta;
             $prenada = $key->prenada; 
             $parida = $key->parida; 
             $tieneCria = $key->tienecria; 
             $criaViva = $key->criaviva;
             $ordenho = $key->ordenho;
             $detectaCelo = $key->detectacelo;
      }

      $mv1Nuevo->tipologia = $nombreTipo;
      $mv1Nuevo->id_tipo = $idtipoPartNuevo;

      $mv1Nuevo->caso = $caso;
      $mv1Nuevo->fecha = $request->fnac2;
      $mv1Nuevo->fecs = $fecsistema;

      $mv1Nuevo->id_finca = $id_finca;

      $mv1Nuevo->save();

      # Segunda Cria 1 muerta mv1
      # Se actualiza la tabla mv1 manejo de vientre para cría muerta                 
      $mv1Nuevo = new \App\Models\sgmv1;

      $mv1Nuevo->codmadre = $request->serie;

      $mv1Nuevo->caso = $casoM;
      $mv1Nuevo->fecha = $request->fnacmuerte;
      $mv1Nuevo->fecs = $fecsistema;

      $mv1Nuevo->id_finca = $id_finca;

      $mv1Nuevo->save();
      /*
      * Aqui Actualizamos la tabla datos de Vida
      */
      $datosDeVidaNuevo = new \App\Models\sgdatosvida;

      $datosDeVidaNuevo->seriem = $series->serie;
      $datosDeVidaNuevo->fecha = $request->fnac2;
      $datosDeVidaNuevo->caso = $caso;
      $datosDeVidaNuevo->nservicios = $series->nservi;
      $datosDeVidaNuevo->pesps = $pesops;
      $datosDeVidaNuevo->edadps = $edadPservicio;
      $datosDeVidaNuevo->codp = $codpadre;
      $datosDeVidaNuevo->edadpp = $edadPp;

      $datosDeVidaNuevo->serieh = $request->seriecria1;
      $datosDeVidaNuevo->pespih = $request->pesoicria1;

      $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
      
      $datosDeVidaNuevo->diapr = $retVal;
      $datosDeVidaNuevo->ncelos = $nroCelos;
      $datosDeVidaNuevo->edadpc = $edadpc;

      $datosDeVidaNuevo->fecas = $fechaAproxSecado;

      $datosDeVidaNuevo->ientpar = $intentpart; 
      $datosDeVidaNuevo->ientcel = $ientcelos;
      $datosDeVidaNuevo->iserv = $intEntreServ;
      $datosDeVidaNuevo->iee = $intentpart;

      $datosDeVidaNuevo->id_finca = $id_finca;

      $datosDeVidaNuevo->save();
                
      /*
      * Actualizamos nuevamente la tabla Datos de Vida para la cria Muerta
      */
      $datosDeVidaNuevo2 = new \App\Models\sgdatosvida;

      $datosDeVidaNuevo2->seriem = $series->serie;
      $datosDeVidaNuevo2->fecha = $request->fnacmuerte;
      $datosDeVidaNuevo2->caso = $casoM;
      $datosDeVidaNuevo2->nservicios = $series->nservi;
      $datosDeVidaNuevo2->pesps = $pesops;
      $datosDeVidaNuevo2->edadps = $edadPservicio;
      $datosDeVidaNuevo2->codp = $codpadre;
      $datosDeVidaNuevo2->edadpp = $edadPp;

      //$datosDeVidaNuevo->serieh = $request->seriecria2;
      //$datosDeVidaNuevo->pespih = $request->pesoicria2;

      $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
                
      $datosDeVidaNuevo2->diapr = $retVal;
      $datosDeVidaNuevo2->ncelos = $nroCelos;
      $datosDeVidaNuevo2->edadpc = $edadpc;

      $datosDeVidaNuevo2->fecas = $fechaAproxSecado;

      $datosDeVidaNuevo2->ientpar = $intentpart; 
      $datosDeVidaNuevo2->ientcel = $ientcelos;
      $datosDeVidaNuevo2->iserv = $intEntreServ;
      $datosDeVidaNuevo2->iee = $intentpart;

      $datosDeVidaNuevo2->id_finca = $id_finca;

      $datosDeVidaNuevo2->save();
      /*
      * Aqui se debe actualizar la tabla sganims cuando se realiza el parto
      */
      $partoRegistro = DB::table('sganims')
              ->where('id_finca','=', $id_finca)
              ->where('id','=',$id_serie)
              ->update(['nparto'=>$countparto,
                        'fecup'=>$fultParto,
                        'tipo'=>$nuevaTipologiaName,
                        'id_tipologia'=>$idTipologiaNueva,
                        'tipoanterior'=>$tipoAnterior,
                        #Actualizamos los parametros tipologicos.
                        'prenada'=>$prenhada,
                        'tienecria'=>$tienecria,
                        'criaviva'=>$criaViva,
                        'ordenho'=>$ordeNho,
                        'detectacelo'=>$detectaCelo]);
      /*
      * Sacamos la Tipologia inicial
      */  
      $tipoPartoNuevo = DB::table('sgtipologias')
                ->where('sexo','=',$request->sexocria2)
                ->where('edad','=',0)
                ->where('peso','<=',$request->pesoicria2)
                ->get();

      foreach ($tipoPartoNuevo as $key) {
                $nombreTipo = $key->nombre_tipologia;
                $idTipo = $key->id_tipologia;
                $destetado = $key->destetado;
                #Sacamos los parametros tipologicos.
                $nroMonta = $key->nro_monta;
                $prenada = $key->prenada; 
                $parida = $key->parida; 
                $tieneCria = $key->tienecria; 
                $criaViva = $key->criaviva;
                $ordenho = $key->ordenho;
                $detectaCelo = $key->detectacelo;
      }
      /*
      * Sacamos la Raza
      */   
      $razaPartoNuevo = DB::table('sgrazas')
                ->where('nombreraza','=',$request->razacria2)
                ->get();
      foreach ($razaPartoNuevo as $key) {
                    $idraza = $key->idraza;     
      }

      $condPartoNuevo = DB::table('sgcondicioncorporals')
                ->where('nombre_condicion','=',$request->condicorpocria2)
                ->get();    

      foreach ($condPartoNuevo as $key ) {
          $idcondicion = $key->id_condicion;      
      }   
      /*
      * Por ultimo Creamos la Ficha de Ganado para la nueva Cría 1 Viva
      */            
      $nuevaSerieParto = new \App\Models\sganim;

      $nuevaSerieParto->serie = $request->seriecria2;
      $nuevaSerieParto->sexo = $request->sexocria2;
      $nuevaSerieParto->nombrelote = $series->nombrelote;
      $nuevaSerieParto->codmadre = $series->serie; # Es la Serie que pario
      $nuevaSerieParto->codpadre = $codpadre;
      $nuevaSerieParto->espajuela = $espajuela; #voy a verificarlo
      $nuevaSerieParto->pajuela = $codpadre;
      $nuevaSerieParto->fnac = $request->fnac2;
      $nuevaSerieParto->motivo = null; #Lo voy a Sacar
      $nuevaSerieParto->status = 1; #Activo
      $nuevaSerieParto->tipo = $nombreTipo;
      $nuevaSerieParto->color_pelaje = $request->colorpelaje1; 
      $nuevaSerieParto->observa = $request->observa2;
      $nuevaSerieParto->procede = $finca->nombre;
      $nuevaSerieParto->pesoi = $request->pesoicria2;
      $nuevaSerieParto->destatado = $destetado;
      $nuevaSerieParto->edad = "0-0"; #hardcode.
      $nuevaSerieParto->id_tipologia = $idTipo;
      $nuevaSerieParto->idraza = $idraza;
      $nuevaSerieParto->id_condicion = $idcondicion;
      $nuevaSerieParto->lnaci = $series->nombrelote;
      #Parametros tipologicos 
      $nuevaSerieParto->nro_monta = $nroMonta;
      $nuevaSerieParto->prenada = $prenada; 
      $nuevaSerieParto->parida = $parida; 
      $nuevaSerieParto->tienecria = $tieneCria;
      $nuevaSerieParto->criaviva = $criaViva;
      $nuevaSerieParto->ordenho =  $ordenho;
      $nuevaSerieParto->detectacelo = $detectaCelo;

      $nuevaSerieParto->id_finca = $id_finca;

      $nuevaSerieParto->save();               

      }
    /*
    * Partos Morochos y los dos nacen muertos.
    */
    if ( ($request->tipoparto=="on") and ($request->condicionnac1==0) and ($request->condicionnac2==0) ) 
    {

      $request->validate([

           'fnacmuerte'=> [
            'required',
        ],
        'muerterazacria1'=> [
            'required',
        ],
        'causamuerte1'=> [
            'required',
        ],
        'fnacmuerte2'=> [
            'required',
        ],
        'muerterazacria2'=> [
            'required',
        ],
        'causamuerte2'=> [
            'required',
        ],
      ]);
    	# Aquí colocamos la Marca Vi para clasificar que ha nacido vivo y Mu que
    	# ha nacido muerto
    	$marca = "Mu"; 	 // hardcod
    	$marca2 = "Mu"; 	 // hardcod
    	/*
    	* es importante buscar la tipología actual que es la misma que tiene
    	*antes del parto
    	*/
    	$tipoActual = $series->tipo;

    	/*
    	* 2-> Guardamos en la tabla de partos los registros del form. 
    	*/	 
    	$caso = "Parto Morochos"; //hardcod
      $casoM = "Parto Morochos Nac. Muerto"; //hardcode

      $partoNuevo = new \App\Models\sgparto;

      $partoNuevo->id_serie = $id_serie;
      $partoNuevo->serie = $request->serie;
      $partoNuevo->tipo = "Este se actualiza al final";
      $partoNuevo->estado = $request->condicorpo;
      $partoNuevo->edad = $request->edad;
      $partoNuevo->tipoap = $tipoActual = $series->tipo;
      $partoNuevo->fecup = $request->fecup;

 		  # Comienza los datos de la Cría 2 #
      $partoNuevo->causanm1 = $request->causamuerte2;
      $partoNuevo->obsernm1 = $request->observamuerte2;
      $partoNuevo->marcabec2 = $marca2;

 		  # Comienza los datos de la Cría 1 #
      $partoNuevo->razabe = $request->razacria1;
      $partoNuevo->fecpar = $request->fnacmuerte;
      $partoNuevo->causanm = $request->causamuerte1;
      $partoNuevo->obsernm = $request->observamuerte1;
      $partoNuevo->marcabec1 = $marca;

      $partoNuevo->id_ciclo = $id_ciclo;
      $partoNuevo->id_finca = $id_finca;

      try{

          $partoNuevo-> save();
          #Se Cambian los parametros tipologicos para cambio e tipologia
          $pario = 1;  
          $tienesucria = 1;
          $crianacioviva = 0; 
          $prenez = 0;    
      }catch (\Illuminate\Database\QueryException $e){
            #Se devuelven los cambios en caso de haber un error.
            $pario = 0;  
            $tienesucria = 0;
            $crianacioviva = 1; 
            $prenez = 1;
            return back()->with('mensaje', 'error');
        }   

        $countparto =  DB::table('sgpartos')
          ->where('fecpar','=',$request->fnacmuerte)
          ->where('id_finca','=', $id_finca)
          ->where('id_ciclo','=', $id_ciclo)
          ->count(); 

        $nroparto = DB::table('sghistoricotemprepros')
          ->where('fecharegistro','=',$request->fnacmuerte)
          ->where('id_finca','=', $id_finca)
          ->where('id_ciclo','=', $id_ciclo)
          ->update(['nropart'=>$countparto]);  
        /*
        * Aqui actualizamos la Tipologia en caso de una preñez
        * ya que es un proceso que conlleva a eso.
        */
        #Buscamos la tipologia actual 
        $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();
        #Obtenemos todos parametros de la tipologia
        foreach ($tipoActual as $key ) {
            $tipologiaName = $key->nombre_tipologia;
            $edad = $key->edad;
            $peso = $key->peso;
            $destetado = $key->destetado;
            $sexo = $key->sexo;
            $nro_monta = $key->nro_monta;
            $prenada = $key->prenada;
            $parida = $key->parida;
            $tienecria = $key->tienecria;
            $criaviva = $key->criaviva;
            $ordenho = $key->ordenho;
            $detectacelo = $key->detectacelo;
            $idtipo = $key->id_tipologia;
        }
        
        #Actualizamos la tipologia
        #Obtenemos la tipologia anterior
        $tipoAnterior = $tipologiaName;
        $nroMonta = $series->nro_monta;

        # Actualizamos si se efectua el parto.
        $tipologia= DB::table('sgtipologias')
            ->where('edad','=',$edad)
            ->where('peso','=',$peso)
            ->where('destetado','=',$destetado)
            ->where('sexo','=',$sexo)
            ->where('nro_monta','=',$nroMonta) //Revisar aqui
            ->where('prenada','=',$prenez)
            ->where('parida','=',$pario)
            ->where('tienecria','=',$tienesucria)
            ->where('criaviva','=',$crianacioviva)
            ->where('ordenho','=',$ordenho)
            ->where('detectacelo','=',$detectacelo)
            ->where('id_finca','=',$id_finca)
            ->get();
            
            foreach ($tipologia as $key ) {
                $tipologiaName = $key->nombre_tipologia;
                $idtipo = $key->id_tipologia;
                $prenada =$key->prenada;
                $tcria = $key->tienecria;
                $criav = $key->criaviva;
                $ordenho = $key->ordenho;
                $detectacelo = $key->detectacelo;
            }   

            $idTipologiaNueva = $idtipo;
            $nuevaTipologiaName = $tipologiaName;
            $prenhada = $prenada;
            $tienecria = $tcria;
            $criaViva = $criav;
            $ordeNho = $ordenho;
            $detectaCelo = $detectacelo;
        /*
        * Actualizamos el campo tipo con la tipologia final
        */
        $tipologiaParto= DB::table('sgpartos')
          ->where('id_finca','=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)            
          ->update(['tipo'=>$nuevaTipologiaName]);        
        /*
        * Buscamos la fecha del perimer servicio
        */          
        $servicio = DB::table('sgservs')
          ->select(DB::raw('MIN(fecha) as fpserv'))
          ->where('id_serie','=',$id_serie)
          ->where('id_finca','=',$id_finca)
          ->get();
        /*
        * Si tenemos registros buscamos la fecha del primer servicio
        */  
        if ($servicio->count()>0) {
            #Si existe el servicio buscamo la fecha del primer servicio.
            foreach ($servicio as $key) {
                $fechaPrimerServicio = $key->fpserv;    
            }
        } else {
            $fechaPrimerServicio = null; 
        }
        # Con la fecha del primer servicio buscamo la tipologia primer servicio
        $tipoPrimerServicio = DB::table('sgservs')
          ->where('id_serie','=',$id_serie)
          ->where('fecha','=',$fechaPrimerServicio)
          ->where('id_finca','=',$id_finca)
          ->get();
        
        if ($tipoPrimerServicio->count()>0) {
            #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
            foreach ($tipoPrimerServicio as $key) {
                $id_tipologia = $key->id_tipologia;
                $pesops = $key->peso;   
            }
            # Con id ubicamos la Tipoloiga en la tabla
            $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
            #Obtenemos el Nombre de la Tipologia    
            $tipops= $tipologia->nombre_tipologia;
            #Obtenemos el peso que tiene la serie en el primer servicio
            $pesops = $pesops; 

        } else {

            $tipops= null; //No existe
            $pesops = null; //no existe
        } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
        
        # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
        $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
          ->select(DB::raw('MIN(fecser) as fespr'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('toropaj','<>',null)
          ->orWhere('torotemp','<>',null)
          ->get();  

        # Comprobamos si existe el servicio que generó la preñez    
        if ( $servicioPrimerPrenez->count()>0) {
            #Si existe, obtenemos fecha de primer servicio 
            foreach ($servicioPrimerPrenez as $key) {
                $fechasPr = $key->fespr; 
            }
        } else {
            $fechasPr = null; 
        }           
        /*
        Con la fechasPr creamos una consulta para verificar 
        si se trata de una preñez por toropajuela o torotempt 
        */
        $prenezHistorico = DB::table('sgprenhez_historicos')
            ->where('id_finca', '=',$id_finca)
            ->where('id_serie','=',$id_serie)
            ->where('fecser','=',$fechasPr)
            ->get();  
        # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
        if ($prenezHistorico->count()>0) {
            foreach ($prenezHistorico as $key) {
                $toropaj = $key->toropaj;
                $nomi = $key->nomi;
                $torotemp = $key->torotemp; 
            }
        } else {
            $toropaj = null;
            $nomi = null;
            $torotemp = null;
        }
        #Con los valores anteriores identificamos la pajuela
        $pajuela = DB::table('sgpajus')
          ->where('id_finca','=',$id_finca)
          ->where('serie','=',$toropaj)
          ->get();

        # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
        if ($pajuela->count()>0) {
            #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
            $espajuela = 1; 
            foreach ($pajuela as $key) {
                $idpaju = $key->id;
                $razapaju = $key->nombreraza;
                $fechanac = $key->fnac;
                $nombrepa = $key->nomb; 
            }
            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
        } else {
            #Si no existe la pajuela, sus valores pasan a null.
            $idpaju = null;
            $razapaju = null;
            $fechanac = null;
            $nombrepa = null;

            $nombrepadre = $nombrepa;
            $razapadre = $razapaju;
            $tipopadre = null;
            $fechanacpadre = $fechanac;
            #Como la pajuela no existe entonces marcamos a falso 
            $espajuela = 0; 
        }
        # Ubicamos si es Toro en caso de existir la Preñez Historico                
        $toro = DB::table('sganims')
        ->where('id_finca','=',$id_finca)
        ->where('serie','=',$torotemp)
        ->get();
        # Verificamos que el $torotemp exista
        if ($toro->count()>0) {
            #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
            $espajuela = 0; 
            foreach ($toro as $key) {
                $razatoro = $key->idraza;
                $idtipo = $key->id_tipologia;
                $fecnacPadre = $key->fnac;
            }
            $raza = \App\Models\sgraza::findOrFail($razatoro);
            $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
            
            $razapadre = $raza->nombreraza;
            $tipopadre = $tipotoro->nombre_tipologia;
            $fechanacpadre = $fecnacPadre;
            $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

        } else {
            #Si no existe el Toro, entonces se asume que fue una monta natural  
            $razapadre = null;
            $tipopadre = null;
            $fechanacpadre = null;
            $nombrepadre = null;
        }

        #Actualizamos las variables si proviene de Pajuela o Toro.
        $fechasPr = $fechasPr; 
        $codtpajuela = $toropaj;
        $nomi = $nomi;
        $torotemporada = $torotemp;
        $razapadre = $razapadre;
        $tipopadre = $tipopadre;
        $fechanacpadre = $fechanacpadre;
        $nombrepadre = $nombrepadre;
        #Se pasa a falso ya que fue por Monta natural
        $espajuela = $espajuela;
        /*
        * Ubicamos el primer servicio
        */
        $primerServicio = DB::table('sgservs')
          ->select(DB::raw('MIN(fecha) as fpservicio'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get();
        /*
        * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
        */
        if ( $primerServicio->count()>0 ) {
            foreach ($primerServicio as $key) {
                $fecha = $key->fpservicio;
            }
        } else {
            # No tiene servicio creado
            $fecha=null; //no existe;
        }
        # Ubicamosla Edad primer servicio
        $edadPrimerServicio = DB::table('sgservs')
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('fecha','=', $fecha)
          ->get();        

        if ($edadPrimerServicio->count()>0) {
            foreach ($edadPrimerServicio as $key ) {
                $edadPservicio = $key->edad;
            }
        } else {
           $edadPservicio = null; //es decir no existe 
        }
        /*
        * Ubicamos la fecha del Primer parto
        */  
        $fechaPrimerParto = DB::table('sgpartos')
          ->select(DB::raw('MIN(fecpar) as fprimerParto'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get(); 
        
        if ($fechaPrimerParto->count()>0) {
            foreach ($fechaPrimerParto as $key) {
                $fpParto = $key->fprimerParto; 
            }               
        } else {
            $fpParto=null; // no existe
        }                        
        /*
        * La edad del primer Parto
        */
        $edadPrimerParto = DB::table('sgpartos')
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('fecpar','=',$fpParto)
          ->get();

        if ($edadPrimerParto->count()>0) {
            foreach ($edadPrimerParto as $key ) {
                $edadPp = $key->edad; 
            }
        } else {
            $edadPp=null; 
        }
        /*
        * Ubicamos El numero de celos por la temporada de monta
        */
        $celos = DB::table('sgcelos')
          ->where('id_finca','=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->get();

        $nroCelos = $celos->count();    
        /*
        * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
        */
        $fechaPrimerCelo = DB::table('sgcelos')
          ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->get(); 
        //if ( ($fechaPrimerCelo==null) or empty($fechaPrimerCelo) ) {
        if ( $fechaPrimerCelo->count()>0) {

            foreach ($fechaPrimerCelo as $key) {
                $fPrimerCelo = $key->fecPrimerCelo;
            }

            $fpCelo = $fPrimerCelo;

            #*************************************************#
                //Se calcula con la herramienta carbon la edad
            $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
            $dt = $year*12;
                //se restan los meses para obtener los meses transcurridos. 
            $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                // se pasa a la variable edad, para guardar junto a la información que proviene del form.
            $edadpc = $year."-".$months;
            #*************************************************#                     
        } else {
            $fpCelo = null; 
            $edadpc = null; // no exsite;
        }

        $fechaUltimoCelo = DB::table('sgcelos')
          ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->get(); 
        /*
        * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
        */
        if ( $fechaUltimoCelo->count()>0 ) {

            foreach ($fechaUltimoCelo as $key) {
                $fuCelo = $key->fecUltimoCelo;
            }
            $fuc = $fuCelo;
        } else {
            $fuc = null;
        }   
        /*
        * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
        */
        $ultimoCelo = DB::table('sgcelos')
          ->where('id_finca', '=',$id_finca)
          ->where('id_ciclo','=',$id_ciclo)
          ->where('id_serie','=',$id_serie)
          ->where('fechr','=',$fuc)
          ->get(); 

        if ( ($ultimoCelo->count()>0) ) {
            foreach ($ultimoCelo as $key ) {
                $ientcel = $key->dias; 
            }   
            $ientcelos = $ientcel;

        } else {
            $ientcelos= null; 
        }   
        /*
        * Ubicamos el ultimo servicio
        */
        $ultServicio = DB::table('sgservs')
          ->select(DB::raw('MAX(fecha) as fultservicio'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get();
        if ($ultServicio->count()>0) {
            foreach ($ultServicio as $key) {
                $fUltserv = $key->fultservicio;
            }
        } else {
            # No tiene servicio creado
            $fUltserv = null; //es decir no existe 
        }
        # Ubicamosla iserv del ultimo servicio
        $intServicio = DB::table('sgservs')
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('fecha','=', $fUltserv)
          ->get();        
        if ($intServicio->count()>0 ) {
            foreach ($intServicio as $key ) {
                $intEntreServ = $key->iers; 
            }   
        } else {
            $intEntreServ=null; //no existe.
        }
        /*
        * Buscamo la preñez actual para saber el tiempo de secado
        */  
        $prenezActual = DB::table('sgprenhezs')
          ->where('id_finca','=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get(); 
        if ($prenezActual->count()>0) {

            foreach ($prenezActual as $key ) {
                # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                $fechaAproxSecado = $key->fecas; 
            }   
        } else {
            $fechaAproxSecado = null; 
        }
        /*
        * Fecha del ultimo parto
        */
        $fechaUltimoParto = DB::table('sgpartos')
          ->select(DB::raw('MAX(fecpar) as fultParto'))
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->get();  
        if ($fechaUltimoParto->count()>0 ) {

            foreach ($fechaUltimoParto as $key) {
                $fultParto = $key->fultParto; 
            }   
        } else {
            $fultParto=null; //No existe
        }
        $intervaloEntreParto =  DB::table('sgpartos')
          ->where('id_finca', '=',$id_finca)
          ->where('id_serie','=',$id_serie)
          ->where('fecpar','=',$fultParto)
          ->get();                        
        if ($intervaloEntreParto->count()>0) {
            foreach ($intervaloEntreParto as $key) {
                $intentpart = $key->ientpar; 
            }
        } else {
                $intentpart = null; //ya que no existe;
            }
        /*
        * Con esto calculamos los valores IPARPC e IPARPS
        */
        if ( ($intentpart>0) and !($fpCelo==null)  ) {
            # si el Intervalo entre parto existe.
            $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
            $iparpc = $intentpart - $difdias;
        } else {
            # De lo contrario
            $iparpc = null; // Es decir no existe 
        }
        
        #********************************************************#
        # Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
        $sghprodNuevo = new \App\Models\sghprenhez;

        $sghprodNuevo->id_serie = $id_serie;
        $sghprodNuevo->serie = $series->serie;
        $sghprodNuevo->tipo = $tipoAnterior;

        #Condicion de la madres
        $sghprodNuevo->estado = $condicion->nombre_condicion;
        $sghprodNuevo->raza = $raza->nombreraza;
        $sghprodNuevo->idraza = $raza->idraza;
        
        $sghprodNuevo->edad = $request->edad;
        $sghprodNuevo->nservi = $series->nservi;
        $sghprodNuevo->tipops = $tipops;
        $sghprodNuevo->pesps = $pesops;
        $sghprodNuevo->fecps = $fechaPrimerServicio;
        $sghprodNuevo->edadps = $edadPservicio;

        $sghprodNuevo->fecspr = $fechasPr;
        $sghprodNuevo->codtp = $codtpajuela;
        $sghprodNuevo->respi = $nomi;
        $sghprodNuevo->torotemp = $torotemporada;

        $sghprodNuevo->tipoap = $series->tipoanterior;
        $sghprodNuevo->fecup = $fultParto;
        $sghprodNuevo->edadpp = $edadPp;
        
        /*
        * Datos del animal cría 1 Merto
        */

        $sghprodNuevo->fecpar = $request->fnac; //La fecha en que nace la cria

        $sghprodNuevo->obsernm = $request->observamuerte1;
        $sghprodNuevo->causanm = $request->causamuerte1;
        //$sghprodNuevo->razabe = $request->razacria2;
        $sghprodNuevo->marcabec1 = $marca2;
        // $sghprodNuevo->ientpar = $request->ier;
        /*
        * Datos del animal cria 2 Muerto
        */
        $sghprodNuevo->obsernm1 = $request->observamuerte2;
        $sghprodNuevo->causanm1 = $request->causamuerte2;
        //$sghprodNuevo->razabe = $request->razacria2;
        $sghprodNuevo->marcabec1 = $marca2;
        
        #Verificamos si viene el padre es pajuela o torotemporada.
        if (!$codtpajuela==null) {
            $codpadre = $codtpajuela;
        } else {
            $codpadre = $torotemporada;
        }
        if (($codtpajuela==null) and ($torotemporada==null)) {
            $codpadre = null; //Se desconoce el valor del codigo del padre; 
        }

        $sghprodNuevo->codp = $codpadre;
        $sghprodNuevo->razapadre = $razapadre;
        $sghprodNuevo->nombrepadre = $nombrepadre;
        $sghprodNuevo->tipopadre = $tipopadre;
        $sghprodNuevo->fechanacpadre = $fechanacpadre;
        
        $sghprodNuevo->espajuela = $espajuela;

        $sghprodNuevo->fecas = $fechaAproxSecado;

        $sghprodNuevo->ncelos = $nroCelos;
        $sghprodNuevo->fecpc = $fpCelo;
        $sghprodNuevo->edadpc = $edadpc;
        $sghprodNuevo->fecuc = $fuc;

        $sghprodNuevo->ientcel = $ientcelos;
        $sghprodNuevo->iserv = $intEntreServ;
        $sghprodNuevo->ientpar = $intentpart; 

        $sghprodNuevo->iparps = $iparpc;
        $sghprodNuevo->iparpc = $iparpc; 

        $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
        $sghprodNuevo->nciclo = $id_ciclo;
        $sghprodNuevo->id_finca = $id_finca;

        $sghprodNuevo->save(); 

        /* ----------------------------------------------------------
        *  Fin de Actualización Tabla de sghprenez = sghprod
        -----------------------------------------------------------*/       
        $fecsistema = Carbon::now(); 
        /*
        * Se actualiza la tabla mv1 manejo de vientre Cría 1 muerto
        */
        # Segunda Cria 1 muerta mv1
        # Se actualiza la tabla mv1 manejo de vientre para cría muerta                 
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        $mv1Nuevo->caso = $casoM;
        $mv1Nuevo->fecha = $request->fnacmuerte;
        $mv1Nuevo->fecs = $fecsistema;
        $mv1Nuevo->id_finca = $id_finca;

        $mv1Nuevo->save();

        
        # Segunda Cria 2 muerta mv1
        # Se actualiza la tabla mv1 manejo de vientre para cría muerta                 
        $mv1Nuevo = new \App\Models\sgmv1;

        $mv1Nuevo->codmadre = $request->serie;
        
        $mv1Nuevo->caso = $casoM;
        $mv1Nuevo->fecha = $request->fnacmuerte2;
        $mv1Nuevo->fecs = $fecsistema;

        $mv1Nuevo->id_finca = $id_finca;

        $mv1Nuevo->save();

        /*
        * Aqui Actualizamos la tabla datos de Vida
        */
        $datosDeVidaNuevo = new \App\Models\sgdatosvida;
        
        $datosDeVidaNuevo->seriem = $series->serie;
        $datosDeVidaNuevo->fecha = $request->fnacmuerte;
        $datosDeVidaNuevo->caso = $casoM;

        $datosDeVidaNuevo->nservicios = $series->nservi;
        $datosDeVidaNuevo->pesps = $pesops;
        $datosDeVidaNuevo->edadps = $edadPservicio;
        $datosDeVidaNuevo->codp = $codpadre;
        $datosDeVidaNuevo->edadpp = $edadPp;

        $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
        
        $datosDeVidaNuevo->diapr = $retVal;
        $datosDeVidaNuevo->ncelos = $nroCelos;
        $datosDeVidaNuevo->edadpc = $edadpc;

        $datosDeVidaNuevo->fecas = $fechaAproxSecado;

        $datosDeVidaNuevo->ientpar = $intentpart; 
        $datosDeVidaNuevo->ientcel = $ientcelos;
        $datosDeVidaNuevo->iserv = $intEntreServ;
        $datosDeVidaNuevo->iee = $intentpart;

        $datosDeVidaNuevo->id_finca = $id_finca;

        $datosDeVidaNuevo->save();
        
        /*
        * Actualizamos nuevamente la tabla Datos de Vida para la cria Muerta
        */
        $datosDeVidaNuevo2 = new \App\Models\sgdatosvida;

        $datosDeVidaNuevo2->seriem = $series->serie;
        $datosDeVidaNuevo2->fecha = $request->fnacmuerte2;
        $datosDeVidaNuevo2->caso = $casoM;
        $datosDeVidaNuevo2->nservicios = $series->nservi;
        $datosDeVidaNuevo2->pesps = $pesops;
        $datosDeVidaNuevo2->edadps = $edadPservicio;
        $datosDeVidaNuevo2->codp = $codpadre;
        $datosDeVidaNuevo2->edadpp = $edadPp;

        $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;
        
        $datosDeVidaNuevo2->diapr = $retVal;
        $datosDeVidaNuevo2->ncelos = $nroCelos;
        $datosDeVidaNuevo2->edadpc = $edadpc;

        $datosDeVidaNuevo2->fecas = $fechaAproxSecado;

        $datosDeVidaNuevo2->ientpar = $intentpart; 
        $datosDeVidaNuevo2->ientcel = $ientcelos;
        $datosDeVidaNuevo2->iserv = $intEntreServ;
        $datosDeVidaNuevo2->iee = $intentpart;

        $datosDeVidaNuevo2->id_finca = $id_finca;

        $datosDeVidaNuevo2->save();
        /*
        * Aqui se debe actualizar la tabla sganims cuando se realiza el parto
        */
        $partoRegistro = DB::table('sganims')
              ->where('id_finca','=', $id_finca)
              ->where('id','=',$id_serie)
              ->update(['nparto'=>$countparto,
                        'fecup'=>$fultParto,
                        'tipo'=>$nuevaTipologiaName,
                        'id_tipologia'=>$idTipologiaNueva,
                        'tipoanterior'=>$tipoAnterior,
                                            #Actualizamos los parametros tipologicos.
                        'prenada'=>$prenhada,
                        'tienecria'=>$tienecria,
                        'criaviva'=>$criaViva,
                        'ordenho'=>$ordeNho,
                        'detectacelo'=>$detectaCelo]);
    }
  return back()->with('msj', 'Registro agregado satisfactoriamente');       
  } /*Fin - Parto*/


  public function eliminar_parto($id_finca, $id, $id_ciclo, $id_serie, $id_parto)
        {

           $series = \App\Models\sganim::findOrFail($id_serie);

           $partoEliminar = \App\Models\sgparto::findOrFail($id_parto);

           $fecha= $partoEliminar->fecpar;
           try {

            $partoEliminar->delete();

            $countparto =  DB::table('sgpartos')
            ->where('fecpar','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nroparto = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropart'=>$countparto]);

            /*
            * Recalcular el numero de parto y actualizar en la tabla sganim
            */
            $ultimafechaparto = DB::table('sgpartos')
            ->select(DB::raw('MAX(fecpar) as ultparto'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
			/*
			*->| Comprueba el ultimo parto y actualiza el campo Fecha ultimo parto en la tabla sganims.  
			*/	
			foreach ($ultimafechaparto as $key) {
             $ultpar = $key->ultparto;
         }
         $tipoAnterioSerie = $series->tipoanterior;

         $tipologiaAnterior = DB::table('sgtipologias')
         ->where('nombre_tipologia','=',$tipoAnterioSerie)
         ->where('id_finca','=',$id_finca)
         ->get();

         foreach ($tipologiaAnterior as $key ) {
           $tipoNombre = $key->nombre_tipologia;
           $idTipo = $key->id_tipologia;
           $prenada = $key->prenada;
           $parida = $key->parida;
           $tienecria = $key->tienecria;
           $criaviva = $key->criaviva;
           $ordenho = $key->ordenho;
           $detectacelo = $key->detectacelo; 
        } 
            #Como se elimina el parto, Se debe eliminar de la tabla sganim la cría registrada    
            #Aqui se contempla la eliminación por fecha de parto = fecha de nacimiento
        $eliminarSerieHijo = DB::table('sganims')
               ->where('id_finca','=',$id_finca)
               ->whereDate('fnac','=',$fecha)
               ->where('codmadre','=', $series->serie)
               ->delete();         	

        $ultimoparto = DB::table('sganims')
               ->where('id','=',$id_serie)
               ->where('id_finca','=', $id_finca)
               ->update(['fecup'=>$ultpar,
                        #Actualizamos la tipologia
                       'tipo'=>$tipoNombre,
                       'id_tipologia'=>$idTipo,
                        #Actualizamos los parametros tipologicos
                       'prenada'=>$prenada,
                       'parida'=>$parida,
                       'tienecria'=>$tienecria,
                       'criaviva'=>$criaviva, 
                       'ordenho'=>$ordenho,
                       'detectacelo'=>$detectacelo]);	

       return back()->with('mensaje', 'ok');     

   }catch (\Illuminate\Database\QueryException $e){
    return back()->with('mensaje', 'error');
    }
  }

    /*
    *--> Controladores de Parto
    */
    public function aborto(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
    {

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

        $usuario = \App\Models\User::all();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

        $series = \App\Models\sganim::findOrFail($id_serie);

        $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

        $condiCorpoCria = \App\Models\sgcondicioncorporal::all();

        $loteEstrategico = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Estrategico")->get();

    		//*************************************************
		        //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
		        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
		        //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
		        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
		    //*************************************************

        $causamuerte = \App\Models\sgcausamuerte::all(); 

        $raza = \App\Models\sgraza::findOrFail($series->idraza);

        $razacria = \App\Models\sgraza::all(); 

        $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)
        ->paginate(5);

        $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->paginate(7);

        $aborto = \App\Models\sgabor::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->paginate(7);	

        $causa = \App\Models\sgcausamuerte::all();	
            /*
            * Aquí se obtiene los datos de la última preñez.
            */	
            $ultimaprenez = DB::table('sgprenhezs')  
            ->select(DB::raw('MAX(fregp) as ultprenez'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($ultimaprenez as $t ) {
             $ultpre = $t->ultprenez;
         }
			/*
            *-> Se crea un identificador para saber si la serie se le ha practicado
            * un servicio en menos de 90 días.
            */	
            $servicioReciente = DB::table('sgservs')  
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($servicioReciente as $key) {
             $ultservicio = $key->ultservicio;
         }		


			/*
			* Se calcula el tiempo del ciclo de monta $tm = Tiempo de monta
			*/	
            $tm = Carbon::parse($ciclo->fechainicialciclo)->diffInDays($ciclo->fechafinalciclo);
            /*
            * Con el Valor de la feha del ultimo servicio se calcula la diferencia en días 
            * con Carbon y ver si está dentro del tipo del ciclo monta 
            */
            $diasServicio = Carbon::parse($ultservicio)->diffInDays(Carbon::now());

            if (!($ultservicio==null) and $diasServicio<$tm) {
             $servicioActivo = 1;
         } else {
             $servicioActivo = 0;
         }
            /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tgesta = $key->tiempogestacion; 
            }

            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pP = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pP as $key) {
            	//$tgesta = Tiempo de Gestación (días)
            	$tsecado = $key->diassecado; 
            }	

            /*
            * Se calcula el tiempo de preñez, ya que existe, es decir, verificar que la preñez no sea  antigua para que se registre una preñez nueva
            */
            $tp = Carbon::parse($ultpre)->diffInDays(Carbon::now());  
			/*
			*Aquí se comprueba que exista un registro de preñez para poder
			*registrar parto.	
			*/
			if (empty($ultpre) or ($ultpre==null)) {
				
				return back()->with('info', 'ok');
				
			} else {
				
				if ($tp>$tgesta) {
					return back()->with('info', 'oka');
				} else {
					if ($tp<$tgesta) {
					//return back()->with('info', 'int');
                     $prenhez = \App\Models\sgprenhez::where('fregp','=',$ultpre)
                     ->where('serie', '=', $series->serie)
                     ->where('id_finca','=',$id_finca)
                     ->get();

                     foreach ($prenhez as $key) {
                       $ieep = $key->intestpar;
                       $ida = $key->intdiaabi;
                       $festipre = $key->fepre;
                       $faprosecado = $key->fecas; 
                       $faproparto = $key->fecap;
                       $diasprenez = $key->dias_prenez;
                       $mesesprenez = $key->mesespre;
                   }

                   return view('reproduccion.formulario_aborto', compact('ciclo','finca', 'temp_reprod',
                       'tipomonta','edad','celos','series','usuario','raza','condicorpo','prenhez','diasServicio', 'tgesta','tsecado','servicioActivo', 'ieep','ida','festipre','faprosecado','faprosecado','faproparto','diasprenez','mesesprenez','razacria','condiCorpoCria','loteEstrategico','parto','causamuerte','aborto','causa'));
               }
           }
       }
   }

   public function crear_aborto(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
   {
        //	return $request; 

     $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

     $tipomonta = \App\Models\sgtipomonta::findOrFail($ciclo->id_tipomonta);

     $series = \App\Models\sganim::findOrFail($id_serie);

     $condicion = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

     $raza = \App\Models\sgraza::findOrFail($series->idraza);


        		# Validamos los campos que utilizaremos

     $request->validate([
        'freg'=> [
            'required',
                 // 'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
        ],
        'causa'=> [
            'required',
        ],
        'observacion'=> [
            'required',
        ],
    ]);

     if (!($request->mesesprenez==null)) {
        		$diap = $request->mesesprenez/30;//Es para llevar los meses a días. 
        	} else {
        		$diap = $request->diaprenez;
        	}
            	/*
            	* -> Guardamos en la tabla de Abortos los registros del form. 
            	*/	 
            	$caso = "Aborto"; //hardcod

            	$abortoNuevo = new \App\Models\sgabor;

             $abortoNuevo->id_serie = $id_serie;
             $abortoNuevo->serie = $request->serie;
             $abortoNuevo->fecr = $request->freg;
             $abortoNuevo->diap = $diap;
             $abortoNuevo->causa = $request->causa;
             $abortoNuevo->obser = $request->observacion;

             $abortoNuevo->id_ciclo = $id_ciclo;
             $abortoNuevo->id_finca = $id_finca;

             try{
                $abortoNuevo-> save();
                #Se Cambian los parametros tipologicos para cambio e tipologia
                $pario = 1;  
                    $tienesucria = 1; // Equivale a No Culminó su tiempo de Gestación
                    $crianacioviva = 0; 
                    $prenez = 0;    
                }catch (\Illuminate\Database\QueryException $e){
                #Se devuelven los cambios en caso de haber un error.
                    $pario = 1;  
                    $tienesucria = 0;
                    $crianacioviva = 1; 
                    $prenez = 1;
                    return back()->with('mensaje', 'error');
                }   
    	        /*
    	        * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
    	        */
    	        $countaborto =  DB::table('sgabors')
             ->where('fecr','=',$request->freg)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->count(); 

             $nroaborto = DB::table('sghistoricotemprepros')
             ->where('fecharegistro','=',$request->freg)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->update(['nroabort'=>$countaborto]);  
                /*
                * Aqui actualizamos la Tipologia en caso de una aborto
                * ya que es un proceso que conlleva a eso.
                */
                #Buscamos la tipologia actual 
                $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();

                #Obtenemos todos parametros de la tipologia
                foreach ($tipoActual as $key ) {
                    $tipologiaName = $key->nombre_tipologia;
                    $edad = $key->edad;
                    $peso = $key->peso;
                    $destetado = $key->destetado;
                    $sexo = $key->sexo;
                    $nro_monta = $key->nro_monta;
                    $prenada = $key->prenada;
                    $parida = $key->parida;
                    $tienecria = $key->tienecria;
                    $criaviva = $key->criaviva;
                    $ordenho = $key->ordenho;
                    $detectacelo = $key->detectacelo;
                    $idtipo = $key->id_tipologia;
                }
                
                #Actualizamos la tipologia
                #Obtenemos la tipologia anterior
                $tipoAnterior = $tipologiaName;
                $nroMonta = $series->nro_monta;

                # Actualizamos si se efectua el parto.
                $tipologia= DB::table('sgtipologias')
                ->where('edad','=',$edad)
                ->where('peso','=',$peso)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$sexo)
                    ->where('nro_monta','<=',$nroMonta) //Revisar aqui
                    ->where('prenada','=',$prenez)
                    ->where('parida','=',$pario)
                    ->where('tienecria','=',$tienesucria)
                    ->where('criaviva','=',$crianacioviva)
                    ->where('ordenho','=',$ordenho)
                    ->where('detectacelo','=',$detectacelo)
                    ->where('id_finca','=',$id_finca)
                    ->get();

                    foreach ($tipologia as $key ) {
                        $tipologiaName = $key->nombre_tipologia;
                        $idtipo = $key->id_tipologia;
                        $prenada =$key->prenada;
                        $tcria = $key->tienecria;
                        $criav = $key->criaviva;
                        $ordenho = $key->ordenho;
                        $detectacelo = $key->detectacelo;
                    }   

                    $idTipologiaNueva = $idtipo;
                    $nuevaTipologiaName = $tipologiaName;
                    $prenhada = $prenada;
                    $tienecria = $tcria;
                    $criaViva = $criav;
                    $ordeNho = $ordenho;
                    $detectaCelo = $detectacelo;
                /*
                * Buscamos la fecha del perimer servicio
                */          
                $servicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpserv'))
                ->where('id_serie','=',$id_serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                /*
                * Si tenemos registros buscamos la fecha del primer servicio
                */  
                if ($servicio->count()>0) {
                    #Si existe el servicio buscamo la fecha del primer servicio.
                    foreach ($servicio as $key) {
                        $fechaPrimerServicio = $key->fpserv;    
                    }
                } else {
                    $fechaPrimerServicio = null; 
                }
                # Con la fecha del primer servicio buscamo la tipologia primer servicio
                $tipoPrimerServicio = DB::table('sgservs')
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=',$fechaPrimerServicio)
                ->where('id_finca','=',$id_finca)
                ->get();
                
                if ($tipoPrimerServicio->count()>0) {
                    #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
                    foreach ($tipoPrimerServicio as $key) {
                        $id_tipologia = $key->id_tipologia;
                        $pesops = $key->peso;   
                    }
                    # Con id ubicamos la Tipoloiga en la tabla
                    $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
                    #Obtenemos el Nombre de la Tipologia    
                    $tipops= $tipologia->nombre_tipologia;
                    #Obtenemos el peso que tiene la serie en el primer servicio
                    $pesops = $pesops; 

                } else {
                    $tipops= null; //No existe
                    $pesops = null; //no existe
                } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
                
                # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
                $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
                ->select(DB::raw('MIN(fecser) as fespr'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('toropaj','<>',null)
                ->orWhere('torotemp','<>',null)
                ->get();  
                # Comprobamos si existe el servicio que generó la preñez    
                if ( $servicioPrimerPrenez->count()>0) {
                    #Si existe, obtenemos fecha de primer servicio 
                    foreach ($servicioPrimerPrenez as $key) {
                        $fechasPr = $key->fespr; 
                    }
                } else {
                    $fechasPr = null; 
                }           
                /*
                Con la fechasPr creamos una consulta para verificar 
                si se trata de una preñez por toropajuela o torotempt 
                */
                $prenezHistorico = DB::table('sgprenhez_historicos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecser','=',$fechasPr)
                ->get();  
                # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
                if ($prenezHistorico->count()>0) {
                    foreach ($prenezHistorico as $key) {
                        $toropaj = $key->toropaj;
                        $nomi = $key->nomi;
                        $torotemp = $key->torotemp; 
                    }
                } else {
                    $toropaj = null;
                    $nomi = null;
                    $torotemp = null;
                }
                #Con los valores anteriores identificamos la pajuela
                $pajuela = DB::table('sgpajus')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$toropaj)
                ->get();
                # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
                if ($pajuela->count()>0) {
                    #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
                    $espajuela = 1; 
                    foreach ($pajuela as $key) {
                        $idpaju = $key->id;
                        $razapaju = $key->nombreraza;
                        $fechanac = $key->fnac;
                        $nombrepa = $key->nomb; 
                    }
                    $nombrepadre = $nombrepa;
                    $razapadre = $razapaju;
                    $tipopadre = null;
                    $fechanacpadre = $fechanac;
                } else {
                    #Si no existe la pajuela, sus valores pasan a null.
                    $idpaju = null;
                    $razapaju = null;
                    $fechanac = null;
                    $nombrepa = null;

                    $nombrepadre = $nombrepa;
                    $razapadre = $razapaju;
                    $tipopadre = null;
                    $fechanacpadre = $fechanac;
                    #Como la pajuela no existe entonces marcamos a falso 
                    $espajuela = 0; 
                }
                # Ubicamos si es Toro en caso de existir la Preñez Historico                
                $toro = DB::table('sganims')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$torotemp)
                ->get();
                # Verificamos que el $torotemp exista
                if ($toro->count()>0) {
                    #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
                    $espajuela = 0; 
                    foreach ($toro as $key) {
                        $razatoro = $key->idraza;
                        $idtipo = $key->id_tipologia;
                        $fecnacPadre = $key->fnac;
                    }
                    $raza = \App\Models\sgraza::findOrFail($razatoro);
                    $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
                    
                    $razapadre = $raza->nombreraza;
                    $tipopadre = $tipotoro->nombre_tipologia;
                    $fechanacpadre = $fecnacPadre;
                    $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

                } else {
                    #Si no existe el Toro, entonces se asume que fue una monta natural  
                    $razapadre = null;
                    $tipopadre = null;
                    $fechanacpadre = null;
                    $nombrepadre = null;
                    #Se pasa a falso ya que fue por Monta natural
                    $espajuela = 0;         
                }
                #Actualizamos las variables si proviene de Pajuela o Toro.
                $fechasPr = $fechasPr; 
                $codtpajuela = $toropaj;
                $nomi = $nomi;
                $torotemporada = $torotemp;

                $razapadre = $razapadre;
                $tipopadre = $tipopadre;
                $fechanacpadre = $fechanacpadre;
                $nombrepadre = $nombrepadre;
                /*
                * Ubicamos el primer servicio
                */
                $primerServicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
                /*
                * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
                */
                if ( $primerServicio->count()>0 ) {
                    foreach ($primerServicio as $key) {
                        $fecha = $key->fpservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fecha=null; //no existe;
                }
                # Ubicamosla Edad primer servicio
                $edadPrimerServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fecha)
                ->get();        

                if ($edadPrimerServicio->count()>0) {
                    foreach ($edadPrimerServicio as $key ) {
                        $edadPservicio = $key->edad;
                    }
                } else {
                            $edadPservicio = null; //es decir no existe 
                        }
                /*
                * Ubicamos la fecha del Primer parto
                */  
                $fechaPrimerParto = DB::table('sgpartos')
                ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
                if ($fechaPrimerParto->count()>0) {
                    foreach ($fechaPrimerParto as $key) {
                        $fpParto = $key->fprimerParto; 
                    }               
                } else {
                    $fpParto=null; // no existe
                }                        
                /*
                * La edad del primer Parto
                */
                $edadPrimerParto = DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fpParto)
                ->get();

                if ($edadPrimerParto->count()>0) {
                    foreach ($edadPrimerParto as $key ) {
                        $edadPp = $key->edad; 
                    }
                } else {
                    $edadPp=null; 
                }
                /*
                * Ubicamos El numero de celos por la temporada de monta
                */
                $celos = DB::table('sgcelos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get();

                $nroCelos = $celos->count();    
                /*
                * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
                */
                $fechaPrimerCelo = DB::table('sgcelos')
                ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                //if ( ($fechaPrimerCelo==null) or empty($fechaPrimerCelo) ) {
                if ( $fechaPrimerCelo->count()>0) {

                    foreach ($fechaPrimerCelo as $key) {
                        $fPrimerCelo = $key->fecPrimerCelo;
                    }

                    $fpCelo = $fPrimerCelo;

                    //*************************************************
                        //Se calcula con la herramienta carbon la edad
                    $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
                    $dt = $year*12;
                        //se restan los meses para obtener los meses transcurridos. 
                    $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
                    $edadpc = $year."-".$months;
                    //*************************************************                     
                } else {
                    $fpCelo = null; 
                    $edadpc = null; // no exsite;
                }

                $fechaUltimoCelo = DB::table('sgcelos')
                ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                /*
                * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
                */
                if ( $fechaUltimoCelo->count()>0 ) {

                    foreach ($fechaUltimoCelo as $key) {
                        $fuCelo = $key->fecUltimoCelo;
                    }
                    $fuc = $fuCelo;
                } else {
                    $fuc = null;
                }   
                /*
                * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
                */
                $ultimoCelo = DB::table('sgcelos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->where('fechr','=',$fuc)
                ->get(); 

                if ( ($ultimoCelo->count()>0) ) {
                    foreach ($ultimoCelo as $key ) {
                        $ientcel = $key->dias; 
                    }   
                    $ientcelos = $ientcel;

                } else {
                    $ientcelos= null; 
                }   
                /*
                * Ubicamos el ultimo servicio
                */
                $ultServicio = DB::table('sgservs')
                ->select(DB::raw('MAX(fecha) as fultservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
                if ($ultServicio->count()>0) {
                    foreach ($ultServicio as $key) {
                        $fUltserv = $key->fultservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fUltserv = null; //es decir no existe 
                }
                # Ubicamosla iserv del ultimo servicio
                $intServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fUltserv)
                ->get();        
                if ($intServicio->count()>0 ) {
                    foreach ($intServicio as $key ) {
                        $intEntreServ = $key->iers; 
                    }   
                } else {
                    $intEntreServ=null; //no existe.
                }
                /*
                * Buscamo la preñez actual para saber el tiempo de secado
                */  
                $prenezActual = DB::table('sgprenhezs')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                if ($prenezActual->count()>0) {

                    foreach ($prenezActual as $key ) {
                        # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                        $fechaAproxSecado = $key->fecas; 
                    }   
                } else {
                    $fechaAproxSecado = null; 
                }
                /*
                * Fecha del ultimo parto
                */
                $fechaUltimoParto = DB::table('sgpartos')
                ->select(DB::raw('MAX(fecpar) as fultParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();  
                if ($fechaUltimoParto->count()>0 ) {

                    foreach ($fechaUltimoParto as $key) {
                        $fultParto = $key->fultParto; 
                    }   
                } else {
                    $fultParto=null; //No existe
                }
                $intervaloEntreParto =  DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fultParto)
                ->get();                        
                if ($intervaloEntreParto->count()>0) {
                    foreach ($intervaloEntreParto as $key) {
                        $intentpart = $key->ientpar; 
                    }
                } else {
                        $intentpart = null; //ya que no existe;
                    }
                /*
                * Con esto calculamos los valores IPARPC e IPARPS
                */
                if ( ($intentpart>0) and !($fpCelo==null)  ) {
                    # si el Intervalo entre parto existe.
                    $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
                    $iparpc = $intentpart - $difdias;
                } else {
                    # De lo contrario
                    $iparpc = null; // Es decir no existe 
                }
                
                /********************************************************/
                
                # Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
                $sghprodNuevo = new \App\Models\sghprenhez;

                $sghprodNuevo->id_serie = $id_serie;
                $sghprodNuevo->serie = $series->serie;
                $sghprodNuevo->tipo = $tipoAnterior;

                #Condicion de la madres
                $sghprodNuevo->estado = $condicion->nombre_condicion;
                $sghprodNuevo->raza = $raza->nombreraza;
                $sghprodNuevo->idraza = $raza->idraza;
                
                $sghprodNuevo->edad = $request->edad;
                $sghprodNuevo->nservi = $series->nservi;
                $sghprodNuevo->tipops = $tipops;
                $sghprodNuevo->pesps = $pesops;
                $sghprodNuevo->fecps = $fechaPrimerServicio;
                $sghprodNuevo->edadps = $edadPservicio;

                $sghprodNuevo->fecspr = $fechasPr;
                $sghprodNuevo->codtp = $codtpajuela;
                $sghprodNuevo->respi = $nomi;
                $sghprodNuevo->torotemp = $torotemporada;

                $sghprodNuevo->tipoap = $series->tipoanterior;
                $sghprodNuevo->fecup = $fultParto;
                $sghprodNuevo->edadpp = $edadPp;
                
                #Se registran los datos de abortos en la tabla sghpreñex = sghpro

                $sghprodNuevo->fecabo = $request->freg; //La fecha en que nace la cria
                $sghprodNuevo->causab = $request->causa;
                $sghprodNuevo->aobsab = $request->observacion;
                
                $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;

                $sghprodNuevo->diapr = $retVal;

                #Verificamos si viene el padre es pajuela o torotemporada.
                if (!$codtpajuela==null) {
                    $codpadre = $codtpajuela;
                } else {
                    $codpadre = $torotemporada;
                }
                if (($codtpajuela==null) and ($torotemporada==null)) {
                    $codpadre = null; //Se desconoce el valor del codigo del padre; 
                }

                $sghprodNuevo->codp = $codpadre;
                $sghprodNuevo->razapadre = $razapadre;
                $sghprodNuevo->nombrepadre = $nombrepadre;
                $sghprodNuevo->tipopadre = $tipopadre;
                $sghprodNuevo->fechanacpadre = $fechanacpadre;
                
                $sghprodNuevo->espajuela = $espajuela;

                $sghprodNuevo->fecas = $fechaAproxSecado;

                $sghprodNuevo->ncelos = $nroCelos;
                $sghprodNuevo->fecpc = $fpCelo;
                $sghprodNuevo->edadpc = $edadpc;
                $sghprodNuevo->fecuc = $fuc;

                $sghprodNuevo->ientcel = $ientcelos;
                $sghprodNuevo->iserv = $intEntreServ;
                $sghprodNuevo->ientpar = $intentpart; 

                $sghprodNuevo->iparps = $iparpc;
                $sghprodNuevo->iparpc = $iparpc; 

                $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
                $sghprodNuevo->nciclo = $id_ciclo;
                $sghprodNuevo->id_finca = $id_finca;

                $sghprodNuevo->save(); 

                /* ----------------------------------------------------------
                *  Fin de Actualización Tabla de sghprenez = sghprod
                -----------------------------------------------------------*/       
                $fecsistema = Carbon::now(); 
                /*
                * Se actualiza la tabla mv1 manejo de vientre Cría 1 muerto
                */
                # Segunda Cria 1 muerta mv1
                # Se actualiza la tabla mv1 manejo de vientre para cría muerta                 
                $mv1Nuevo = new \App\Models\sgmv1;

                $mv1Nuevo->codmadre = $request->serie;
                $mv1Nuevo->caso = $caso;
                $mv1Nuevo->fecha = $request->freg;
                $mv1Nuevo->fecs = $fecsistema;
                $mv1Nuevo->id_finca = $id_finca;

                $mv1Nuevo->save();

                /*
                * Aqui Actualizamos la tabla datos de Vida
                */
                $datosDeVidaNuevo = new \App\Models\sgdatosvida;
                
                $datosDeVidaNuevo->seriem = $series->serie;
                $datosDeVidaNuevo->fecha = $request->freg;
                $datosDeVidaNuevo->caso = $caso;

                $datosDeVidaNuevo->nservicios = $series->nservi;
                $datosDeVidaNuevo->pesps = $pesops;
                $datosDeVidaNuevo->edadps = $edadPservicio;
                $datosDeVidaNuevo->codp = $codpadre;
                $datosDeVidaNuevo->edadpp = $edadPp;

                $datosDeVidaNuevo->diapr = $retVal;
                $datosDeVidaNuevo->ncelos = $nroCelos;
                $datosDeVidaNuevo->edadpc = $edadpc;

                $datosDeVidaNuevo->fecas = $fechaAproxSecado;

                $datosDeVidaNuevo->ientpar = $intentpart; 
                $datosDeVidaNuevo->ientcel = $ientcelos;
                $datosDeVidaNuevo->iserv = $intEntreServ;
                $datosDeVidaNuevo->iee = $intentpart;

                $datosDeVidaNuevo->id_finca = $id_finca;

                $datosDeVidaNuevo->save();
                
                /*
                * Buscamos la última fecha de aborto 
                */
                $ultimaFechaAborto = DB::table('sgabors')
                ->select(DB::raw('MAX(fecr) as ultaborto'))
                ->where('serie', '=', $series->serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                /*
                *->| Comprueba el ultimo aborto actualiza el campo fecua en la tabla sganims.  
                */  
                foreach ($ultimaFechaAborto as $key) {
                    $ultabor = $key->ultaborto;
                }   

                $ultimoaborto = DB::table('sganims')
                ->where('id','=',$id_serie)
                ->where('id_finca','=', $id_finca)
                ->update(['fecua'=>$ultabor,
                  'tipo'=>$nuevaTipologiaName,
                  'id_tipologia'=>$idTipologiaNueva,
                  'tipoanterior'=>$tipoAnterior,
                                              #Actualizamos los parametros tipologicos.
                  'prenada'=>$prenhada,
                  'tienecria'=>$tienecria,
                  'criaviva'=>$criaViva,
                  'ordenho'=>$ordeNho,
                  'detectacelo'=>$detectaCelo]);

                return back()->with('msj', 'Registro agregado satisfactoriamente');       

	} // /.fin de Aborto

	public function eliminar_aborto($id_finca, $id, $id_ciclo, $id_serie, $id_aborto)
    {

       $series = \App\Models\sganim::findOrFail($id_serie);

       $abortoEliminar = \App\Models\sgabor::findOrFail($id_aborto);

       $fecha = $abortoEliminar->fecr; 

       try {

        $abortoEliminar->delete();

           	/*
	        * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
	        */
             $countaborto =  DB::table('sgabors')
             ->where('fecr','=',$fecha)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->count(); 

             $nroaborto = DB::table('sghistoricotemprepros')
             ->where('fecharegistro','=',$fecha)
             ->where('id_finca','=', $id_finca)
             ->where('id_ciclo','=', $id_ciclo)
             ->update(['nroabort'=>$countaborto]); 
            /*
            * Recalcular el numero de aborto y actualizar en la tabla sganim
            */
            $ultimaFechaAborto = DB::table('sgabors')
            ->select(DB::raw('MAX(fecr) as ultaborto'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
			/*
			*->| Comprueba el ultimo aborto actualiza el campo Fecha ultimo aborto en la tabla sganims.  
			*/	
			foreach ($ultimaFechaAborto as $key) {
             $ultabor = $key->ultaborto;
         }	
			 /*
            *->| Aqui se debe ubicar la tipologia anterior y actualizar tanto el id como
            * el campo tipo
            */
            $tipoAnterioSerie = $series->tipoanterior;

            $tipologiaAnterior = DB::table('sgtipologias')
            ->where('nombre_tipologia','=',$tipoAnterioSerie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($tipologiaAnterior as $key ) {
               $tipoNombre = $key->nombre_tipologia;
               $idTipo = $key->id_tipologia;
               $prenada = $key->prenada;
               $parida = $key->parida;
               $tienecria = $key->tienecria;
               $criaviva = $key->criaviva;
               $ordenho = $key->ordenho;
               $detectacelo = $key->detectacelo; 
           }       
           $ultimoaborto = DB::table('sganims')
           ->where('id','=',$id_serie)
           ->where('id_finca','=', $id_finca)
           ->update(['fecua'=>$ultabor,
              'nabortoreport'=>$countaborto,
                                               #Actualizamos la tipologia
              'tipo'=>$tipoNombre,
              'id_tipologia'=>$idTipo,
                                              #Actualizamos los parametros tipologicos
              'prenada'=>$prenada,
              'parida'=>$parida,
              'tienecria'=>$tienecria,
              'criaviva'=>$criaviva, 
              'ordenho'=>$ordenho,
              'detectacelo'=>$detectacelo]);	

           return back()->with('mensaje', 'ok');     

       }catch (\Illuminate\Database\QueryException $e){
        return back()->with('mensaje', 'error');
    }

}

public function eliminar_seriemonta($id_finca, $id, $id_ciclo, $id_serie)
{

   $series = \App\Models\sganim::findOrFail($id_serie);

			/*
            * Uicamos la serie en la tabla monta segun el ciclo para 
            * Eliminar su registro.
            */	

            $loteMonta = DB::table('sglotemontas')
            ->where('id_ciclo','=',$id_ciclo)
            ->get();
            # Se guardan los o el id en un array, para mejor fucionaiento        
            foreach ($loteMonta as $key ) {

                $id_lotemonta [] = $key->id_lotemonta;
            }

            $monta = DB::table('sgmontas')
            ->where('id_serie','=',$id_serie)
            ->whereIn('id_lotemonta', $id_lotemonta)
            ->get();

            foreach ($monta as $key) {
               $idmonta = $key->id; 
           }

           $montaEliminar = \App\Models\sgmonta::findOrFail($idmonta);

           try {
             $montaEliminar->delete();      
		            #Aqui le resta una unidad al numero de Monta.
             $nroMonta = $series->nro_monta - 1; 

             $retiroSerie = DB::table('sganims')
             ->where('serie','=',$series->serie)
             ->where('id_finca','=', $id_finca)
             ->update(['ltemp'=>null,
               'monta_activa'=>0,
               'nro_monta'=>$nroMonta]);	
             return back()->with('mensaje', 'ok');        

         }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }

    }
    /*
    *--> Controladores de Parto no Culminado
    */
    public function partonc(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
    {

            //Se busca la finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $temp_reprod = \App\Models\sgtempreprod::findOrFail($id);

        $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

        $usuario = \App\Models\User::all();

        $tipomonta = \App\Models\sgtipomonta::where('id_finca','=',$id_finca)
        ->get();

        $series = \App\Models\sganim::findOrFail($id_serie);

        $condicorpo = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

        $condiCorpoCria = \App\Models\sgcondicioncorporal::all();

        $loteEstrategico = \App\Models\sglote::where('id_finca', '=', $id_finca)
        ->where('tipo', '=', "Estrategico")->get();

            //*************************************************
                //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($series->fnac)->diffInYears(Carbon::now());
                //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
                //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($series->fnac)->diffInMonths(Carbon::now()) - $dt;
                // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
            //*************************************************

        $causamuerte = \App\Models\sgcausamuerte::all(); 

        $raza = \App\Models\sgraza::findOrFail($series->idraza);

        $razacria = \App\Models\sgraza::all(); 

        $celos = \App\Models\sgcelo::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)
        ->paginate(5);

        $parto = \App\Models\sgparto::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->paginate(7);

        $partonc = \App\Models\sgpartosnc::where('id_serie','=',$id_serie)
        ->where('id_ciclo','=',$id_ciclo)
        ->where('id_finca','=',$id_finca)->paginate(7); 

        $causa = \App\Models\sgcausamuerte::all();  
            /*
            * Aquí se obtiene los datos de la última preñez.
            */  
            $ultimaprenez = DB::table('sgprenhezs')  
            ->select(DB::raw('MAX(fregp) as ultprenez'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
            
            foreach ($ultimaprenez as $t ) {
                $ultpre = $t->ultprenez;
            }
            /*
            *-> Se crea un identificador para saber si la serie se le ha practicado
            * un servicio en menos de 90 días.
            */  
            $servicioReciente = DB::table('sgservs')  
            ->select(DB::raw('MAX(fecha) as ultservicio'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($servicioReciente as $key) {
                $ultservicio = $key->ultservicio;
            }       
            

            /*
            * Se calcula el tiempo del ciclo de monta $tm = Tiempo de monta
            */  
            $tm = Carbon::parse($ciclo->fechainicialciclo)->diffInDays($ciclo->fechafinalciclo);
            /*
            * Con el Valor de la feha del ultimo servicio se calcula la diferencia en días 
            * con Carbon y ver si está dentro del tipo del ciclo monta 
            */
            $diasServicio = Carbon::parse($ultservicio)->diffInDays(Carbon::now());

            if (!($ultservicio==null) and $diasServicio<$tm) {
                $servicioActivo = 1;
            } else {
                $servicioActivo = 0;
            }
            /*
            * Con esto obtenermos el parametro tiempo de gestacion
            */
            $pR = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pR as $key) {
                //$tgesta = Tiempo de Gestación (días)
                $tgesta = $key->tiempogestacion; 
            }

            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pP = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pP as $key) {
                //$tgesta = Tiempo de Gestación (días)
                $tsecado = $key->diassecado; 
            }   

            /*
            * Se calcula el tiempo de preñez, ya que existe, es decir, verificar que la preñez no sea  antigua para que se registre una preñez nueva
            */
            $tp = Carbon::parse($ultpre)->diffInDays(Carbon::now());  
            /*
            *Aquí se comprueba que exista un registro de preñez para poder
            *registrar parto.   
            */
            if (empty($ultpre) or ($ultpre==null)) {

                return back()->with('info', 'ok');
                
            } else {

                if ($tp>$tgesta) {
                    return back()->with('info', 'oka');
                } else {
                    if ($tp<$tgesta) {
                    //return back()->with('info', 'int');
                        $prenhez = \App\Models\sgprenhez::where('fregp','=',$ultpre)
                        ->where('serie', '=', $series->serie)
                        ->where('id_finca','=',$id_finca)
                        ->get();
                        
                        foreach ($prenhez as $key) {
                            $ieep = $key->intestpar;
                            $ida = $key->intdiaabi;
                            $festipre = $key->fepre;
                            $faprosecado = $key->fecas; 
                            $faproparto = $key->fecap;
                            $diasprenez = $key->dias_prenez;
                            $mesesprenez = $key->mesespre;
                        }

                        return view('reproduccion.formulario_partonc', compact('ciclo','finca', 'temp_reprod',
                            'tipomonta','edad','celos','series','usuario','raza','condicorpo','prenhez','diasServicio', 'tgesta','tsecado','servicioActivo', 'ieep','ida','festipre','faprosecado','faprosecado','faproparto','diasprenez','mesesprenez','razacria','condiCorpoCria','loteEstrategico','parto','causamuerte','partonc','causa'));
                    }
                }
            }

        }

        public function crear_partonc(Request $request, $id_finca, $id, $id_ciclo, $id_serie)
        {
            //return $request; 

            $ciclo = \App\Models\sgciclo::findOrFail($id_ciclo);

            $tipomonta = \App\Models\sgtipomonta::findOrFail($ciclo->id_tipomonta);

            $series = \App\Models\sganim::findOrFail($id_serie);

            $condicion = \App\Models\sgcondicioncorporal::findOrFail($series->id_condicion);

            $raza = \App\Models\sgraza::findOrFail($series->idraza);

                # Validamos los campos que utilizaremos

            $request->validate([
                'freg'=> [
                    'required',
                 // 'unique:sgtempreprods,nombre,NULL,NULL,id_finca,'. $id_finca,
                ],
                'causa'=> [
                    'required',
                ],
                'observacion'=> [
                    'required',
                ],
            ]);
            
            if (!($request->mesesprenez==null)) {
                $diap = $request->mesesprenez/30;//Es para llevar los meses a días. 
            } else {
                $diap = $request->diaprenez;
            }
                /*
                * -> Guardamos en la tabla de Abortos los registros del form. 
                */   
                $caso = "Parto No Concluido"; //hardcod

                $partoncNuevo = new \App\Models\sgpartosnc;

                $partoncNuevo->id_serie = $id_serie;
                $partoncNuevo->serie = $request->serie;
                $partoncNuevo->fecregistro = $request->freg;
                $partoncNuevo->diaprenez = $diap;
                $partoncNuevo->trimestre = $request->trimestre;
                $partoncNuevo->causa = $request->causa;
                $partoncNuevo->obser = $request->observacion;

                $partoncNuevo->id_ciclo = $id_ciclo;
                $partoncNuevo->id_finca = $id_finca;

                try{
                    $partoncNuevo-> save();
                #Se Cambian los parametros tipologicos para cambio e tipologia
                    $pario = 1;  
                    $tienesucria = 1; 
                    $crianacioviva = 0; 
                    $prenez = 0;    
                }catch (\Illuminate\Database\QueryException $e){
                #Se devuelven los cambios en caso de haber un error.
                    $pario = 0;  
                    $tienesucria = 0;
                    $crianacioviva = 0; 
                    $prenez = 1;
                    return back()->with('mensaje', 'error');
                }   
                /*
                * Se cuentan la cantidad de partos no concluidos que se registran a la fecha 
                */
                $countpnc =  DB::table('sgpartosncs')
                ->where('fecregistro','=',$request->freg)
                ->where('id_finca','=', $id_finca)
                ->where('id_ciclo','=', $id_ciclo)
                ->count(); 

                $nropartnc = DB::table('sghistoricotemprepros')
                ->where('fecharegistro','=',$request->freg)
                ->where('id_finca','=', $id_finca)
                ->where('id_ciclo','=', $id_ciclo)
                ->update(['nropartnc'=>$countpnc]);  
                /*
                * Aqui actualizamos la Tipologia en caso de una parto no concluido
                * ya que es un proceso que conlleva a eso.
                */
                #Buscamos la tipologia actual 
                $tipoActual = \App\Models\sgtipologia::where('id_tipologia','=',$series->id_tipologia)->get();

                #Obtenemos todos parametros de la tipologia
                foreach ($tipoActual as $key ) {
                    $tipologiaName = $key->nombre_tipologia;
                    $edad = $key->edad;
                    $peso = $key->peso;
                    $destetado = $key->destetado;
                    $sexo = $key->sexo;
                    $nro_monta = $key->nro_monta;
                    $prenada = $key->prenada;
                    $parida = $key->parida;
                    $tienecria = $key->tienecria;
                    $criaviva = $key->criaviva;
                    $ordenho = $key->ordenho;
                    $detectacelo = $key->detectacelo;
                    $idtipo = $key->id_tipologia;
                }
                
                #Actualizamos la tipologia
                #Obtenemos la tipologia anterior
                $tipoAnterior = $tipologiaName;
                $nroMonta = $series->nro_monta;

                # Actualizamos si se efectua el parto.
                $tipologia= DB::table('sgtipologias')
                ->where('edad','=',$edad)
                ->where('peso','=',$peso)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$sexo)
                    ->where('nro_monta','<=',$nroMonta) //Revisar aqui
                    ->where('prenada','=',$prenez)
                    ->where('parida','=',$pario)
                    ->where('tienecria','=',$tienesucria)
                    ->where('criaviva','=',$crianacioviva)
                    ->where('ordenho','=',$ordenho)
                    ->where('detectacelo','=',$detectacelo)
                    ->where('id_finca','=',$id_finca)
                    ->get();

                    foreach ($tipologia as $key ) {
                        $tipologiaName = $key->nombre_tipologia;
                        $idtipo = $key->id_tipologia;
                        $prenada =$key->prenada;
                        $tcria = $key->tienecria;
                        $criav = $key->criaviva;
                        $ordenho = $key->ordenho;
                        $detectacelo = $key->detectacelo;
                    }   

                    $idTipologiaNueva = $idtipo;
                    $nuevaTipologiaName = $tipologiaName;
                    $prenhada = $prenada;
                    $tienecria = $tcria;
                    $criaViva = $criav;
                    $ordeNho = $ordenho;
                    $detectaCelo = $detectacelo;

                /*
                * Buscamos la fecha del perimer servicio
                */          
                $servicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpserv'))
                ->where('id_serie','=',$id_serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                /*
                * Si tenemos registros buscamos la fecha del primer servicio
                */  
                if ($servicio->count()>0) {
                    #Si existe el servicio buscamo la fecha del primer servicio.
                    foreach ($servicio as $key) {
                        $fechaPrimerServicio = $key->fpserv;    
                    }
                } else {
                    $fechaPrimerServicio = null; 
                }
                # Con la fecha del primer servicio buscamo la tipologia primer servicio
                $tipoPrimerServicio = DB::table('sgservs')
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=',$fechaPrimerServicio)
                ->where('id_finca','=',$id_finca)
                ->get();
                
                if ($tipoPrimerServicio->count()>0) {
                    #Con la fecha del primer servicio obtenemos el ID de la tipologia Primer Servicio
                    foreach ($tipoPrimerServicio as $key) {
                        $id_tipologia = $key->id_tipologia;
                        $pesops = $key->peso;   
                    }
                    # Con id ubicamos la Tipoloiga en la tabla
                    $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
                    #Obtenemos el Nombre de la Tipologia    
                    $tipops= $tipologia->nombre_tipologia;
                    #Obtenemos el peso que tiene la serie en el primer servicio
                    $pesops = $pesops; 

                } else {
                    $tipops= null; //No existe
                    $pesops = null; //no existe
                } #Fin ./ Tipologia y Edad Cuando se realizó el primer servicio
                
                # Aquí buscamos la fecha del primer servicio donde se generó la preñez  
                $servicioPrimerPrenez = DB::table('sgprenhez_historicos')
                ->select(DB::raw('MIN(fecser) as fespr'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('toropaj','<>',null)
                ->orWhere('torotemp','<>',null)
                ->get();  
                # Comprobamos si existe el servicio que generó la preñez    
                if ( $servicioPrimerPrenez->count()>0) {
                    #Si existe, obtenemos fecha de primer servicio 
                    foreach ($servicioPrimerPrenez as $key) {
                        $fechasPr = $key->fespr; 
                    }
                } else {
                    $fechasPr = null; 
                }           
                /*
                Con la fechasPr creamos una consulta para verificar 
                si se trata de una preñez por toropajuela o torotempt 
                */
                $prenezHistorico = DB::table('sgprenhez_historicos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecser','=',$fechasPr)
                ->get();  
                # Si existe la preñez, ubicamos el valor de Toropaj, Nomi, ToroTemp.    
                if ($prenezHistorico->count()>0) {
                    foreach ($prenezHistorico as $key) {
                        $toropaj = $key->toropaj;
                        $nomi = $key->nomi;
                        $torotemp = $key->torotemp; 
                    }
                } else {
                    $toropaj = null;
                    $nomi = null;
                    $torotemp = null;
                }
                #Con los valores anteriores identificamos la pajuela
                $pajuela = DB::table('sgpajus')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$toropaj)
                ->get();

                # Si la pajuela existe ubicamos sus datos como id, raza, fech nac. Nombre Padre         
                if ($pajuela->count()>0) {
                    #Como la pajuela existe entonces marcamos a verdadero que se trata de una pajuela
                    $espajuela = 1; 
                    foreach ($pajuela as $key) {
                        $idpaju = $key->id;
                        $razapaju = $key->nombreraza;
                        $fechanac = $key->fnac;
                        $nombrepa = $key->nomb; 
                    }
                    $nombrepadre = $nombrepa;
                    $razapadre = $razapaju;
                    $tipopadre = null;
                    $fechanacpadre = $fechanac;
                } else {
                    #Si no existe la pajuela, sus valores pasan a null.
                    $idpaju = null;
                    $razapaju = null;
                    $fechanac = null;
                    $nombrepa = null;

                    $nombrepadre = $nombrepa;
                    $razapadre = $razapaju;
                    $tipopadre = null;
                    $fechanacpadre = $fechanac;
                    #Como la pajuela no existe entonces marcamos a falso 
                    $espajuela = 0; 
                }
                # Ubicamos si es Toro en caso de existir la Preñez Historico                
                $toro = DB::table('sganims')
                ->where('id_finca','=',$id_finca)
                ->where('serie','=',$torotemp)
                ->get();
                # Verificamos que el $torotemp exista
                if ($toro->count()>0) {
                    #Si Toro existe entonces marcamos a falso ya que se trata de un Toro
                    $espajuela = 0; 
                    foreach ($toro as $key) {
                        $razatoro = $key->idraza;
                        $idtipo = $key->id_tipologia;
                        $fecnacPadre = $key->fnac;
                    }
                    $raza = \App\Models\sgraza::findOrFail($razatoro);
                    $tipotoro = \App\Models\sgtipologia::findOrFail($idtipo);
                    
                    $razapadre = $raza->nombreraza;
                    $tipopadre = $tipotoro->nombre_tipologia;
                    $fechanacpadre = $fecnacPadre;
                    $nombrepadre = null; //el nombre del padre no existe en la tabla sganims

                } else {
                    #Si no existe el Toro, entonces se asume que fue una monta natural  
                    $razapadre = null;
                    $tipopadre = null;
                    $fechanacpadre = null;
                    $nombrepadre = null;
                    #Se pasa a falso ya que fue por Monta natural
                    $espajuela = 0;         
                }
                #Actualizamos las variables si proviene de Pajuela o Toro.
                $fechasPr = $fechasPr; 
                $codtpajuela = $toropaj;
                $nomi = $nomi;
                $torotemporada = $torotemp;

                $razapadre = $razapadre;
                $tipopadre = $tipopadre;
                $fechanacpadre = $fechanacpadre;
                $nombrepadre = $nombrepadre;
                /*
                * Ubicamos el primer servicio
                */
                $primerServicio = DB::table('sgservs')
                ->select(DB::raw('MIN(fecha) as fpservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
                /*
                * Comprueba que el Primer servicio exista para darnos la edad sino pasa a null.
                */
                if ( $primerServicio->count()>0 ) {
                    foreach ($primerServicio as $key) {
                        $fecha = $key->fpservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fecha=null; //no existe;
                }
                # Ubicamosla Edad primer servicio
                $edadPrimerServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fecha)
                ->get();        

                if ($edadPrimerServicio->count()>0) {
                    foreach ($edadPrimerServicio as $key ) {
                        $edadPservicio = $key->edad;
                    }
                } else {
                            $edadPservicio = null; //es decir no existe 
                        }
                /*
                * Ubicamos la fecha del Primer parto
                */  
                $fechaPrimerParto = DB::table('sgpartos')
                ->select(DB::raw('MIN(fecpar) as fprimerParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                
                if ($fechaPrimerParto->count()>0) {
                    foreach ($fechaPrimerParto as $key) {
                        $fpParto = $key->fprimerParto; 
                    }               
                } else {
                    $fpParto=null; // no existe
                }                        
                /*
                * La edad del primer Parto
                */
                $edadPrimerParto = DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fpParto)
                ->get();

                if ($edadPrimerParto->count()>0) {
                    foreach ($edadPrimerParto as $key ) {
                        $edadPp = $key->edad; 
                    }
                } else {
                    $edadPp=null; 
                }
                /*
                * Ubicamos El numero de celos por la temporada de monta
                */
                $celos = DB::table('sgcelos')
                ->where('id_finca','=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get();

                $nroCelos = $celos->count();    
                /*
                * Ubicamos fecha del primer celo y la edad que se tenia en el primer celo
                */
                $fechaPrimerCelo = DB::table('sgcelos')
                ->select(DB::raw('MIN(fechr) as fecPrimerCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                //if ( ($fechaPrimerCelo==null) or empty($fechaPrimerCelo) ) {
                if ( $fechaPrimerCelo->count()>0) {

                    foreach ($fechaPrimerCelo as $key) {
                        $fPrimerCelo = $key->fecPrimerCelo;
                    }

                    $fpCelo = $fPrimerCelo;

                    //*************************************************
                        //Se calcula con la herramienta carbon la edad
                    $year = Carbon::parse($series->fnac)->diffInYears($fpCelo);
                        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
                    $dt = $year*12;
                        //se restan los meses para obtener los meses transcurridos. 
                    $months = Carbon::parse($series->fnac)->diffInMonths($fpCelo) - $dt;
                        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
                    $edadpc = $year."-".$months;
                    //*************************************************                     
                } else {
                    $fpCelo = null; 
                    $edadpc = null; // no exsite;
                }

                $fechaUltimoCelo = DB::table('sgcelos')
                ->select(DB::raw('MAX(fechr) as fecUltimoCelo'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                /*
                * Comprobamos si el ultimo celo existe que lo entrege sino que sea null
                */
                if ( $fechaUltimoCelo->count()>0 ) {

                    foreach ($fechaUltimoCelo as $key) {
                        $fuCelo = $key->fecUltimoCelo;
                    }
                    $fuc = $fuCelo;
                } else {
                    $fuc = null;
                }   
                /*
                * Con ultimo celo buscamos el ultimo Intervalo de Celo registrado.
                */
                $ultimoCelo = DB::table('sgcelos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_ciclo','=',$id_ciclo)
                ->where('id_serie','=',$id_serie)
                ->where('fechr','=',$fuc)
                ->get(); 

                if ( ($ultimoCelo->count()>0) ) {
                    foreach ($ultimoCelo as $key ) {
                        $ientcel = $key->dias; 
                    }   
                    $ientcelos = $ientcel;

                } else {
                    $ientcelos= null; 
                }   
                /*
                * Ubicamos el ultimo servicio
                */
                $ultServicio = DB::table('sgservs')
                ->select(DB::raw('MAX(fecha) as fultservicio'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();
                if ($ultServicio->count()>0) {
                    foreach ($ultServicio as $key) {
                        $fUltserv = $key->fultservicio;
                    }
                } else {
                    # No tiene servicio creado
                    $fUltserv = null; //es decir no existe 
                }
                # Ubicamosla iserv del ultimo servicio
                $intServicio = DB::table('sgservs')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecha','=', $fUltserv)
                ->get();        
                if ($intServicio->count()>0 ) {
                    foreach ($intServicio as $key ) {
                        $intEntreServ = $key->iers; 
                    }   
                } else {
                    $intEntreServ=null; //no existe.
                }
                /*
                * Buscamo la preñez actual para saber el tiempo de secado
                */  
                $prenezActual = DB::table('sgprenhezs')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get(); 
                if ($prenezActual->count()>0) {

                    foreach ($prenezActual as $key ) {
                        # Obtenemos la informacion de prenez para este caso utilizaremos la fecas
                        $fechaAproxSecado = $key->fecas; 
                    }   
                } else {
                    $fechaAproxSecado = null; 
                }
                /*
                * Fecha del ultimo parto
                */
                $fechaUltimoParto = DB::table('sgpartos')
                ->select(DB::raw('MAX(fecpar) as fultParto'))
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->get();  
                if ($fechaUltimoParto->count()>0 ) {

                    foreach ($fechaUltimoParto as $key) {
                        $fultParto = $key->fultParto; 
                    }   
                } else {
                    $fultParto=null; //No existe
                }
                $intervaloEntreParto =  DB::table('sgpartos')
                ->where('id_finca', '=',$id_finca)
                ->where('id_serie','=',$id_serie)
                ->where('fecpar','=',$fultParto)
                ->get();                        
                if ($intervaloEntreParto->count()>0) {
                    foreach ($intervaloEntreParto as $key) {
                        $intentpart = $key->ientpar; 
                    }
                } else {
                        $intentpart = null; //ya que no existe;
                    }
                /*
                * Con esto calculamos los valores IPARPC e IPARPS
                */
                if ( ($intentpart>0) and !($fpCelo==null)  ) {
                    # si el Intervalo entre parto existe.
                    $difdias = Carbon::parse($fpCelo)->diffInDays($fultParto);
                    $iparpc = $intentpart - $difdias;
                } else {
                    # De lo contrario
                    $iparpc = null; // Es decir no existe 
                }
                
                /********************************************************/
                
                # Se actualiza la tabla de Sghprenhez = sghpro, por cada parto que se realiza 
                $sghprodNuevo = new \App\Models\sghprenhez;

                $sghprodNuevo->id_serie = $id_serie;
                $sghprodNuevo->serie = $series->serie;
                $sghprodNuevo->tipo = $tipoAnterior;

                #Condicion de la madres
                $sghprodNuevo->estado = $condicion->nombre_condicion;
                $sghprodNuevo->raza = $raza->nombreraza;
                $sghprodNuevo->idraza = $raza->idraza;
                
                $sghprodNuevo->edad = $request->edad;
                $sghprodNuevo->nservi = $series->nservi;
                $sghprodNuevo->tipops = $tipops;
                $sghprodNuevo->pesps = $pesops;
                $sghprodNuevo->fecps = $fechaPrimerServicio;
                $sghprodNuevo->edadps = $edadPservicio;

                $sghprodNuevo->fecspr = $fechasPr;
                $sghprodNuevo->codtp = $codtpajuela;
                $sghprodNuevo->respi = $nomi;
                $sghprodNuevo->torotemp = $torotemporada;

                $sghprodNuevo->tipoap = $series->tipoanterior;
                $sghprodNuevo->fecup = $fultParto;
                $sghprodNuevo->edadpp = $edadPp;
                
                #Se registran los datos de abortos en la tabla sghpreñex = sghpro

                $sghprodNuevo->fecregpnc = $request->freg; //La fecha en que nace la cria
                $sghprodNuevo->causapnc = $request->causa;
                $sghprodNuevo->observpnc = $request->observacion;
                
                $retVal = (!($request->mesesprenez==null))? ($request->mesesprenez*30) : $request->dias_prenez;

                $sghprodNuevo->diapr = $retVal;

                #Verificamos si viene el padre es pajuela o torotemporada.
                if (!$codtpajuela==null) {
                    $codpadre = $codtpajuela;
                } else {
                    $codpadre = $torotemporada;
                }
                if (($codtpajuela==null) and ($torotemporada==null)) {
                    $codpadre = null; //Se desconoce el valor del codigo del padre; 
                }

                $sghprodNuevo->codp = $codpadre;
                $sghprodNuevo->razapadre = $razapadre;
                $sghprodNuevo->nombrepadre = $nombrepadre;
                $sghprodNuevo->tipopadre = $tipopadre;
                $sghprodNuevo->fechanacpadre = $fechanacpadre;
                
                $sghprodNuevo->espajuela = $espajuela;

                $sghprodNuevo->fecas = $fechaAproxSecado;

                $sghprodNuevo->ncelos = $nroCelos;
                $sghprodNuevo->fecpc = $fpCelo;
                $sghprodNuevo->edadpc = $edadpc;
                $sghprodNuevo->fecuc = $fuc;

                $sghprodNuevo->ientcel = $ientcelos;
                $sghprodNuevo->iserv = $intEntreServ;
                $sghprodNuevo->ientpar = $intentpart; 

                $sghprodNuevo->iparps = $iparpc;
                $sghprodNuevo->iparpc = $iparpc; 

                $sghprodNuevo->id_temp_repr = $id; //Se guarda la temporada de reproduccion.
                $sghprodNuevo->nciclo = $id_ciclo;
                $sghprodNuevo->id_finca = $id_finca;

                $sghprodNuevo->save(); 

                /* ----------------------------------------------------------
                *  Fin de Actualización Tabla de sghprenez = sghprod
                -----------------------------------------------------------*/       
                $fecsistema = Carbon::now(); 
                /*
                * Se actualiza la tabla mv1 manejo de vientre parto no concluido
                */
                $mv1Nuevo = new \App\Models\sgmv1;

                $mv1Nuevo->codmadre = $request->serie;
                $mv1Nuevo->caso = $caso;
                $mv1Nuevo->fecha = $request->freg;
                $mv1Nuevo->fecs = $fecsistema;
                $mv1Nuevo->id_finca = $id_finca;

                $mv1Nuevo->save();

                /*
                * Aqui Actualizamos la tabla datos de Vida
                */
                $datosDeVidaNuevo = new \App\Models\sgdatosvida;
                
                $datosDeVidaNuevo->seriem = $series->serie;
                $datosDeVidaNuevo->fecha = $request->freg;
                $datosDeVidaNuevo->caso = $caso;

                $datosDeVidaNuevo->nservicios = $series->nservi;
                $datosDeVidaNuevo->pesps = $pesops;
                $datosDeVidaNuevo->edadps = $edadPservicio;
                $datosDeVidaNuevo->codp = $codpadre;
                $datosDeVidaNuevo->edadpp = $edadPp;

                $datosDeVidaNuevo->diapr = $retVal;
                $datosDeVidaNuevo->ncelos = $nroCelos;
                $datosDeVidaNuevo->edadpc = $edadpc;

                $datosDeVidaNuevo->fecas = $fechaAproxSecado;

                $datosDeVidaNuevo->ientpar = $intentpart; 
                $datosDeVidaNuevo->ientcel = $ientcelos;
                $datosDeVidaNuevo->iserv = $intEntreServ;
                $datosDeVidaNuevo->iee = $intentpart;

                $datosDeVidaNuevo->id_finca = $id_finca;

                $datosDeVidaNuevo->save();
                
                /*
                * Buscamos la última fecha de parto no concluido 
                */
                $ultimoPartoNc = DB::table('sgpartosncs')
                ->select(DB::raw('MAX(fecregistro) as ultopartonc'))
                ->where('serie', '=', $series->serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                /*
                *->| Comprueba el ultimo aborto actualiza el campo fecua en la tabla sganims.  
                */  
                foreach ($ultimoPartoNc as $key) {
                    $ultpartonc = $key->ultopartonc;
                }
                /*
                * Buscamos la cantidad de parto no concluidos para la serie y actualizamos la 
                * tabla sganims
                */
                $NroPartoNc = DB::table('sgpartosncs')
                ->where('serie', '=', $series->serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                #obtenemos el nro de parto no concluido para la serie y actualizamos sganims
                $npartonc = $NroPartoNc->count();

                $ultimopartonc = DB::table('sganims')
                ->where('id','=',$id_serie)
                ->where('id_finca','=', $id_finca)
                ->update(['fecupartonc'=>$ultpartonc,
                  'npartonc'=>$npartonc,  
                  'tipo'=>$nuevaTipologiaName,
                  'id_tipologia'=>$idTipologiaNueva,
                  'tipoanterior'=>$tipoAnterior,    
                                              #Actualizamos los parametros tipologicos.
                  'prenada'=>$prenhada,
                  'tienecria'=>$tienecria,
                  'criaviva'=>$criaViva,
                  'ordenho'=>$ordeNho,
                  'detectacelo'=>$detectaCelo]);

                return back()->with('msj', 'Registro agregado satisfactoriamente');       

    } // /.fin de Aborto

    public function eliminar_partonc($id_finca, $id, $id_ciclo, $id_serie, $id_partonc)
    {

        $series = \App\Models\sganim::findOrFail($id_serie);

        $partoncEliminar = \App\Models\sgpartosnc::findOrFail($id_partonc);

        $fecha = $partoncEliminar->fecregistro; 

        try {

            $partoncEliminar->delete();

            /*
            * Se cuentan la cantidad de prenez que se registran a la fecha por la fecha de registro.
            */
            $countpartonc =  DB::table('sgpartosncs')
            ->where('fecregistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->count(); 

            $nropartonc = DB::table('sghistoricotemprepros')
            ->where('fecharegistro','=',$fecha)
            ->where('id_finca','=', $id_finca)
            ->where('id_ciclo','=', $id_ciclo)
            ->update(['nropartnc'=>$countpartonc]); 
            /*
            * Recalcular el numero de parto no culminado y actualizar en la tabla sganim
            */
            $ultimoPartoNoCulminado = DB::table('sgpartosncs')
            ->select(DB::raw('MAX(fecregistro) as ultpartonc'))
            ->where('serie', '=', $series->serie)
            ->where('id_finca','=',$id_finca)
            ->get();
            /*
            *->| Comprueba el ultimo parto no culminado  y actualiza el campo Fecha 
            * en la tabla sganims.  
            */  
            foreach ($ultimoPartoNoCulminado as $key) {
                $ultpnc = $key->ultpartonc;
            }   
            /*
            *->| Aqui se debe ubicar la tipologia anterior y actualizar tanto el id como
            * el campo tipo
            */
            $tipoAnterioSerie = $series->tipoanterior;

            $tipologiaAnterior = DB::table('sgtipologias')
            ->where('nombre_tipologia','=',$tipoAnterioSerie)
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($tipologiaAnterior as $key ) {
               $tipoNombre = $key->nombre_tipologia;
               $idTipo = $key->id_tipologia;
               $prenada = $key->prenada;
               $parida = $key->parida;
               $tienecria = $key->tienecria;
               $criaviva = $key->criaviva;
               $ordenho = $key->ordenho;
               $detectacelo = $key->detectacelo; 
           }       

           $ultimopnc = DB::table('sganims')
           ->where('id','=',$id_serie)
           ->where('id_finca','=', $id_finca)
           ->update(['fecupartonc'=>$ultpnc,
              'npartonc'=>$countpartonc,
                                          #Actualizamos la tipologia
              'tipo'=>$tipoNombre,
              'id_tipologia'=>$idTipo,
                                          #Actualizamos los parametros tipologicos
              'prenada'=>$prenada,
              'parida'=>$parida,
              'tienecria'=>$tienecria,
              'criaviva'=>$criaviva, 
              'ordenho'=>$ordenho,
              'detectacelo'=>$detectacelo]);  

           return back()->with('mensaje', 'ok');     

       }catch (\Illuminate\Database\QueryException $e){
        return back()->with('mensaje', 'error');
    }

}




}
