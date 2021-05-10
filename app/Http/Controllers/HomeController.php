<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Validation\Rule;
use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
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
       
        $finca = \App\Models\sgfinca::all();

        return view('home', compact('finca'));
    }

    //Retorna a la vista administrativa para cada finca
    public function admin($id_finca)
    {
        /*
        * Variables y constantes necesarias para el filtrado
        */
        
        //$status = 1 activo; 0 = Inactivo;

        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $seriesactivas = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('id_finca', '=', $finca->id_finca)
                ->get();

        $seriesinactivas = DB::table('sganims')
                ->where('status', '=', 0)
                ->where('id_finca', '=', $finca->id_finca)
                ->get();        
        //return $finca;
        $cantregisactiv = $seriesactivas->count();
        
        $cantregisinactiv = $seriesinactivas->count();
        
        $seriesnodestetado = DB::table('sganims')
                ->where('destatado','=', 0) //Que no estan destetado
                ->where('id_finca', '=', $finca->id_finca)
                ->get();
        
        $serieshembrasrepro = DB::table('sganims')
                ->where('destatado','=',1)
                ->where('sexo','=',0) //Sexo = hembra
                ->where('id_finca', '=', $finca->id_finca)
                ->distinct()->get();
        
        #0.- Verificamos si existe la temporada
        $temp_reprod = DB::table('sgtempreprods')
          //  ->select(DB::raw('MAX(fecini) as ulttemporada'))
            ->where('id_finca','=',$id_finca)
            ->get();

        $contTemp = $temp_reprod->count();

        #1.- Validamos que exista la temporada    
        if ($contTemp>0) {
            # Si existe
            $tempReprodRcciente = DB::table('sgtempreprods')
                ->select(DB::raw('MAX(fecini) as ulttemporada'))
                ->where('id_finca','=',$id_finca)
                ->get();

            foreach ($tempReprodRcciente as $key ) {
                $fechultimatemp = $key->ulttemporada;
            }
            /*
             * Extraemos el Nombre 
            */    
            $detalleTemporada = DB::table('sgtempreprods')
                    ->where('fecini','=',$fechultimatemp)
                    ->where('id_finca','=',$id_finca)
                    ->get();
            foreach ($detalleTemporada as $key ) {
                $nombretemporada = $key->nombre; 
                $idTempRepro = $key->id; 
            } 

             $tempCicloLoteMonta = DB::table('sgciclos')
                ->join('sglotemontas','sglotemontas.id_ciclo','=','sgciclos.id_ciclo')
                ->join('sgmontas','sgmontas.id_lotemonta','=','sglotemontas.id_lotemonta') 
                ->where('sgciclos.id_finca','=',$id_finca)
                ->where('sgciclos.id_temp_reprod','=',$idTempRepro)
                ->get(); 

            $cantseries = $tempCicloLoteMonta->count(); 
            
            $nombretemporada = $nombretemporada ;
             
            } else {
                $cantseries = 0;
                $nombretemporada="";
            }

            $cantnodestetado = $seriesnodestetado->count(); //machos y hembras. 
            $canthemrepro = $serieshembrasrepro->count(); //machos y hembras.     
       
        //return $seriestiponame->all();
                
        return view('sisga-admin', compact('finca','cantregisactiv','cantregisinactiv'
            ,'cantnodestetado','canthemrepro','nombretemporada','cantseries','contTemp'));
    }

/*
*   Vistas generales de Series.
*/
    public function series_activas(Request $request, $id_finca)
    {
         $finca = \App\Models\sgfinca::findOrFail($id_finca);
            
        if (! empty($request->serie) ) {
            $seriesactivas = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        } else {
            $seriesactivas = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        }

         return view('info.series_activas', compact('finca','seriesactivas'));        
    }

    public function series_inactivas(request $request, $id_finca)
    {
         $finca = \App\Models\sgfinca::findOrFail($id_finca);
         
    /*      $seriesactivas = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('id_finca', '=', $finca->id_finca)
                ->paginate(10);

    */    
        if (! empty($request->serie) ) {
            $seriesinactivas = DB::table('sganims')
                ->where('status', '=', 0)
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        } else {
            $seriesinactivas = DB::table('sganims')
                ->where('status', '=', 0)
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        }


        return view('info.series_inactivas', compact('finca','seriesinactivas'));        
    }

    public function series_pordestetar(request $request, $id_finca)
    {
         $finca = \App\Models\sgfinca::findOrFail($id_finca);
         
    
        if (! empty($request->serie) ) {

            $seriesnodestetado = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('destatado','=', 0) //Que no estan destetado
                ->where('id_finca', '=', $finca->id_finca) 
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        } else {

            $seriesnodestetado = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('destatado','=', 0) //Que no estan destetado
                ->where('id_finca', '=', $finca->id_finca) 
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        }

         return view('info.series_por_destetar', compact('finca','seriesnodestetado'));        
    }
    public function series_hembras_productivas(request $request, $id_finca)
    {
         $finca = \App\Models\sgfinca::findOrFail($id_finca);
         
    /*      $seriesactivas = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('id_finca', '=', $finca->id_finca)
                ->paginate(10);
    */    
        if (! empty($request->serie) ) {

            $serieshembrasrepro = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('destatado','=',1)
                ->where('sexo','=',0) //Sexo = hembra
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        } else {

            $serieshembrasrepro = DB::table('sganims')
                ->where('status', '=', 1)
                ->where('destatado','=',1)
                ->where('sexo','=',0) //Sexo = hembra
                ->where('id_finca', '=', $finca->id_finca)
                ->where('serie', 'like', $request->serie."%")
                ->take(10)->paginate(10);
        }

         return view('info.hembras_reprod', compact('finca','serieshembrasrepro'));        
    }

/*
* /.End
*/

    //Retorna a la vista administrativa /finca
        public function fincas()
    {
        $fincas = \App\Models\sgfinca::all();
        return view('fincas',compact('fincas'));
    }

    //Con esto Agregamos datos en la tabla finca.
        public function crear(Request $request)
    {
         //Validando los datos
        $request->validate([
            'nombre'=> [
                'required',
                Rule::unique('sgfincas')->ignore($request->id_finca),
            ],
        ]);
       // return  $request ->all();
        $fincaNueva = new \App\Models\sgfinca;
        $fincaNueva->nombre = $request->nombre;
        $fincaNueva->especie = $request->especie;
        $fincaNueva->slug =  str::slug($request['nombre'], '-');

        $fincaNueva-> save();
       
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar($id_finca){
       
        $fincas = \App\Models\sgfinca::findOrFail($id_finca);
        return view('fincaeditar', compact('fincas'));
    }

    public function update(Request $request, $id_finca){
        //Validando los datos
        $request->validate([
                  'nombre'=>'required'
                  ]);
        $fincasUpdate = \App\Models\sgfinca::findOrFail($id_finca);
        $fincasUpdate->nombre=$request->nombre;
        $fincasUpdate->especie=$request->especie;    
        $fincasUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar(Request $request, $id_finca){
        
        $fincasEliminar = \App\Models\sgfinca::findOrFail($id_finca);
 
        try {
        $fincasEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
        
    }


    //Retorna la vista especie
    public function especie(Request $request, $id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $especie = \App\Models\sgespecie::where('id_finca', '=', $finca->id_finca)->get();

        return view('varcontrol.especie',compact('especie','finca'));
    }


    //Con esto Agregamos datos en la tabla especie.
        public function crear_especie(Request $request, $id_finca)
    {
         //Validando los datos
        $request->validate([
            'nombre'=> [
                'required',
                'unique:sgespecies,nombre,NULL,NULL,id_finca,'. $id_finca,

            ],
            'nomenclatura'=> [
                'required',
            ],
        ]);

        $especieNueva = new \App\Models\sgespecie;
        
        $especieNueva->nombre = $request->nombre;
        $especieNueva->nomenclatura = $request->nomenclatura;
        $especieNueva->id_finca = $id_finca;
        
        $especieNueva-> save();
       
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_especie($id_finca, $id){
       
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca); 
        $especie = \App\Models\sgespecie::findOrFail($id);
        
        return view('varcontrol.editarespecie', compact('finca','especie'));
    }

    public function update_especie(Request $request, $id, $id_finca){
        
        //Validando los datos
         //Validando los datos
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        
        $request->validate([
            'nombre'=> [
                'required',
            ],
            'nomenclatura'=> [
                'required',
            ],
        ]);

        $especieUpdate = \App\Models\sgespecie::findOrFail($id);
        $especieUpdate->nombre=$request->nombre;
        $especieUpdate->nomenclatura=$request->nomenclatura;

        $especieUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_especie($id_finca, $id){
        
        //dd($id);
        $especieEliminar = \App\Models\sgespecie::findOrFail($id);
        
        try {
        $especieEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }
    //-->End Vista especie
/*Raza*/

/*---> //Retorna a la vista administrativa /raza*/
 
    public function raza(Request $request, $id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $especie = \App\Models\sgespecie::where('id_finca', '=', $finca->id_finca)->get();   
        //$raza = \App\Models\sgraza::all();
        //$raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();
        
        $raza= DB::table('sgrazas')
             ->join('sgespecies', 'sgespecies.id', '=', 'sgrazas.id_especie')
                ->where('sgrazas.id_finca','=',$finca->id_finca)->paginate(5);

        //return $raza;         
        return view('varcontrol.raza', compact('raza','finca','especie'));
    }

    //Con esto Agregamos datos en la tabla raza.
      public function crear_raza(Request $request, $id_finca)
    {
        //return $id_finca; 
        //Validando los datos y que no se permita crear 
        $request->validate([
            'descripcion'=> [
                'required',
                //Rule::unique('sgrazas')->ignore($request->idraza),
            ],
            'nombreraza'=> [
                'required',
                'unique:sgrazas,nombreraza,NULL,NULL,id_finca,'. $id_finca,
                'unique:sgrazas,nombreraza,NULL,NULL,id_especie,'. $request['especie'],
            ],
            'especie'=> [
                'required',
            ],
        ]);

        $razaNueva = new \App\Models\sgraza;

        $razaNueva->nombreraza = $request->nombreraza;
        $razaNueva->descripcion = $request->descripcion;
        $razaNueva->id_finca = $id_finca;
        $razaNueva->id_especie = $request->especie;

        $razaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_raza($id_finca, $idraza){
       
         //dd($id_finca, $idraza);
        $finca =  \App\Models\sgfinca::findOrFail($id_finca); 
        $raza = \App\Models\sgraza::findOrFail($idraza);
        

        $tableraza= DB::table('sgrazas')
             ->join('sgespecies', 'sgespecies.id', '=', 'sgrazas.id_especie')
                ->where('sgrazas.id_finca','=',$finca->id_finca)
                ->where('sgrazas.idraza','=',$idraza)->get();
        
        $especie = \App\Models\sgespecie::where('id_finca', '=', $finca->id_finca)->get();

        //return $tableraza;
        return view('varcontrol.editarraza', compact('raza','finca','especie','tableraza'));
    }

    public function update_raza(Request $request, $idraza, $id_finca){
        

        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        
        $request->validate([
            'descripcion'=> [
                'required',
                //Rule::unique('sgrazas')->ignore($request->idraza),
            ],
            'nombreraza'=> [
                'required',
                //'unique:sgrazas,nombreraza,NULL,NULL,id_finca,'. $id_finca,
                //'unique:sgrazas,nombreraza,NULL,NULL,id_especie,'. $request['especie'],
            ],
            'especie'=> [
                'required',
            ],
        ]);

        $razaUpdate = \App\Models\sgraza::findOrFail($idraza);

        $razaUpdate->nombreraza=$request->nombreraza;
        $razaUpdate->descripcion=$request->descripcion;
        $razaUpdate->id_especie=$request->especie;
        
        $razaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_raza($id_finca, $idraza){
          
            
        $razaEliminar = \App\Models\sgraza::findOrFail($idraza);
            
        try {
        $razaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }

    }


/*
*******************************************************
* Retorna a la vista administrativa /tipologia
*******************************************************
*/    
   
    public function tipologia($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);   
        //$tipologia = \App\Models\sgtipologia::all();
        $tipologia = \App\Models\sgtipologia::where('id_finca', '=', $finca->id_finca)->get();
        
        return view('varcontrol.tipologia',compact('tipologia','finca'));
    }

    //Con esto Agregamos datos en la tabla finca.
        public function crear_tipo(Request $request, $id_finca)
    {
        //Valida los Checks
        $request->destetado = ($request->destetado=="on")?($request->destetado=true):($request->destetado=false);

        $request->prenada = ($request->prenada=="on")?($request->prenada=true):
        ($request->prenada=false);

        $request->parida = ($request->parida=="on")?($request->parida=true):
        ($request->parida=false);

        $request->tienecria = ($request->tienecria=="on")?($request->tienecria=true):($request->tienecria=false);

        $request->criaviva = ($request->criaviva=="on")?($request->criaviva=true):($request->criaviva=false);

        $request->ordenho = ($request->ordenho=="on")?($request->ordenho=true):($request->ordenho=false);

        $request->detectacelo = ($request->detectacelo =="on")?($request->detectacelo=true):($request->detectacelo=false);
        
        //Validando los datos
        $request->validate([
            'nombre_tipologia'=> [
                'required',
                //Rule::unique('sgrazas')->ignore($request->idraza),
                 'unique:sgtipologias,nombre_tipologia,NULL,NULL,id_finca,'. $id_finca,
            ],
            'nomenclatura'=> [
                'required',
            ],
            'edad'=> [
                'required',
            ],
            'peso'=> [
                'required',
            ],
            'nro_monta'=> [
                'required',
            ],
        ]);
        
       //  return  $request ->all();
                
        $tipologiaNueva = new \App\Models\sgtipologia;

        $tipologiaNueva->nombre_tipologia = $request->nombre_tipologia;
        $tipologiaNueva->nomenclatura = $request->nomenclatura;
        $tipologiaNueva->edad = $request->edad;
        $tipologiaNueva->peso = $request->peso;
        $tipologiaNueva->destetado = $request->destetado;
        $tipologiaNueva->sexo = $request->sexo; 
        $tipologiaNueva->nro_monta = $request->nro_monta;
        $tipologiaNueva->prenada = $request->prenada;
        $tipologiaNueva->parida = $request->parida;
        $tipologiaNueva->tienecria = $request->tienecria;
        $tipologiaNueva->criaviva = $request->criaviva;
        $tipologiaNueva->ordenho = $request->ordenho;
        $tipologiaNueva->detectacelo = $request->detectacelo;
        $tipologiaNueva->descripcion = $request->descripcion;
        $tipologiaNueva->id_finca = $id_finca;

        $tipologiaNueva-> save(); 
       
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_tipo($id_finca, $id_tipologia){
           
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);    
        $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
        return view('varcontrol.editartipo', compact('tipologia','finca'));
    }

    public function update_tipo(Request $request, $id_tipologia, $id_finca){
        
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        //Valida los Checks
        $request->destetado = ($request->destetado=="on")?($request->destetado=true):($request->destetado=false);

        $request->prenada = ($request->prenada=="on")?($request->prenada=true):
        ($request->prenada=false);

        $request->parida = ($request->parida=="on")?($request->parida=true):
        ($request->parida=false);

        $request->tienecria = ($request->tienecria=="on")?($request->tienecria=true):($request->tienecria=false);

        $request->criaviva = ($request->criaviva=="on")?($request->criaviva=true):($request->criaviva=false);

        $request->ordenho = ($request->ordenho=="on")?($request->ordenho=true):($request->ordenho=false);

        $request->detectacelo = ($request->detectacelo =="on")?($request->detectacelo=true):($request->detectacelo=false);

        //Validando los datos
        $request->validate([
                  'nombre_tipologia'=>'required',
                  'nomenclatura'=>'required',
                  'edad'=>'required',
                  'peso'=>'required',
                  ]);
         // return  $request ->all();
        $tipologiaUpdate = \App\Models\sgtipologia::findOrFail($id_tipologia);
/**/
        $tipologiaUpdate->nombre_tipologia = $request->nombre_tipologia;
        $tipologiaUpdate->nomenclatura = $request->nomenclatura;
        $tipologiaUpdate->edad = $request->edad;
        $tipologiaUpdate->peso = $request->peso;
        $tipologiaUpdate->destetado = $request->destetado;
        $tipologiaUpdate->sexo = $request->sexo; 
        $tipologiaUpdate->nro_monta = $request->nro_monta;
        $tipologiaUpdate->prenada = $request->prenada;
        $tipologiaUpdate->parida = $request->parida;
        $tipologiaUpdate->tienecria = $request->tienecria;
        $tipologiaUpdate->criaviva = $request->criaviva;
        $tipologiaUpdate->ordenho = $request->ordenho;
        $tipologiaUpdate->detectacelo = $request->detectacelo;
        $tipologiaUpdate->descripcion = $request->descripcion;

        $tipologiaUpdate->save(); 

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }

    public function eliminar_tipo($id_finca, $id_tipologia){
            
        $tipologiaEliminar = \App\Models\sgtipologia::findOrFail($id_tipologia);
        
        try {
           $tipologiaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }

/*
*******************************************************
* Retorna a la vista administrativa /tipologia
*******************************************************
*/    

/*
*******************************************************
* Retorna a la vista administrativa /condicion-corporal
*******************************************************
*/    
 
    public function condicion_corporal($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);   
        //$condicion_corporal = \App\Models\sgcondicioncorporal::all();
        
        $condicion_corporal = \App\Models\sgcondicioncorporal::where('id_finca', '=', $finca->id_finca)->paginate(5);
        
        return view('varcontrol.condicioncorporal',compact('condicion_corporal','finca'));
    }

    //Con esto Agregamos datos en la tabla finca.
        public function crear_condicioncorporal(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre_condicion'=>'required',
            'unique:sgcondicioncorporals,nombre_condicion,NULL,NULL,id_finca,'. $id_finca,
        ]);
        
         //return  $request ->all();
/**/
        $condicionNueva = new \App\Models\sgcondicioncorporal;

        $condicionNueva->nombre_condicion = $request->nombre_condicion;
        $condicionNueva->descripcion = $request->descripcion;
        $condicionNueva->id_finca = $id_finca;

        $condicionNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_condicion($id_finca, $id_condicion){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $condicion_corporal = \App\Models\sgcondicioncorporal::findOrFail($id_condicion);
        
        return view('varcontrol.editarcondicion', compact('condicion_corporal','finca'));
    }

    public function update_condicion(Request $request, $id_condicion, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        //Validando los datos
        $request->validate([
                  'nombre_condicion'=>'required',
                  'descripcion'=>'required'
                  ]);
        $condicionUpdate = \App\Models\sgcondicioncorporal::findOrFail($id_condicion);
        $condicionUpdate->nombre_condicion=$request->nombre_condicion;
        $condicionUpdate->descripcion=$request->descripcion;    
        
        $condicionUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
   public function eliminar_condicion($id_finca, $id_condicion){
            
        $condicionEliminar = \App\Models\sgcondicioncorporal::findOrFail($id_condicion);
             
        try {
            $condicionEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }  
    }
/*
*******************************************************
* Fin de la vista administrativa /condicion-corporal
*******************************************************
*/    


/*
************************************************************
* Retorna a la vista administrativa diagnostico palpaciones
************************************************************
*/    
 
    public function diagnostico_palpaciones($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);   
        //$diagnostico_palpaciones = \App\Models\sgdiagnosticpalpaciones::all();
        $diagnostico_palpaciones = \App\Models\sgdiagnosticpalpaciones::where('id_finca', '=', $finca->id_finca)->paginate(4);

        return view('varcontrol.diagnosticopalpaciones',compact('diagnostico_palpaciones','finca'));
    }
    //Con esto Agregamos datos en la tabla finca.
        public function crear_diagnosticopalpaciones(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=> [
                'required',
                //Rule::unique('sgrazas')->ignore($request->idraza),
                 'unique:sgdiagnosticpalpaciones,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
            'descrip'=> [
                'required',
            ],
        ]);
        
         //return  $request ->all();
/**/
        $diagnosticopalpacionesNueva = new \App\Models\sgdiagnosticpalpaciones;

        $diagnosticopalpacionesNueva->nombre = $request->nombre;
        $diagnosticopalpacionesNueva->descrip = $request->descrip;
        $diagnosticopalpacionesNueva->id_finca = $request->id_finca;

        $diagnosticopalpacionesNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_diagnostico_palpaciones($id_finca, $id_diagnostico){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $diagnostico_palpaciones = \App\Models\sgdiagnosticpalpaciones::findOrFail($id_diagnostico);
        
        return view('varcontrol.editardiagnosticopalpaciones', compact('diagnostico_palpaciones','finca'));
    }

    public function update_diagnostico_palpaciones(Request $request, $id_diagnostico,$id_finca)
    {
        
        //Validando los datos
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $request->validate([
                  'nombre'=>'required',
                  'descrip'=>'required'
                  ]);
       
        $diagnostico_palpacionesUpdate = \App\Models\sgdiagnosticpalpaciones::findOrFail($id_diagnostico);
        $diagnostico_palpacionesUpdate->nombre=$request->nombre;
        $diagnostico_palpacionesUpdate->descrip=$request->descrip;    
        
        $diagnostico_palpacionesUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_diagnostico_palpaciones($id_finca, $id_diagnostico){
            
        $diagnostico_palpacionesEliminar = \App\Models\sgdiagnosticpalpaciones::findOrFail($id_diagnostico);
             
        try {
            $diagnostico_palpacionesEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }

         
    }
/*
*********************************************************
* Fin de la vista administrativa diagnostico palpaciones
*********************************************************
*/  

/*
************************************************************
* Retorna a la vista administrativa /motivo-entrada-salida
************************************************************
*/    
 
    public function motivo_entrada_salida($id_finca)
    {
        
        $finca =  \App\Models\sgfinca::findOrFail($id_finca); 

        //$motivo_entrada_salida = \App\Models\sgmotivoentradasalida::all();
        $motivo_entrada_salida = \App\Models\sgmotivoentradasalida::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.motivoentradasalida', compact('motivo_entrada_salida','finca'));
    }

//Con esto Agregamos datos en la tabla finca.
        public function crear_motivo_entrada_salida(Request $request, $id_finca)
    {
        //Validando los datos
        $request->validate([
            'nombremotivo'=> [
                'required',
                //Rule::unique('sgrazas')->ignore($request->idraza),
                 'unique:sgmotivoentradasalidas,nombremotivo,NULL,NULL,id_finca,'. $id_finca,
            ],
            'nomenclatura'=> [
                'required',
            ],
        ]);
        
        $motivo_entrada_salidaNueva = new \App\Models\sgmotivoentradasalida;

        $motivo_entrada_salidaNueva->nombremotivo = $request->nombremotivo;
        $motivo_entrada_salidaNueva->nomenclatura = $request->nomenclatura;
        $motivo_entrada_salidaNueva->tipo = $request->tipo;
        $motivo_entrada_salidaNueva->id_finca = $id_finca;

        $motivo_entrada_salidaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_motivo_entrada_salida($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $motivo_entrada_salida = \App\Models\sgmotivoentradasalida::findOrFail($id);
        
        return view('varcontrol.editarmotivoentradasalida', compact('motivo_entrada_salida','finca'));
    }

    public function update_motivo_entrada_salida(Request $request, $id, $id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        //Validando los datos
        $request->validate([
                  'nombremotivo'=>'required',
                  'nomenclatura'=>'required'
                  ]);

        $motivo_entrada_salidaUpdate = \App\Models\sgmotivoentradasalida::findOrFail($id);
        $motivo_entrada_salidaUpdate->nombremotivo=$request->nombremotivo;
        $motivo_entrada_salidaUpdate->nomenclatura=$request->nomenclatura;
        $motivo_entrada_salidaUpdate->tipo=$request->tipo;    
        
        $motivo_entrada_salidaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_motivo_entrada_salida($id_finca, $id){
            
        $motivo_entrada_salidaEliminar = \App\Models\sgmotivoentradasalida::findOrFail($id);
            
        try {
            $motivo_entrada_salidaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }
/*
************************************************************
* Fin de la vista administrativa motivo-entrada-salida
************************************************************
*/  
/*
************************************************************
* Retorna a la vista administrativa Patología
************************************************************
*/  
     public function patologia($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $patologia = \App\Models\sgpatologia::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.patologia', compact('patologia','finca'));
    }

     public function crear_patologia(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'patologia'=>[
                'required',
                'unique:sgpatologias,patologia,NULL,NULL,id_finca,'. $id_finca,
            ],
            'nomenclatura'=>[
                'required',
            ],
        ]);
        
        //return  $request ->all();
/**/
        $patologiaNueva = new \App\Models\sgpatologia;

        $patologiaNueva->patologia = $request->patologia;
        $patologiaNueva->nomenclatura = $request->nomenclatura;
        $patologiaNueva->descripcion = $request->descripcion;
        $patologiaNueva->id_finca = $id_finca;

        $patologiaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }
    public function editar_patologia($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $patologia = \App\Models\sgpatologia::findOrFail($id);
        
        return view('varcontrol.editarpatologia', compact('patologia', 'finca'));
    }

    public function update_patologia(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'patologia'=>[
                'required',
            ],
            'nomenclatura'=>[
                'required',
            ],
        ]);

        $patologiaUpdate = \App\Models\sgpatologia::findOrFail($id);

        $patologiaUpdate->patologia=$request->patologia;
        $patologiaUpdate->nomenclatura=$request->nomenclatura;
        $patologiaUpdate->descripcion=$request->descripcion;
        
        $patologiaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_patologia($id_finca, $id){
            
        $patologiaEliminar = \App\Models\sgpatologia::findOrFail($id);
            
        try {
        $patologiaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }

/************************************************************
* Retorna a la vista Parametros.
************************************************************
*/  
     public function parametros($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $parametrosGanaderia = \App\Models\sgparametros_ganaderia::where('id_finca', '=', $finca->id_finca)->get();

        $parametrosReproduccion = \App\Models\sgparametros_reproduccion_animal::where('id_finca', '=', $finca->id_finca)->get();

        $parametrosProduccion = \App\Models\sgparametros_reproduccion_leche::where('id_finca', '=', $finca->id_finca)->get();

        $contpG = $parametrosGanaderia->count();
        $contpR = $parametrosReproduccion->count();
        $contpP = $parametrosProduccion->count();

    

        return view('varcontrol.var_control_parametros', compact('parametrosGanaderia','parametrosReproduccion','parametrosProduccion','finca','contpG','contpR','contpP'));
    }

     public function crear_parametros_ganaderia(Request $request, $id_finca)
    {
        
        $pgNuevo = new \App\Models\sgparametros_ganaderia;

        $pgNuevo->diasaldestete = $request->diasaldestete;
        $pgNuevo->pesoajustado18m = $request->pajust18m;
        $pgNuevo->pesoajustado12m = $request->pajust12m;
        $pgNuevo->pesoajustado24m = $request->pajust24m;
        $pgNuevo->pesoajustadoaldestete  = $request->pajustdestete;
        $pgNuevo->id_finca = $id_finca;

        $pgNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

     public function editar_parametros_ganaderia(Request $request, $id_finca, $id)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        $parametrosGanaderia = \App\Models\sgparametros_ganaderia::findOrFail($id);


        return view('varcontrol.editar_parametro_ganaderia', compact('parametrosGanaderia','finca'));
    }

     public function update_parametros_ganaderia(Request $request, $id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       

        $pgUpdate = \App\Models\sgparametros_ganaderia::findOrFail($id);

        $pgUpdate->diasaldestete = $request->diasaldestete;
        $pgUpdate->pesoajustado18m = $request->pajust18m;
        $pgUpdate->pesoajustado12m = $request->pajust12m;
        $pgUpdate->pesoajustado24m = $request->pajust24m;
        $pgUpdate->pesoajustadoaldestete  = $request->pajustdestete;
        
        $pgUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }    


     public function crear_parametros_reproduccion(Request $request, $id_finca)
    {
      

        $prNuevo = new \App\Models\sgparametros_reproduccion_animal;

        $prNuevo->diasentrecelo  = $request->diasentrecelo;
        $prNuevo->tiempogestacion = $request->tiempogestacion;
        $prNuevo->id_finca = $id_finca;

        $prNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_parametros_reproduccion(Request $request, $id_finca, $id)
    {
        
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
       
        $parametrosReproduccion = \App\Models\sgparametros_reproduccion_animal::findOrFail($id);

        return view('varcontrol.editar_parametro_reproduccion', compact('parametrosReproduccion','finca'));
    }

     public function update_parametros_reproduccion(Request $request, $id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

    
        $pRUpdate = \App\Models\sgparametros_reproduccion_animal::findOrFail($id);

        $pRUpdate->diasentrecelo  = $request->diasentrecelo;
        $pRUpdate->tiempogestacion = $request->tiempogestacion;
        
        $pRUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }    

    public function crear_parametros_produccion_leche(Request $request, $id_finca)
    {
      


        $pPNuevo = new \App\Models\sgparametros_reproduccion_leche;

        $pPNuevo->diassecado = $request->diassecado;
        $pPNuevo->diaslactanciaestimada = $request->diaslactanciaestimada;
        $pPNuevo->diasproducionalmes = $request->diasproducionalmes;
        $pPNuevo->lactanciaajustada = $request->lactanciaajustada;
        $pPNuevo->litrospromedioaldia = $request->litrospromedioaldia;
        $pPNuevo->produccionideal = $request->produccionideal;
        
        $pPNuevo->id_finca = $id_finca;

        $pPNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

     public function editar_parametros_produccion_leche(Request $request, $id_finca, $id)
        {
            
            $finca =  \App\Models\sgfinca::findOrFail($id_finca);
           
            $parametrosProduccion = \App\Models\sgparametros_reproduccion_leche::findOrFail($id);

            return view('varcontrol.editar_parametro_produccion', compact('parametrosProduccion','finca'));
        }

    public function update_parametros_produccion_leche(Request $request, $id_finca, $id){
           
            $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        
            $pPUpdate = \App\Models\sgparametros_reproduccion_leche::findOrFail($id);

            $pPUpdate->diassecado = $request->diassecado;
            $pPUpdate->diaslactanciaestimada = $request->diaslactanciaestimada;
            $pPUpdate->diasproducionalmes = $request->diasproducionalmes;
            $pPUpdate->lactanciaajustada = $request->lactanciaajustada;
            $pPUpdate->litrospromedioaldia = $request->litrospromedioaldia;
            $pPUpdate->produccionideal = $request->produccionideal;
            
            $pPUpdate->save();

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }    

    /*
    * Creamos las Clases para el tipo de monta - Variables de Control
    */

    public function tipomonta(Request $request, $id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $tipomonta = \App\Models\sgtipomonta::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.tipo_monta', compact('tipomonta','finca'));
    }

    public function crear_tipomonta(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgpatologias,patologia,NULL,NULL,id_finca,'. $id_finca,
            ],
            'nomenclatura'=>[
                'required',
            ],
        ]);
        
        //return  $request ->all();

        $tipomontaNueva = new \App\Models\sgtipomonta;

        $tipomontaNueva->nombre = $request->nombre;
        $tipomontaNueva->nomenclatura = $request->nomenclatura;
        $tipomontaNueva->descripcion = $request->descripcion;
        $tipomontaNueva->id_finca = $id_finca;

        $tipomontaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }
    public function editar_tipomonta($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $tipomonta = \App\Models\sgtipomonta::findOrFail($id);
        
        return view('varcontrol.editar_tipo_monta', compact('tipomonta', 'finca'));
    }

    public function update_tipomonta(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
            'nomenclatura'=>[
                'required',
            ],
        ]);

        $tipomontaUpdate = \App\Models\sgtipomonta::findOrFail($id);

        $tipomontaUpdate->nombre=$request->nombre;
        $tipomontaUpdate->nomenclatura=$request->nomenclatura;
        $tipomontaUpdate->descripcion=$request->descripcion;
        
        $tipomontaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_tipomonta($id_finca, $id){
            
        $tipomontaEliminar = \App\Models\sgtipomonta::findOrFail($id);
            
        try {
        $tipomontaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }

/*
************************************************************
* Retorna a la vista de Tablas Menores para Causa de Muerte
************************************************************
*/  
     public function causamuerte($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $causamuerte = \App\Models\sgcausamuerte::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.causa_muerte', compact('causamuerte','finca'));
    }

     public function crear_causamuerte(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgcausamuertes,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $causamuerteNuevo = new \App\Models\sgcausamuerte;

        $causamuerteNuevo->nombre = $request->nombre;

        $causamuerteNuevo->id_finca = $id_finca;

        $causamuerteNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_causamuerte($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $causamuerte = \App\Models\sgcausamuerte::findOrFail($id);
        
        return view('varcontrol.editar_causa_muerte', compact('causamuerte', 'finca'));
    }

    public function update_causamuerte(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $causamuerteUpdate = \App\Models\sgcausamuerte::findOrFail($id);

        $causamuerteUpdate->nombre=$request->nombre;
        
        $causamuerteUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_causamuerte($id_finca, $id){
            
        $causamuerteEliminar = \App\Models\sgcausamuerte::findOrFail($id);
            
        try {
        $causamuerteEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }    

/*
************************************************************
* Retorna a la vista de Tablas Menores para Destino de Salida
************************************************************
*/  
     public function destinosalida($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $destinosalida = \App\Models\sgdestinosalida::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.destino_salida', compact('destinosalida','finca'));
    }

     public function crear_destinosalida(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgdestinosalidas,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $destinosalidaNuevo = new \App\Models\sgdestinosalida;

        $destinosalidaNuevo->nombre = $request->nombre;

        $destinosalidaNuevo->id_finca = $id_finca;

        $destinosalidaNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_destinosalida($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $destinosalida = \App\Models\sgdestinosalida::findOrFail($id);
        
        return view('varcontrol.editar_destino_salida', compact('destinosalida', 'finca'));
    }

    public function update_destinosalida(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $destinosalidaUpdate = \App\Models\sgdestinosalida::findOrFail($id);

        $destinosalidaUpdate->nombre=$request->nombre;
        
        $destinosalidaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_destinosalida($id_finca, $id){
            
        $destinosalidaEliminar = \App\Models\sgdestinosalida::findOrFail($id);
            
        try {
        $destinosalidaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }    

/*
************************************************************
* Retorna a la vista de Tablas Menores para Procedencia
************************************************************
*/  
     public function procedencia($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $procedencia = \App\Models\sgprocedencia::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.procedencia', compact('procedencia','finca'));
    }

     public function crear_procedencia(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgprocedencias,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $procedenciaNueva = new \App\Models\sgprocedencia;

        $procedenciaNueva->nombre = $request->nombre;

        $procedenciaNueva->id_finca = $id_finca;

        $procedenciaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_procedencia($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $procedencia = \App\Models\sgprocedencia::findOrFail($id);
        
        return view('varcontrol.editar_procedencia', compact('procedencia', 'finca'));
    }

    public function update_procedencia(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $procedenciaUpdate = \App\Models\sgprocedencia::findOrFail($id);

        $procedenciaUpdate->nombre=$request->nombre;
        
        $procedenciaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_procedencia($id_finca, $id){
            
        $procedenciaEliminar = \App\Models\sgprocedencia::findOrFail($id);
            
        try {
        $procedenciaEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }

    /*

/*
************************************************************
* Retorna a la vista de Tablas Menores para Procedencia
************************************************************
*/  
     public function colores($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $colores = \App\Models\colorescampo::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.colorescampos', compact('colores','finca'));
    }

     public function crear_colores(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgprocedencias,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $colorNuevo = new \App\Models\colorescampo;

        $colorNuevo->nombre = $request->nombre;

        $colorNuevo->id_finca = $id_finca;

        $colorNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_colores($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $colores = \App\Models\colorescampo::findOrFail($id);
        
        return view('varcontrol.editar_colores_campo', compact('colores', 'finca'));
    }

    public function update_colores(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $colorUpdate = \App\Models\colorescampo::findOrFail($id);

        $colorUpdate->nombre=$request->nombre;
        
        $colorUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_colores($id_finca, $id){
            
        $colorEliminar = \App\Models\colorescampo::findOrFail($id);
            
        try {
        $colorEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }

    /*

************************************************************
* Retorna a la vista de Tablas Menores para Sala ordeno
************************************************************
*/  
     public function salaordeno($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $salaordeno = \App\Models\sgsaladeordeno::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.sala_ordeno', compact('salaordeno','finca'));
    }

     public function crear_salaordeno(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgsaladeordenos,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $salaordenoNueva = new \App\Models\sgsaladeordeno;

        $salaordenoNueva->nombre = $request->nombre;

        $salaordenoNueva->id_finca = $id_finca;

        $salaordenoNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_salaordeno($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $salaordeno = \App\Models\sgsaladeordeno::findOrFail($id);
        
        return view('varcontrol.editar_sala_ordeno', compact('salaordeno', 'finca'));
    }

    public function update_salaordeno(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $salaordenoUpdate = \App\Models\sgsaladeordeno::findOrFail($id);

        $salaordenoUpdate->nombre=$request->nombre;
        
        $salaordenoUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_salaordeno($id_finca, $id){
            
        $salaordenoEliminar = \App\Models\sgsaladeordeno::findOrFail($id);
            
        try {
        $salaordenoEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }        

 /*
************************************************************
* Retorna a la vista de Tablas Menores para Sala ordeno
************************************************************
*/  
     public function tanque($id_finca)
    {
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);
        //$patologia = \App\Models\sgpatologia::all();
        $tanque = \App\Models\sgtanque::where('id_finca', '=', $finca->id_finca)->paginate(5);

        return view('varcontrol.tanque', compact('tanque','finca'));
    }

     public function crear_tanque(Request $request, $id_finca)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
                'unique:sgtanques,nombre,NULL,NULL,id_finca,'. $id_finca,
            ],
        ]);
        
        $tanqueNuevo = new \App\Models\sgtanque;

        $tanqueNuevo->nombre = $request->nombre;

        $tanqueNuevo->id_finca = $id_finca;

        $tanqueNuevo-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_tanque($id_finca, $id){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

        $tanque = \App\Models\sgtanque::findOrFail($id);
        
        return view('varcontrol.editar_tanque', compact('tanque', 'finca'));
    }

    public function update_tanque(Request $request, $id, $id_finca){
       
        $finca =  \App\Models\sgfinca::findOrFail($id_finca);

       //Validando los datos
        $request->validate([
            'nombre'=>[
                'required',
            ],
        ]);

        $tanqueUpdate = \App\Models\sgtanque::findOrFail($id);

        $tanqueUpdate->nombre=$request->nombre;
        
        $tanqueUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }
    
    public function eliminar_tanque($id_finca, $id){
            
        $tanqueEliminar = \App\Models\sgtanque::findOrFail($id);
            
        try {
        $tanqueEliminar->delete();
        return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
        }
    }        
    

}
