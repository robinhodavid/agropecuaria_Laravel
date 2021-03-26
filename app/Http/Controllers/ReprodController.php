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

        public function cierre_temporada(Request $request, $id, $id_finca)
        {
            
           
            $temporadaCierre = \App\Models\sgtempreprod::findOrFail($id);

            $fechacierre = Carbon::now()->format('Y-m-d');

            $temporadaCierre->fecdefcierre = $fechacierre;
            
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
            
            
            $request->validate([
                'ciclo'=> [
                    'required',
                    'unique:sgciclos,ciclo,NULL,NULL,id_temp_reprod,'. $id,
                ],
                'tipomonta'=> [
                    'required',
                ],
            ]);
            
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

            $cicloUpdate = \App\Models\sgciclo::findOrFail($id_ciclo);

            $cicloUpdate->ciclo = $request->ciclo;
            $cicloUpdate->fechainicialciclo = $request->fechainicialciclo;
            $cicloUpdate->fechafinalciclo = $request->fechafinalciclo;
            $cicloUpdate->duracion = $request->duracion;
            $cicloUpdate->id_temp_reprod = $id;
            $cicloUpdate->id_finca = $id_finca;

            $cicloUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

        public function eliminar_ciclo($id_finca, $id, $id_ciclo)
        {
            

            $cicloEliminar = \App\Models\sgciclo::findOrFail($id_ciclo);
                
            try {
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

    		/*
    		* Fin de corrida rango de fecha.
    		*/

    		$historicoTemporada = \App\Models\sghistoricotemprepro::where('id_ciclo', '=', $id_ciclo)
		        ->where('fecharegistro', '>=', $comienzo) 
		        ->where('id_finca', '=', $id_finca)->get(); 

		    $seriesparareproduccion = DB::table('sgmontas')
		     	->join('sglotemontas','sglotemontas.id_lotemonta','=','sgmontas.id_lotemonta')
		     	->join('sganims','sganims.id','=','sgmontas.id_serie')
		     	//->select('sgmontas.serie','sgmontas.finim','sganims.tipo',DB::raw('count(*) as series_en_lote, sgmontas.id_lotemonta'))
		     	->where('sglotemontas.id_ciclo','=',$id_ciclo)
		     	//->groupBy('sgmontas.id_lotemonta','sgmontas.serie','sgmontas.finim','sganims.tipo')
		     	//->orderBy('sgmontas.id_lotemonta','ASC')
		     	->get();    

		    
			//return $seriesparareproduccion; 
		     

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


			if ($ciclo->id_tipomonta == 1) {
				# Si se  trata de una inseminación artificial, solo se muestra las hembras que seran
				# fertilizadas.
				//return ("Es Insiminación");
				if (! empty($request->serie) ) {
            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->where('sganims.destatado','=',1)
		                ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(7)->paginate(7);
        		} else {

            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->where('sganims.destatado','=',1)
		                ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(7)->paginate(7);
        		}

			}

			if ($ciclo->id_tipomonta == 2) {
				#Se trata de una reproduccion con ambos métodos
				//return ("Es Mixta");

				if (! empty($request->serie) ) {
            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		               // ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
/*	*/
        		} else {

            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		             //   ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
        		}	


			}

			if ($ciclo->id_tipomonta == 3) {
				# Se trata de una reproduccion basado en el método natural
				# Aquí el Animal detecta el momento exacto del celo para realizar la monta

				if (! empty($request->serie) ) {
            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		               // ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
/*	*/
        		} else {

            		$seriesrepro = DB::table('sganims')
		            	->select('sganims.id','sganims.serie','sganims.codmadre','sgtipologias.nomenclatura','sgtipologias.nombre_tipologia','sganims.edad', 'sganims.pesoactual','sganims.pesoactual','sganims.sexo','sganims.nombrelote', 'sganims.sub_lote')
		                ->where('sganims.status', '=', 1)
		                ->WhereNull('sganims.monta_activa') 
		                ->orWhere('sganims.monta_activa', '=', 0) //Mostrara todas las series que no están en TM
		                ->where('sganims.destatado','=',1)
		             //   ->where('sganims.sexo','=',0) //Sexo = hembra
		                ->where('sganims.id_finca', '=', $finca->id_finca)
		                ->where('sganims.serie', 'like', $request->serie."%")
		                ->join('sgtipologias', 'sgtipologias.id_tipologia','=','sganims.id_tipologia')
		                ->take(10)->paginate(10);
        		}	
			}
			    
			$fechanow= Carbon::now()->format('Y-m-d');

			//dd($fechanow);

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
		        
    			//return $monta; 
        
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

            	$nombrelote = \App\Models\sglote::findOrFail($request->lote); 

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

                    $asignarserielotemonta = DB::table('sganims')
                                    ->where('id',$request->id[$i])
                                    ->where('id_finca', $finca->id_finca)
                                    ->update(['ltemp'=>$nombrelote->nombre_lote,
                                	'monta_activa'=>$montaActiva]);    
    			}   
    				
    	       return back()->with('msj', 'Serie (s) asignada satisfactoriamente');
    	    }  
/*
******************************************************************
		---|> CONTROLES PARA CADA PORCESO DE MONTA <|---	
******************************************************************
*/

	public function formulario_registros_monta(Request $request, $id_finca, $id, $id_ciclo)
        {
  			  
        	
       
        	//dd($id_ciclo);
        	//return $request; 

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
    		
    		/*
    		*
    		*/

			/*$series = \App\Models\sganim::select('id','serie')
                          ->whereIn('id', $request->ids)->get();
*/
            $series = \App\Models\sganim::whereIn('id', $request->ids)->get();

			//return $series;   



    		if ($request->opcion==1) {
        		 return view('reproduccion.formulario_celos', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion','series'));
        	
        	} elseif ($request->opcion==2) {
        		//return "Aquí va el registro de Servicio";
        		return view('reproduccion.formulario_servicio', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion'));
        	
        	} elseif ($request->opcion== 3) {
        		return "Aquí va el registro de Palpaciones";
        	
        	} elseif ($request->opcion== 4) {
        			return "Aquí va el registro de Preñez";
        	
        	} elseif ($request->opcion== 5) {
        					return "Aquí va el registro de parto";
        	
        	} elseif ($request->opcion== 6) {
        					return "Aquí va el registro de Aborto";				
        	}



            return view('reproduccion.formulario_celos', compact('ciclo','finca', 'temp_reprod','lote','sublote','tipomonta','fechafin','duracion'));
        }
    	    


}
