<?php

namespace App\Http\Controllers;


use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models;
use App\Lote;
use App\Models\sgsublote;
use Carbon\Carbon; 

//use Rimorsoft\sglote;


class RutasController extends Controller
{
    
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        /*Aqui los controladores del modulo de ganaderia*/

     //Retorna a la vista ficha de ganado
    public function ganaderia()
    {
        $id_finca=1;
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        //se busca las razas registrada para esa finca
        $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();

        //Se trae el modelo de pajuela por el id de finca
        $pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->get();

        //Se trae el modelo de pajuela por el id de finca
        $tipologia = \App\Models\sgtipologia::where('id_finca', '=', $finca->id_finca)->get();

        $condicion_corporal = \App\Models\sgcondicioncorporal::where('id_finca', '=', $finca->id_finca)->get();

        $serie = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)->where('status','=',1)->paginate(10);

        $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
            ->where('codpadre','<>',Null)
            ->where('id_tipologia','=',18)
            ->where('status','=',1)->get();

        //return $serietoro->all();
        //Modelo donde a través de un id se ubica la información en otra tabla.
        $seriesrecords = DB::table('sganims')
             ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
             ->paginate(10);

        $lote = \App\Models\sglote::where('id_finca', '=', $finca->id_finca)->get();

    
        return view('fichaganado',compact('finca', 'raza','pajuela', 'tipologia','condicion_corporal','serie','seriesrecords','lote','serie','serietoro'));
    }

    //Filtra la tipologia por sexo
    public function filterSexo(Request $request, $sexo)
    {
        if($request->ajax()){
            $tipologia=\App\Models\sgtipologia::filtrartiposexo($sexo); 
        return response()->json($tipologia);
      }
    }

    //Creamos los registros en la Ficha de Ganado

    public function crear_fichaganado(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'serie'=> [
                'required',
                Rule::unique('sganims')->ignore($request->id),
            ],
            'sexo'=>[
                'required',
            ],
            'fnac'=>[
                'required',
            ],
            'tipologia'=>[
                'required',
            ],
            'raza'=>[
                'required',
            ],
            'condicion_corporal'=>[
                'required',
            ],
            'fecr'=>[
                'required',
            ],
        ]);
        
        $status=1; //Se pasa por argumento el valor 1 para indicar que es un registro activo.

        $id_finca=1;
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        //Valida los Checks
        $request->espajuela = ($request->espajuela=="on")?($request->espajuela=true):($request->espajuela=false);

        //Valida que el serial provenga de una Serie Toro o Pajuela.
        $seriepadre = ($request->espajuela=="on")?($seriepadre=null):($seriepadre=$request->seriepadre);
        
        $codpajuela = ($request->espajuela=="on")?($codpajuela=$request->pajuela):($codpajuela =  null);
        //_>>
    //***************************************************************************************
        //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($request->fnac)->diffInYears(Carbon::now());
        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
        //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($request->fnac)->diffInMonths(Carbon::now()) - $dt;
        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
    //*********************************************************************************************    
        
        $tipologia = \App\Models\sgtipologia::findOrFail($request->tipologia);        
    
        $serieNueva = new \App\Models\sganim;
        
        $serieNueva->serie = $request->serie;
        $serieNueva->sexo = $request->sexo;
        $serieNueva->fnac = $request->fnac;
        

        $serieNueva->idraza = $request->raza;
        $serieNueva->id_tipologia = $request->tipologia;
        $serieNueva->tipo = $tipologia->nombre_tipologia;
        $serieNueva->id_condicion = $request->condicion_corporal;

        $serieNueva->nombrelote = $request->lote;
        $serieNueva->codmadre = $request->codmadre;
        $serieNueva->espajuela = $request->espajuela;
        $serieNueva->pajuela = $codpajuela;
        $serieNueva->codpadre = $seriepadre;
        $serieNueva->observa = $request->observa;

        $serieNueva->fecr = $request->fecr;
        $serieNueva->pesoi = $request->pesoi;
        $serieNueva->procede = $request->procede;
        $serieNueva->edad = $edad;
        
        //Argumento por referencia:
        $serieNueva->id_finca  = $finca->id_finca;
        $serieNueva->status  = $status;
       
        //Se agregan los parametros para la validación de tipologia
        $serieNueva->destatado = $tipologia->destetado;
        $serieNueva->nro_monta = $tipologia->nro_monta;
        $serieNueva->prenada = $tipologia->prenada;
        $serieNueva->parida = $tipologia->parida;
        $serieNueva->tienecria = $tipologia->tienecria;
        $serieNueva->criaviva = $tipologia->criaviva;
        $serieNueva->ordenho = $tipologia->ordenho;
        $serieNueva->detectacelo = $tipologia->detectacelo;

        $serieNueva-> save(); 

        //return response()->json(['slug' => $loteNuevo->slug]);
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_fichaganado($id)
        {
           
            $id_finca=1;
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            $serie = \App\Models\sganim::findOrFail($id);
            
            $tipologia = 
            
            //se busca las razas registrada para esa finca
            $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)
                ->get();
            //Modelo donde a través de un id se ubica la información en otra tabla.
            $serieraza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)
                ->where('idraza','=',$serie->idraza)
                ->get();

            $condicion_corporal= \App\Models\sgcondicioncorporal::where('id_finca', '=', $finca->id_finca)
                ->get();    

            $seriecondicion = \App\Models\sgcondicioncorporal::where('id_finca', '=', $finca->id_finca)
                ->where('id_condicion','=',$serie->id_condicion)
                ->get();

            $lote = \App\Models\sglote::where('id_finca', '=', $finca->id_finca)->get();
             //return $serieraza->all();
             //Se trae el modelo de pajuela por el id de finca
        
            $pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->get();

            $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
            ->where('codpadre','<>',Null)
            ->where('id_tipologia','=',18)
            ->where('status','=',1)->get();

            /*****************************************************************
            * Colocamos un procedimiento para obtener la descendencia
            * La variable Codigo padre y codigo madre provienen de la busqueda en $serie.
            *****************************************************************/            
            
            //Con el valor de $serie->codpadre obtenemos los abuelos paternos

           //Obtenemos el código (Abuelo) por parte padre
            $codabuelopaterno = \App\Models\sganim::where('serie', '=', $serie->codpadre)
                ->get();  
               if (  ( $codabuelopaterno->count() > 0) ) {
                    //$codbisabuelospaternospadre = "Bisabuelos Aqui";
                   
                   //Obtenemos los bisabuelos paternos por parte padre
                   $codpadrepa = $codabuelopaterno->pluck('codpadre');  
                   $codbisabuelospaternospadre = \App\Models\sganim::where('serie', '=', $codpadrepa)
                        ->get(); 
                   
                    } else {
                   $codbisabuelospaternospadre = \App\Models\sganim::where('serie', '=', "")
                        ->get(); 
                   //$codbisabuelospaternospadre = \App\Models\sganim::where('serie', '=', $codpadrepa)
                     //   ->get(); 
               }
            
            //Obtenemos el código (Abuela) por parte padre
            $codabuelapaterna = \App\Models\sganim::where('serie', '=', $serie->codpadre)
                ->get();
               //$codmadrepa = $codabuelapaterna;
            
            if ( ($codabuelapaterna->count() > 0) ) {
                    //$codbisabuelospaternomadre = "Bisabuelos Paternos ";
                    //Obtenemos los bisabuelos paternos por parte madre
                    $codmadrepa = $codabuelapaterna->pluck('codmadre');
                    $codbisabuelospaternomadre = \App\Models\sganim::where('serie', '=', $codmadrepa)
                       ->get(); 
               } else {
                    $codbisabuelospaternomadre = \App\Models\sganim::where('serie', '=', "")
                       ->get(); 
               }
                
          
            //Obtenemos la serie (abuelo)  maternos
            $codabuelomaterno = \App\Models\sganim::where('serie', '=', $serie->codmadre)
                ->get();
               

            if ( ($codabuelomaterno->count() > 0) ) {
                //$codbisabuelosmaternomadre = "Bisabuelos maternos por parte madre";
                
                //Obtenemos los bisabuelos maternos por parte madre
                $codmadre = $codabuelomaterno->pluck('codmadre');
                $codbisabuelosmaternomadre = \App\Models\sganim::where('serie', '=', $codmadre)
                        ->get(); 
               } else {
                $codbisabuelosmaternomadre = \App\Models\sganim::where('serie', '=',"")
                        ->get(); 
            } 

            //Obtenemos la serie (abuela)  maternos
            $codabuelamaterna = \App\Models\sganim::where('serie', '=', $serie->codmadre)
                ->get();    
                //$codpadre = $codabuelomaterno;              

             if ( ($codabuelamaterna->count() > 0)) {
                //$codbisabuelosmaternospadre = "Bisabuelos maternos por parte padre";
                
                //Obtenemos los bisabuelos maternos por parte padre
                $codpadre = $codabuelamaterna->pluck('codpadre');  
                $codbisabuelosmaternospadre = \App\Models\sganim::where('serie', '=', $codpadre)
                        ->get();   
               } else {
                $codbisabuelosmaternospadre = \App\Models\sganim::where('serie', '=', "")
                        ->get();   
            }    
                       
                        

            //return $codbisabuelospaternospadre;

            return view('editarfichaganado', 
                   compact('serie','tipologia','raza','serieraza',
                    'condicion_corporal','seriecondicion','lote','pajuela','serietoro',
                    'codabuelopaterno', 'codabuelapaterna','codbisabuelospaternospadre',
                    'codbisabuelospaternomadre',
                    'codabuelomaterno','codabuelamaterna','codbisabuelosmaternomadre',
                    'codbisabuelosmaternospadre'));
        }

    public function update_fichaganado(Request $request, $id)
    {
              //Validando los datos
        $request->validate([
            'serie'=> [
                'required',
                Rule::unique('sganims')->ignore($request->id),
            ],
            'sexo'=>[
                'required',
            ],
            'fnac'=>[
                'required',
            ],
            'tipologia'=>[
                'required',
            ],
            'raza'=>[
                'required',
            ],
            'condicion_corporal'=>[
                'required',
            ],
            'fecr'=>[
                'required',
            ],
        ]);
        
       
        $id_finca=1;
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        //Valida los Checks
        $request->espajuela = ($request->espajuela=="on")?($request->espajuela=true):($request->espajuela=false);

        //Valida que el serial provenga de una Serie Toro o Pajuela.
        $seriepadre = ($request->espajuela=="on")?($seriepadre=null):($seriepadre=$request->seriepadre);
        
        $codpajuela = ($request->espajuela=="on")?($codpajuela=$request->pajuela):($codpajuela =  null);

        $request->status = ($request->status=="on")?($rrequest->status=true):($request->status=false);
        //_>>
    //***************************************************************************************
        //Se calcula con la herramienta carbon la edad
        $year = Carbon::parse($request->fnac)->diffInYears(Carbon::now());
        //Se multiplica los años obtendios por 12 para saber los meses de la cantidad de años.
        $dt = $year*12;
        //se restan los meses para obtener los meses transcurridos. 
        $months = Carbon::parse($request->fnac)->diffInMonths(Carbon::now()) - $dt;
        // se pasa a la variable edad, para guardar junto a la información que proviene del form.
        $edad = $year."-".$months;
    //*********************************************************************************************    
        
        $tipologia = \App\Models\sgtipologia::findOrFail($request->tipologia);        
    
        $serieUpdate = \App\Models\sganim::findOrFail($id);
        
        $serieUpdate->serie = $request->serie;
        $serieUpdate->sexo = $request->sexo;
        $serieUpdate->fnac = $request->fnac;
        
        $serieUpdate->idraza = $request->raza;
        $serieUpdate->id_tipologia = $request->tipologia;
        $serieUpdate->tipo = $tipologia->nombre_tipologia;
        $serieUpdate->id_condicion = $request->condicion_corporal;

        $serieUpdate->nombrelote = $request->lote;
        $serieUpdate->codmadre = $request->codmadre;
        $serieUpdate->espajuela = $request->espajuela;
        $serieUpdate->pajuela = $codpajuela;
        $serieUpdate->codpadre = $seriepadre;
        $serieUpdate->observa = $request->observa;

        $serieUpdate->fecr = $request->fecr;
        $serieUpdate->pesoi = $request->pesoi;
        $serieUpdate->procede = $request->procede;
        $serieUpdate->edad = $edad;
        
        //Argumento por referencia:
        $serieUpdate->id_finca  = $finca->id_finca;
        $serieUpdate->status  = $request->status;
       
        //Se agregan los parametros para la validación de tipologia
        $serieUpdate->destatado = $tipologia->destetado;
        $serieUpdate->nro_monta = $tipologia->nro_monta;
        $serieUpdate->prenada = $tipologia->prenada;
        $serieUpdate->parida = $tipologia->parida;
        $serieUpdate->tienecria = $tipologia->tienecria;
        $serieUpdate->criaviva = $tipologia->criaviva;
        $serieUpdate->ordenho = $tipologia->ordenho;
        $serieUpdate->detectacelo = $tipologia->detectacelo;

        $serieUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }



    //Retorna a la vista lote
    public function lote()
    {

        //$lote = \App\Models\sglote::all();
        $lote = \App\Models\sglote::paginate(7);
        return view('lote', compact('lote'));
        //return view('lote');
    }

        //Con esto Agregamos datos en la tabla lote
            public function crear_lote(Request $request)
        {
            
            //Validando los datos
            $request->validate([
                'nombre_lote'=> [
                	'required',
                	Rule::unique('sglotes')->ignore($request->id_lote),
                ],
                'tipo'=>[
                	'required',
                ],
            ]);
            
            //return  $request ->all();
    	/**/
            $loteNuevo = new \App\Models\sglote;

            $loteNuevo->nombre_lote = $request->nombre_lote;
            $loteNuevo->tipo = $request->tipo;
            $loteNuevo->funcion = $request->funcion;
    	 	$loteNuevo->slug =  str::slug($request['nombre_lote'], '-');

            $loteNuevo-> save(); 
       		//return response()->json(['slug' => $loteNuevo->slug]);
            return back()->with('msj', 'Registro agregado satisfactoriamente');
        }


        public function editar_lote($id_lote)
        {
           
            $lote = \App\Models\sglote::findOrFail($id_lote);
            return view('editarlote', compact('lote'));
        }

        public function update_lote(Request $request, $id_lote)
        {
            //Validando los datos
            $request->validate([
                'nombre_lote'=>[
                	'required',
                ],
                'tipo'=>[
                	'required'
            	],
            ]);

            $loteUpdate = \App\Models\sglote::findOrFail($id_lote);

            $loteUpdate->nombre_lote=$request->nombre_lote;
            $loteUpdate->tipo=$request->tipo;
            $loteUpdate->funcion=$request->funcion;
            $loteUpdate->slug = str::slug($request['nombre_lote'], '-');
            $loteUpdate->save();

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

        public function eliminar_lote($id_lote)
        {
                
            $loteEliminar = \App\Models\sglote::findOrFail($id_lote);
            
            $subloteEliminar = \App\Models\sgsublote::where('nombre_lote', '=', $loteEliminar->nombre_lote)->delete();    

            $loteEliminar->delete();

                return back()->with('msj', 'Lote Eliminado Satisfactoriamente');
        }
        // END LOTE--->

    		//---> Se crea las rutas para asociar los sub lotes a cada Lotes Principal.
    		 public function sublote($id_lote)
		    {
		        //modelo de cada lote
		        $lote = \App\Models\sglote::findOrFail($id_lote);
		        
		        //$sublote = \App\Models\sgsublote::all();
                //filtra la tabla por el nombre de lote principal
		      	$sublote = \App\Models\sgsublote::where('nombre_lote', '=', $lote->nombre_lote)->get();
		        
		        return view('sublote', compact('sublote','lote'));
		        //return view('lote');
		    }
		  
		    //Con esto Agregamos datos en la tabla sublote.
        	public function crear_sublote(Request $request)
    		{
   
	        //Validando los datos
		        $request->validate([
		            'sub_lote'=> [
		            	'required',
		            	'unique:sgsublotes,sub_lote,NULL,NULL,nombre_lote,'. $request['nombre_lote'],
		            ],
		            'nombre_lote'=>[
		            	'required',
		            	'unique:sgsublotes,nombre_lote,NULL,NULL,sub_lote,'. $request['sub_lote'],
		            ],
		        ]);
		        
		      //  return  $request ->all();
			/**/
			
		        $subloteNuevo = new \App\Models\sgsublote;

		        $subloteNuevo->sub_lote = $request->sub_lote;
		        $subloteNuevo->nombre_lote = $request->nombre_lote;

		        $subloteNuevo-> save(); 
		        
		        return back()->with('msj', 'Registro agregado satisfactoriamente');
		    }
		    
		   public function eliminar_sublote($id_sublote){
            
		        $subloteEliminar = \App\Models\sgsublote::findOrFail($id_sublote);
		            
		        $subloteEliminar->delete();

		        return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
		    }

    		// END SUBLOTE--->

		    // Begin Asignacción de series a un Lote Padre->>

		    //---> Se crea las rutas para asociar los lotes a cada serie
    		public function seriesenlote($id_lote)
		    {
		        //Obtenemos el nombre del lote.
		        $lote = \App\Models\sglote::findOrFail($id_lote);
		        
		        //filtro
		      	$seriesenlote = \App\Models\sganim::where('nombrelote', '=', $lote->nombre_lote)->where('sub_lote','=',Null)->get();
		      //$serieasignarlote = \App\Models\sganim::paginate(5);
		        
		        return view('detalleserielote', compact('seriesenlote','lote'));
		        //return view('lote');
		        
		    }
            public function seriesensublote($id_sublote)
            {
                //Obtenemos el nombre del lote.
                $sublote = \App\Models\sgsublote::findOrFail($id_sublote);
                
                //filtro
                $seriesensublote = \App\Models\sganim::where('sub_lote', '=', $sublote->sub_lote)
                    ->where('nombrelote','=',$sublote->nombre_lote)->get();
              //$serieasignarlote = \App\Models\sganim::paginate(5);
                
                return view('detalleseriesublote', compact('seriesensublote','sublote'));
                //return view('lote');                
            }

		     //Retorna a la vista para asignar la (s) serie (s) a un lote
	        public function asignarseries(Request $request)
		    {
		        //->Se muestran las series 
		        //$asignarseries = \App\Models\sganim::paginate(7);
		        $asignarseries = \App\Models\sganim::where('serie', 'like', $request->serie."%")->take(10)->get();

		      	$lote = \App\Models\sglote::all()->pluck('nombre_lote');	
						    
		     	return view('asignarseries', compact('asignarseries','lote'));

		    }

		    public function filterName(Request $request, $nombre_lote)
	    	{
			  	if($request->ajax()){
                    $sublote=\App\Models\sgsublote::filtrarlotesublote($nombre_lote); 
			  	return response()->json($sublote);
			  }
		    }

		    public function filterTipo(Request $request, $tipo)
		    	{
			  	if($request->ajax()){
                    $lote=\App\Models\sglote::filtrarlote($tipo);
			  	return response()->json($lote);
			  }
		    }
 		
     		public function asignar_serielote(Request $request)
    		{
    			//Validamos los campos Nombre de lote y las series a través de su id
    			$request->validate([
    	            'nombrelote'=>[
    	            	'required',
    	            ],
    	            'id'=>[
    	            	'required',
    	            ],
            	]);
                $cont = count($request->id);
    			for($i=0; $i < $cont; $i++){
    				
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    $fecregistro = Carbon::now();

                    $HistorialLoteNuevo = new \App\Models\sghistlote;

                    $HistorialLoteNuevo->id_serie = $request->id[$i];
                    $HistorialLoteNuevo->serie = $series->serie;
                    $HistorialLoteNuevo->loteinicial = $series->nombrelote;
                    $HistorialLoteNuevo->lotefinal = $request->nombrelote;
                    $HistorialLoteNuevo->fecharegistro = $fecregistro;//Nos da la fecha actual.
                    $HistorialLoteNuevo->tipologiaactual = $series->tipo;
                    $HistorialLoteNuevo->sub_lote_ini = $series->sub_lote;
                    $HistorialLoteNuevo->sub_lote_fin = $request->sublote;

                    $HistorialLoteNuevo-> save();   

                    $asignarserielote = DB::table('sganims')
                                    ->where('id',$request->id[$i])
                                    ->update(['nombrelote'=>$request->nombrelote, 'sub_lote'=>$request->sublote]);    
    			}   
    				
    	       return back()->with('msj', 'Serie (s) asignada satisfactoriamente');
    	    }
		   
    //Retorna a la vista pajuela
        public function pajuela()
        {
            $id_finca=1;
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            //se busca las razas registrada para esa finca
            $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();

            //Se trae el modelo de pajuela por el id de finca
            $pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->paginate(7);
            
            //Modelo donde a través de un id se ubica la información en otra tabla.
            $records = DB::table('sgpajus')
             ->join('sgrazas', 'sgrazas.idraza', '=', 'sgpajus.id')
             ->get();


            //return $records->all();
            return view('pajuela', compact('pajuela','finca','raza','records'));
        }
    //Con esto Agregamos datos en la tabla pajuela
        public function crear_pajuela(Request $request)
        {
            
            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([
                'serie'=> [
                    'required',
                    Rule::unique('sgpajus')->ignore($request->id),
                ],
                'raza'=>[
                    'required',
                ],
            ]);
            
        //return  $request ->all();
        /**/
            $pajuelaNueva = new \App\Models\sgpaju;

            $pajuelaNueva->serie = $request->serie;
            $pajuelaNueva->nomb = $request->nomb;
            $pajuelaNueva->nomb = $request->nombrelargo;
            $pajuelaNueva->nombreraza = $request->raza;
            $pajuelaNueva->fecr = $request->fecr;
            $pajuelaNueva->fnac = $request->fnac;
            $pajuelaNueva->ubica = $request->ubica;
            $pajuelaNueva->orig = $request->orig;
            $pajuelaNueva->cant = $request->cant;
            $pajuelaNueva->mini = $request->mini;
            $pajuelaNueva->maxi = $request->maxi;
            $pajuelaNueva->unid = $request->unid;
            $pajuelaNueva->obser = $request->obser;
            $pajuelaNueva->id_finca = $request->id_finca;

            $pajuelaNueva-> save(); 
            //return response()->json(['slug' => $loteNuevo->slug]);
            return back()->with('msj', 'Registro agregado satisfactoriamente');
        }

        public function editar_pajuela($id)
        {
            $id_finca=1;
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            $pajuela = \App\Models\sgpaju::findOrFail($id);

            $snom = $pajuela->snom;
            
            //$raza = \App\Models\sgraza::findOrFail($snom);

            //se busca las razas registrada para esa finca
           $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();
            //return $raza->all();

          /*  $records = DB::table('sgpajus')
             ->join('sgrazas', 'sgrazas.idraza', '=', 'sgpajus.id')
             ->where('snom', '=' ,$pajuela->id)
             ->get();
            */ 
           //return $records->all();

            return view('editarpajuela', compact('pajuela','finca','raza'));
        }

        public function update_pajuela(Request $request, $id)
        {
            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([
                'serie'=> [
                    'required',
                    Rule::unique('sgpajus')->ignore($request->id),
                ],
                'raza'=>[
                    'required',
                ],
            ]);

            $pajuelaUpdate = \App\Models\sgpaju::findOrFail($id);

            $pajuelaUpdate->serie = $request->serie;
            $pajuelaUpdate->nomb = $request->nomb;
            $pajuelaUpdate->nomb = $request->nombrelargo;
            $pajuelaUpdate->nombreraza = $request->raza;
            $pajuelaUpdate->fecr = $request->fecr;
            $pajuelaUpdate->fnac = $request->fnac;
            $pajuelaUpdate->ubica = $request->ubica;
            $pajuelaUpdate->orig = $request->orig;
            $pajuelaUpdate->cant = $request->cant;
            $pajuelaUpdate->mini = $request->mini;
            $pajuelaUpdate->maxi = $request->maxi;
            $pajuelaUpdate->unid = $request->unid;
            $pajuelaUpdate->obser = $request->obser;
            $pajuelaUpdate->id_finca = $request->id_finca;

            $pajuelaUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }
         public function eliminar_pajuela($id)
         {
            
                $pajuelaEliminar = \App\Models\sgpaju::findOrFail($id);
                    
                $pajuelaEliminar->delete();

                return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
        }

    //Retorna a la vista transferencia
        public function transferencia()
    {
        return view('transferencia');
    }
   


}
