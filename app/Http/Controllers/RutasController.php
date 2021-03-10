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
use Barryvdh\DomPDF\Facade as PDF;



class RutasController extends Controller
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
        /*Aqui los controladores del modulo de ganaderia*/

     //Retorna a la vista ficha de ganado
    public function ganaderia($id_finca)
    {
        
        $status=1;
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        //se busca las razas registrada para esa finca
        $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();

        //Se trae el modelo de pajuela por el id de finca
        $pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->get();

        //Se trae el modelo de pajuela por el id de finca
        $tipologia = \App\Models\sgtipologia::where('id_finca', '=', $finca->id_finca)->get();

        $condicion_corporal = \App\Models\sgcondicioncorporal::where('id_finca', '=', $finca->id_finca)->get();

        $serie = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)->where('status','=',$status)->paginate(10);

        $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
            ->where('codpadre','<>',Null)
            ->where('id_tipologia','=',18)
            ->where('status','=',$status)->get();

        //return $serietoro->all();
        //Modelo donde a través de un id se ubica la información en otra tabla.
        $seriesrecords = DB::table('sganims')
             ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)->paginate(10);

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

    public function crear_fichaganado(Request $request, $id_finca)
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

        //$id_finca=1;
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
        $serieNueva->id_finca  = $id_finca;
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

    public function editar_fichaganado($id_finca, $ser)
        {
           
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            //A través del código serie se obtiene el id y lo pasamos al modelo
            $codserie = DB::table('sganims')->select('id')
                ->where('serie', '=', $ser)
                ->where('id_finca', '=', $id_finca)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }
                         
             // $idraza = $codserie->pluck('idraza');
           // $id_condicion = $codserie->pluck('id_condicion');
            // $codpadre = $codserie->pluck('codpadre');
           //$codmadre = $codserie->pluck('codmadre');
            
            $motivoentrada = \App\Models\sgmotivoentradasalida::where('tipo','=','Entrada')->get();

            $serie = \App\Models\sganim::findOrFail($id);//findOrFail(2);
            //$serie = \App\Models\sganim::where('serie', '=', $ser)->get();
            
            //return $serie;

            $tipologia = \App\Models\sgtipologia::where('id_finca', '=', $finca->id_finca)->get();
            
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
                $codbisabuelosmaternomadre = \App\Models\sganim::where('serie', '=', $serie->codmadre)
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
                    'codbisabuelosmaternospadre','finca','motivoentrada'));
        }

    public function update_fichaganado(Request $request, $ser, $id_finca)
    {
        if ($request->status=="on") {
            $request->validate([
            'motivoentrada'=>[
                'required',
            ],
        ]);
        }
        //Validando los datos
        $request->validate([
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
        
        //con el numero de serie obtenemos su id
        //A través del código serie se obtiene el id y lo pasamos al modelo
        $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)
        ->where('id_finca', '=', $id_finca)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }
   
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        //Valida los Checks
        $request->espajuela = ($request->espajuela=="on")?($request->espajuela=true):($request->espajuela=false);

        //Valida que el serial provenga de una Serie Toro o Pajuela.
        $seriepadre = ($request->espajuela=="on")?($seriepadre=null):($seriepadre=$request->seriepadre);
        
        $codpajuela = ($request->espajuela=="on")?($codpajuela=$request->pajuela):($codpajuela =  null);

        $request->status = ($request->status=="on")?($request->status=true):($request->status=false);

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
        
        //Se obtiene la fecha entrada con la actual.
        if ($request->status=="on") {
         $serieUpdate->fecentrada = Carbon::now();
         $serieUpdate->motivo= $request->motivoentrada;   
        }
       // return $request;
        $serieUpdate-> save(); 

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    
    
    // Se obtiene el request para guardar los valores en las tablas sganims y sgpesos.
    public function registar_pesoespecifico ($id_finca, $ser)
        {
            
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            //A través del código serie se obtiene el id y lo pasamos al modelo
            $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }

            $serie = \App\Models\sganim::findOrFail($id);
            
            //Calculamos los días para el campo días.
            $dias = Carbon::parse($serie->fnac)->diffIndays(Carbon::now());
            

            //colocamos un filtro para mostrar la tabla de registro de peso
            $registropeso = \App\Models\sgpeso::where('id_serie', '=', $serie->id)
                ->where('id_finca', '=', $finca->id_finca)
                ->paginate(5);

            //generamos el mismo modelo para generar la grafica
            //colocamos un filtro para mostrar la tabla de registro de peso
            $graficapeso = \App\Models\sgpeso::where('id_serie', '=', $serie->id)
                ->where('id_finca', '=', $finca->id_finca)
                ->pluck('peso');    

            $graficafecha = \App\Models\sgpeso::where('id_serie', '=', $serie->id)
                ->where('id_finca', '=', $finca->id_finca)
                ->pluck('fecha');    
    

            //return $graficapeso->all();

            return view('pesoespecifico', compact('serie', 'finca', 'registropeso','dias','graficapeso','graficafecha'));
        } 


    public function crear_pesoespecifico (Request $request,  $id_finca, $ser)
        {
           //dd($id_finca, $ser); 
            //return $request->all();
            //Se buscala finca por su id - Segun modelo

            $request->validate([
                'fecha'=>[
                    'required',
                ],
                'peso'=>[
                    'required',
                ],
            ]);
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

              //A través del código serie se obtiene el id y lo pasamos al modelo
            $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }

            $serie = \App\Models\sganim::findOrFail($id);
            
            //validamos la condicion si se trata de un peso de destete
            $request->destatado = ($request->destatado=="on")?($request->destatado=true):($request->destatado=false);

            $pesoNuevo = new \App\Models\sgpeso;

            $pesoNuevo->id_finca = $finca->id_finca;
            $pesoNuevo->id_serie = $serie->id;
            $pesoNuevo->serie = $serie->serie;
            $pesoNuevo->peso = $request->peso;
            $pesoNuevo->gdp = $request->gdp;
            $pesoNuevo->dias = $request->dias;
            $pesoNuevo->pgan = $request->pgan;
            $pesoNuevo->fecha = $request->fecha;
            $pesoNuevo->difdia = $request->difdia;
            $pesoNuevo->destetado = $request->destatado;


            $pesoNuevo-> save();
 
            /*
            * Actualizar la Tipología en caso de un destete 
            * de forma automática
            */
            $edad = Carbon::parse($serie->fnac)->diffInDays(Carbon::now());

            if ($request->destatado =="on") {
                
                $buscatipologia = DB::table('sgtipologias')->select('id_tipologia')
                   ->where('id_finca','=',$id_finca)
                   ->where('destetado','=',$request->destatado)
                   ->where('sexo','=',$serie->sexo)
                   ->where('edad','<',365)
                   ->whereBetween('peso',[$request->pesoi,$request->peso])
                   ->where('nro_monta','=',$serie->nro_monta)
                   ->where('prenada','=',$serie->prenada)
                   ->where('parida','=',$serie->parida)
                   ->where('tienecria','=',$serie->tienecria)
                   ->where('criaviva','=',$serie->criaviva)
                   ->where('ordenho','=',$serie->ordenho)
                   ->where('detectacelo','=',$serie->detectacelo)->get();
              

            foreach ($buscatipologia as $id_tipo) 
            {
                $idtipo = (int) $id_tipo->id_tipologia;
            }     


                $tipologia = \App\Models\sgtipologia::findOrFail($idtipo);

               // $tipologianame = $buscatipologia->pluck('nombre_tipologia');     
               // $tipologia_id = $buscatipologia->pluck('id_tipologia');     
                
                $fuedestetado = $request->destatado;
                $pesodedestete = $request->peso;
                $fecdes = $request->fecha;

                $updatepesoserie = DB::table('sganims')
                                ->where('id',$serie->id)
                                ->where('id_finca', $finca->id_finca)
                                ->update([
                                    'pesoactual'  => $request->peso,
                                    'fulpes'      => $request->fecha,
                                    'destatado'   => $fuedestetado,
                                    'pesodestete' => $pesodedestete, 
                                    'fecdes'      => $fecdes, 
                                    'ultgdp'      => $request->gdp,
                                    'tipo'        => $tipologia->nombre_tipologia,
                                    'id_tipologia'=> $tipologia->id_tipologia,
                                    ]);

                return back()->with('mensaje', 'ok');     
                                        
            } else {
                //Los cambios se dan por sugerencia
                $updatepesoserie = DB::table('sganims')
                                    ->where('id',$serie->id)
                                    ->where('id_finca', $finca->id_finca)
                                    ->update(['pesoactual'=>$request->peso,
                                        'fulpes'=>$request->fecha,
                                    //    'destatado'=> $fuedestetado,
                                    //    'pesodestete'=>$pesodedestete, 
                                    //    'fecdes'=>$pesodedestete, 
                                        'ultgdp'=>$request->gdp]);
            
            return back()->with('msj', 'Registro creado satisfactoriamente');
            //return view('editarfichaganado')->with('msj', 'Registro creado satisfactoriamente');
        }

    }       
    
    //Retorna a la vista lote
    public function lote($id_finca)
    {
           //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        //$lote = \App\Models\sglote::all();
        //$lote = \App\Models\sglote::paginate(4);
        $lote = \App\Models\sglote::where('id_finca', '=', $finca->id_finca)->paginate(4);

        return view('lote', compact('lote', 'finca'));
        //return view('lote');
    }

        //Con esto Agregamos datos en la tabla lote
            public function crear_lote(Request $request, $id_finca)
        {
            
            //Validando los datos
            $request->validate([
                'nombre_lote'=> [
                	'required',
                	'unique:sglotes,nombre_lote,NULL,NULL,id_finca,'.$id_finca,
                ],
                'tipo'=>[
                	'required',
                ],
            ]);
            
            $loteNuevo = new \App\Models\sglote;

            $loteNuevo->nombre_lote = $request->nombre_lote;
            $loteNuevo->tipo = $request->tipo;
            $loteNuevo->funcion = $request->funcion;
    	 	$loteNuevo->slug =  str::slug($request['nombre_lote'], '-');
            $loteNuevo->id_finca = $id_finca;

            $loteNuevo-> save(); 
       		//return response()->json(['slug' => $loteNuevo->slug]);
            return back()->with('msj', 'Registro agregado satisfactoriamente');
        }


        public function editar_lote($id_finca, $id_lote)
        {
            $finca =  \App\Models\sgfinca::findOrFail($id_finca);   
            $lote = \App\Models\sglote::findOrFail($id_lote);
            return view('editarlote', compact('lote', 'finca'));
        }

        public function update_lote(Request $request, $id_lote, $id_finca)
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

        public function eliminar_lote($id_finca, $id_lote)
        {
                
            $loteEliminar = \App\Models\sglote::findOrFail($id_lote);
            $subloteEliminar = \App\Models\sgsublote::where('nombre_lote', '=', $loteEliminar->nombre_lote);
             
            try {
            $loteEliminar->delete();
            $subloteEliminar->delete();   
            return back()->with('mensaje', 'ok');     

            }catch (\Illuminate\Database\QueryException $e){
                return back()->with('mensaje', 'error');
            }
        }
        // END LOTE--->

    		//---> Se crea las rutas para asociar los sub lotes a cada Lotes Principal.
    		 public function sublote($id_finca, $id_lote)
		    {
            
            

		        $finca = \App\Models\sgfinca::findOrFail($id_finca);
                //modelo de cada lote
		        $lote = \App\Models\sglote::findOrFail($id_lote);
		        
		        //$sublote = \App\Models\sgsublote::all();
                //filtra la tabla por el nombre de lote principal
		      	$sublote = \App\Models\sgsublote::where('nombre_lote', '=', $lote->nombre_lote)
                    ->where('id_finca', '=', $finca->id_finca)->get();
		        
		        return view('sublote', compact('sublote','lote','finca'));
		        //return view('lote');
		    }
		  
		    //Con esto Agregamos datos en la tabla sublote.
        	public function crear_sublote(Request $request, $id_finca)
    		{
   
           // return $request->all();
	        //Validando los datos
		        $request->validate([
		            'sub_lote'=> [
		            	'required',
                       // 'unique:sgsublotes,sub_lote,NULL,NULL,nombre_lote,'. $id_finca,
                  
		            ],
		            'nombre_lote'=>[
		            	'required',
                        //'unique:sgsublotes,nombre_lote,NULL,NULL,sub_lote,'. $request['sub_lote'],
		            ],
		        ]);
		    
		        $subloteNuevo = new \App\Models\sgsublote;

		        $subloteNuevo->sub_lote = $request->sub_lote;
		        $subloteNuevo->nombre_lote = $request->nombre_lote;
                $subloteNuevo->id_finca = $request->id_finca;

		        $subloteNuevo-> save(); 
		        
		        return back()->with('msj', 'Registro agregado satisfactoriamente');
		    }
		    
		   public function eliminar_sublote($id_finca, $id_sublote){
            
		        $subloteEliminar = \App\Models\sgsublote::findOrFail($id_sublote);
		        
                try {
                $subloteEliminar->delete();   
                return back()->with('mensaje', 'ok');     

                }catch (\Illuminate\Database\QueryException $e){
                    return back()->with('mensaje', 'error');
                }
		    }

    		// END SUBLOTE--->

		    // Begin Asignacción de series a un Lote Padre->>

		    //---> Se crea las rutas para asociar los lotes a cada serie
    		public function seriesenlote(Request $request, $id_finca, $id_lote)
		    {
               // dd($request, $id_lote, $id_finca);

		        $finca = \App\Models\sgfinca::findOrFail($id_finca);
                //Obtenemos el nombre del lote.
		        $lote = \App\Models\sglote::findOrFail($id_lote);
		        
                
                if (! empty($request->serie) ) {
                   $seriesenlote = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                    ->where('nombrelote', '=', $lote->nombre_lote)
                    ->where('sub_lote','=',Null)
                    ->where('id_finca','=',$id_finca)->take(7)->paginate(7);
                } else {
                    $seriesenlote = \App\Models\sganim::where('nombrelote', '=', $lote->nombre_lote)
                        ->where('id_finca','=',$id_finca)
                        ->where('sub_lote','=',Null)->take(7)->paginate(7);  
                }
                
		        //filtro
		      	
		      //$serieasignarlote = \App\Models\sganim::paginate(5);
		        
		        return view('detalleserielote', compact('seriesenlote','lote','finca'));
		        //return view('lote');
		        
		    }
            public function seriesensublote(Request $request, $id_finca, $id_sublote)
            {
                

                $finca = \App\Models\sgfinca::findOrFail($id_finca);
                //Obtenemos el nombre del lote.
                $sublote = \App\Models\sgsublote::findOrFail($id_sublote);
                
                if (! empty($request->serie) ) {
                   $seriesensublote = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                    ->where('sub_lote', '=', $sublote->sub_lote)
                    ->where('nombrelote','=',$sublote->nombre_lote)
                    ->where('id_finca','=',$finca->id_finca)->take(7)->paginate(7);
                } else {
                    $seriesensublote = \App\Models\sganim::where('sub_lote', '=', $sublote->sub_lote)
                        ->where('id_finca','=',$finca->id_finca)
                        ->where('nombrelote','=',$sublote->nombre_lote)->get();
                }
                
                return view('detalleseriesublote', compact('seriesensublote','sublote','finca'));
                //return view('lote');                
            }

		    //Retorna a la vista para asignar la (s) serie (s) a un lote
	        public function asignarseries(Request $request, $id_finca)
		    {
		        //return $request;

                $finca = \App\Models\sgfinca::findOrFail($id_finca);
                //->Se muestran las series 
		        //$asignarseries = \App\Models\sganim::paginate(7);
                if (! empty($request->serie) ) {
                   $asignarseries = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                    ->where('id_finca','=',$id_finca)
                    ->take(7)->paginate(7);
                } else {
                    $asignarseries = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                    ->where('id_finca','=',$id_finca)
                    ->take(7)->paginate(7);
                }

		      	$lote = \App\Models\sglote::all()->pluck('nombre_lote');	
						    
		     	return view('asignarseries', compact('asignarseries','lote', 'finca'));

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
 		
     		public function asignar_serielote(Request $request, $id_finca)
    		{
    			$finca = \App\Models\sgfinca::findOrFail($id_finca);

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
                    $HistorialLoteNuevo->id_finca = $finca->id_finca;


                    $HistorialLoteNuevo-> save();   

                    $asignarserielote = DB::table('sganims')
                                    ->where('id',$request->id[$i])
                                    ->where('id_finca', $finca->id_finca)
                                    ->update(['nombrelote'=>$request->nombrelote, 'sub_lote'=>$request->sublote]);    
    			}   
    				
    	       return back()->with('msj', 'Serie (s) asignada satisfactoriamente');
    	    }
		   
    //Retorna a la vista pajuela
        public function pajuela(Request $request, $id_finca)
        {
           //return $request->all();
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            //se busca las razas registrada para esa finca
            $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();

            //Se trae el modelo de pajuela por el id de finca
            //$pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->paginate(7);

            $pajuela= \App\Models\sgpaju::where('serie', 'like', $request->pajuela."%")
                ->where('id_finca', '=', $finca->id_finca)
                ->take(7)->paginate(7);

            $especie = \App\Models\sgespecie::where('id_finca', '=', $finca->id_finca)->get();
           
            //Modelo donde a través de un id se ubica la información en otra tabla.
            $records = DB::table('sgpajus')
             ->join('sgrazas', 'sgrazas.idraza', '=', 'sgpajus.id')
             ->get();


            //return $records->all();
            return view('pajuela', compact('pajuela','finca','raza','records','especie'));
        }
    
        //Con esto Agregamos datos en la tabla pajuela
        public function crear_pajuela(Request $request, $id_finca)
        {
            
            $request->validate([
                'raza'=> [
                    'required',
                    //Rule::unique('sgrazas')->ignore($request->idraza),
                ],
                'serie'=> [
                    'required',
                    'unique:sgpajus,serie,NULL,NULL,id_finca,'. $id_finca,
                ],
                'especie'=> [
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
            $pajuelaNueva->id_finca = $id_finca;

            $pajuelaNueva-> save(); 
            //return response()->json(['slug' => $loteNuevo->slug]);
            return back()->with('msj', 'Registro agregado satisfactoriamente');
        }

        public function editar_pajuela($id_finca, $id)
        {
           
            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);

            $pajuela = \App\Models\sgpaju::findOrFail($id);

            $snom = $pajuela->snom;

            // La especie solo sirve para filtrar la raza aqui en pajuela
            $especie = \App\Models\sgespecie::where('id_finca', '=', $finca->id_finca)->get();
                  
            //se busca las razas registrada para esa finca
            $raza = \App\Models\sgraza::where('id_finca', '=', $finca->id_finca)->get();
            

            return view('editarpajuela', compact('pajuela','finca','raza','especie'));
        }

        public function update_pajuela(Request $request, $id, $id_finca)
        {
            
            //Valida que  las series sean requeridos y que no se repitan.
            $request->validate([
                'serie'=> [
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
            $pajuelaUpdate->id_finca = $id_finca;

            $pajuelaUpdate-> save(); 

            return back()->with('msj', 'Registro actualizado satisfactoriamente');
        }
        public function eliminar_pajuela($id_finca, $id)
        {
            
            $pajuelaEliminar = \App\Models\sgpaju::findOrFail($id);
                
            try {
            $pajuelaEliminar->delete();
            return back()->with('mensaje', 'ok');     

            }catch (\Illuminate\Database\QueryException $e){
                return back()->with('mensaje', 'error');
            }

        }

    //Retorna a la vista transferencia
        public function transferencia(Request $request, $id_finca)
    {

            //Se buscala finca por su id - Segun modelo
            $finca = \App\Models\sgfinca::findOrFail($id_finca);
            //->Se muestran las series 
            //$asignarseries = \App\Models\sganim::paginate(7);
            if (! empty($request->serie) ) {
               $transferseries = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                ->where('id_finca','=',$id_finca)
                ->where('status','=',1)
                ->take(7)->paginate(7);
            } else {
                $transferseries = \App\Models\sganim::where('serie', 'like', $request->serie."%")
                ->where('id_finca','=',$id_finca)
                ->where('status','=',1)
                ->take(7)->paginate(7);
            }
            
            $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=',"Salida") 
            ->get();
            /*
             $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=',"Salida") 
            ->where('id_finca','=',$id_finca)->get();
            */

            $destino = \App\Models\sgfinca::all();  

            $fecsalida = Carbon::now()->format('Y-m-d');

            $transfrealizada = \App\Models\sgtransferencia::whereDate('fecs','=',$fecsalida) 
            ->where('id_finca','=',$id_finca)->get();

           // return $transfrealizada; 

        //return $destino->all();     

        return view('transferencia',compact('finca','transferseries','motivo', 'destino','transfrealizada'));
    }

    public function transferir_series(Request $request, $id_finca)
    {
   
        //Finca de origen        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $request->validate([
            'id'=>[
                'required',
            ],
            'fecs'=>[
                'required',
            ],
            'motivo'=>[
                'required',
            ],
            'destino'=>[
                'required',
            ],
            'obser'=>[
                'required',
            ],
        ]);
        
        //Aquí ubicamos la finca destino        
        $fincadestino = \App\Models\sgfinca::findOrFail($request->destino);

        //Corremos el indice para cada serie qe viene en el array[$request]
        $cont = count($request->id);
        for($i=0; $i < $cont; $i++){    
            
            //Obtenemos las series que se van a transferir con su ID
            $series = \App\Models\sganim::findOrFail($request->id[$i]);
            //Obtenemos  el motivo de salida
            $motivosal = \App\Models\sgmotivoentradasalida::findOrFail($request->motivo);
           
            //Buscamos si realmente exite la serie en la finca destino. 
            $seriesfincadestino = DB::table('sganims')
                ->where('serie','=', $series->serie)
                ->where('id_finca','=', $request->destino)->get();    
           
            // $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)->get();
            //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
           
            if ($seriesfincadestino->count() > 0) {
             
             // si existe ubicamos sus ID para luego pasarsela al modelo y ubicar sus 
             // codigo de series.
             foreach ($seriesfincadestino as $serieid) {
                $id[$i]= (int) $serieid->id;
            }   
             
             /*
             * Se comprueba que la serie existe $seriefincadestino
             * Luego se ubica (n)  la (s) serie (s)
             * Se registran en sgtransferencias y sghsal
             * Luego seactualizan (update) de los datos de la serie transferida 
             */
             
                $seriedesti = \App\Models\sganim::findOrFail($id[$i]);

                //return $seriedesti;
                
                $fecsalida = Carbon::now();
                
                $transferenciaNuevo = new \App\Models\sgtransferencia;
                
                $transferenciaNuevo->id_serie = $request->id[$i];
                $transferenciaNuevo->serie = $series->serie;
                $transferenciaNuevo->codm= $series->codmadre;
                $transferenciaNuevo->codp= $series->codpadre;
                $transferenciaNuevo->espajuela= $series->espajuela;
                $transferenciaNuevo->paju= $series->pajuela;
                $transferenciaNuevo->fnac= $series->fnac;
                $transferenciaNuevo->fecr= $series->fecr;
                $transferenciaNuevo->fecs= $fecsalida;
                $transferenciaNuevo->destino= $fincadestino->nombre;
                $transferenciaNuevo->id_tipologia= $series->id_tipologia;
                $transferenciaNuevo->tipo= $series->tipo;
                $transferenciaNuevo->idraza= $series->idraza;
                $transferenciaNuevo->sexo= $series->sexo;
                $transferenciaNuevo->obser= $request->obser;
                $transferenciaNuevo->procede= $finca->nombre;
                $transferenciaNuevo->id_condicion= $series->id_condicion;
                $transferenciaNuevo->pesoi= $series->pesoi;
                $transferenciaNuevo->pesoactual= $series->pesoactual;
                $transferenciaNuevo->fulpes= $series->fulpes;
                $transferenciaNuevo->destatado= $series->destatado;
                $transferenciaNuevo->pesodestete= $series->pesodestete;
                $transferenciaNuevo->fecdes= $series->fecdes;
                $transferenciaNuevo->nparto= $series->nparto;
                $transferenciaNuevo->dparto= $series->dparto;
                $transferenciaNuevo->pesodestete= $series->pesodestete;
                $transferenciaNuevo->nservi= $series->nservi;
                $transferenciaNuevo->fecua= $series->fecua;
                $transferenciaNuevo->fecup= $series->fecup;
                $transferenciaNuevo->abort= $series->abort;
                $transferenciaNuevo->edad= $series->edad;
                $transferenciaNuevo->edadpp= $series->edadpp;
                $transferenciaNuevo->tipoap= $series->tipoap;
                $transferenciaNuevo->tipops= $series->tipops;
                $transferenciaNuevo->lote= $series->nombrelote;
                $transferenciaNuevo->sublote= $series->sub_lote;
                $transferenciaNuevo->lprod= $series->lprod;
                $transferenciaNuevo->sublprod= $series->sublprod;
                $transferenciaNuevo->lpast= $series->lpast;
                $transferenciaNuevo->sublpast= $series->sublpast;
                $transferenciaNuevo->ltemp= $series->ltemp;
                $transferenciaNuevo->subltemp= $series->subltemp;
                $transferenciaNuevo->ulgdp= $series->ultgdp;
                $transferenciaNuevo->pa1= $series->pa1;
                $transferenciaNuevo->pa2= $series->pa2;
                $transferenciaNuevo->pa3= $series->pa3;
                $transferenciaNuevo->pa4= $series->pa4;
                $transferenciaNuevo->ua= $series->ua;
                $transferenciaNuevo->ncrias= $series->ncrias;
                $transferenciaNuevo->npartorepor= $series->npartorepor;
                $transferenciaNuevo->nabortoreport= $series->nabortoreport;
                $transferenciaNuevo->id_motivo_salida= $request->motivo;
                $transferenciaNuevo->id_finca= $finca->id_finca;

             $transferenciaNuevo-> save();   

                //Luego creamos la tabla sghsalidas
                if ($series->fecr == null) {
                    $series->fecr = $series->fnac;
                } else {
                    $series->fecr = $series->fecr; 
                }
                

                $serieHistoriaSal = new \App\Models\sghsal;

                $serieHistoriaSal->id_serie = $request->id[$i];
                $serieHistoriaSal->serie = $series->serie;
                $serieHistoriaSal->motivo = $motivosal->nombremotivo;
                $serieHistoriaSal->fechs = $request->fecs;
                $serieHistoriaSal->procede = $finca->nombre;
                $serieHistoriaSal->destino = $fincadestino->nombre;
                $serieHistoriaSal->peso = $series->pesoactual;
                $serieHistoriaSal->feche = $series->fecr;
                $serieHistoriaSal->e_s = 0;
                $serieHistoriaSal->id_motsal = $request->motivo;
                $serieHistoriaSal->obser = $request->obser;
                $serieHistoriaSal->id_finca = $finca->id_finca;

                $serieHistoriaSal-> save();

                //actualizamos los datos en la finca destino
                $serieNuevaFinca = DB::table('sganims')
                            ->where('id',$seriedesti->id)
                            ->where('id_finca', $fincadestino->id_finca)
                            ->update(
                                ['status'      => 1,
                                 'nombrelote'  => $series->nombrelote,
                                 'sub_lote'    => $series->sub_lote,
                                 'codmadre'    => $series->codmadre,
                                 'codpadre'    => $series->codpadre,
                                 'espajuela'   => $series->espajuela,
                                 'pajuela'     => $series->pajuela,
                                 'fnac'        => $series->fnac,
                                 'fecr'        => $series->fecr,
                                 'fecentrada'  => $fecsalida,
                                 'tipo'        => $series->tipo,
                                 'tipoanterior'=> $series->tipoanterior,
                                 'sexo'        => $series->sexo,
                                 'observa'     => $request->obser,
                                 'procede'     => $finca->nombre,
                                 'pesoi'       => $series->pesoi,
                                 'pesoactual'  => $series->pesoactual,
                                 'fulpes'      => $series->fulpes,
                                 'destatado'   => $series->destatado,
                                 'pesodestete' => $series->pesodestete,
                                 'fecdes'      => $series->fecdes,
                                 'pa1'         => $series->pa1,
                                 'pa2'         => $series->pa2,
                                 'pa3'         => $series->pa3,
                                 'pa4'         => $series->pa4,
                                 'ua'          => $series->ua,
                                 'nparto'      => $series->nparto,
                                 'dparto'      => $series->dparto,
                                 'nservi'      => $series->nservi,
                                 'fecua'       => $series->fecua,
                                 'fecup'       => $series->fecup,
                                 'abort'       => $series->abort,
                                 'edad'        => $series->edad,
                                 'edadpp'      => $series->edadpp,
                                 'pesopp'      => $series->pesopp,
                                 'ultgdp'      => $series->ultgdp,
                                 'ncrias'      => $series->ncrias,
                                 'npartorepor' => $series->npartorepor,
                                 'nabortoreport'=> $series->nabortoreport,  
                                 'nro_monta'   => $series->nro_monta,
                                 'prenada'     => $series->prenada,
                                 'parida'      => $series->parida,
                                 'tienecria'   => $series->tienecria,
                                 'criaviva'    => $series->criaviva,
                                 'ordenho'     => $series->ordenho,
                                 'detectacelo' => $series->detectacelo,
                                 'id_tipologia'=> $series->id_tipologia,
                                 'idraza'      => $series->idraza,
                                 'id_condicion'=> $series->id_condicion,
                                 'lprod'       => $series->lprod,
                                 'lpast'       => $series->lpast,
                                 'ltemp'       => $series->ltemp,
                                 'lnaci'       => $series->lnaci,
                                 'id_finca'    => $fincadestino->id_finca
                                ]);  

                //Luego acualizamos el status a inactivo en serie origen
                $updateserie = DB::table('sganims')
                            ->where('id',$request->id[$i])
                            ->where('id_finca', $finca->id_finca)
                            ->update(['status'=>0,'motivo'=>$motivosal->nombremotivo,
                                'fecs'=>$fecsalida]); 

            } else {

                $fecsalida = Carbon::now();
                
                $transferenciaNuevo = new \App\Models\sgtransferencia;
                
                $transferenciaNuevo->id_serie = $request->id[$i];
                $transferenciaNuevo->serie = $series->serie;
                $transferenciaNuevo->codm= $series->codmadre;
                $transferenciaNuevo->codp= $series->codpadre;
                $transferenciaNuevo->espajuela= $series->espajuela;
                $transferenciaNuevo->paju= $series->pajuela;
                $transferenciaNuevo->fnac= $series->fnac;
                $transferenciaNuevo->fecr= $series->fecr;
                $transferenciaNuevo->fecs= $fecsalida;
                $transferenciaNuevo->destino= $fincadestino->nombre;
                $transferenciaNuevo->id_tipologia= $series->id_tipologia;
                $transferenciaNuevo->tipo= $series->tipo;
                $transferenciaNuevo->idraza= $series->idraza;
                $transferenciaNuevo->sexo= $series->sexo;
                $transferenciaNuevo->obser= $request->obser;
                $transferenciaNuevo->procede= $finca->nombre;
                $transferenciaNuevo->id_condicion= $series->id_condicion;
                $transferenciaNuevo->pesoi= $series->pesoi;
                $transferenciaNuevo->pesoactual= $series->pesoactual;
                $transferenciaNuevo->fulpes= $series->fulpes;
                $transferenciaNuevo->destatado= $series->destatado;
                $transferenciaNuevo->pesodestete= $series->pesodestete;
                $transferenciaNuevo->fecdes= $series->fecdes;
                $transferenciaNuevo->nparto= $series->nparto;
                $transferenciaNuevo->dparto= $series->dparto;
                $transferenciaNuevo->pesodestete= $series->pesodestete;
                $transferenciaNuevo->nservi= $series->nservi;
                $transferenciaNuevo->fecua= $series->fecua;
                $transferenciaNuevo->fecup= $series->fecup;
                $transferenciaNuevo->abort= $series->abort;
                $transferenciaNuevo->edad= $series->edad;
                $transferenciaNuevo->edadpp= $series->edadpp;
                $transferenciaNuevo->tipoap= $series->tipoap;
                $transferenciaNuevo->tipops= $series->tipops;
                $transferenciaNuevo->lote= $series->nombrelote;
                $transferenciaNuevo->sublote= $series->sub_lote;
                $transferenciaNuevo->lprod= $series->lprod;
                $transferenciaNuevo->sublprod= $series->sublprod;
                $transferenciaNuevo->lpast= $series->lpast;
                $transferenciaNuevo->sublpast= $series->sublpast;
                $transferenciaNuevo->ltemp= $series->ltemp;
                $transferenciaNuevo->subltemp= $series->subltemp;
                $transferenciaNuevo->ulgdp= $series->ultgdp;
                $transferenciaNuevo->pa1= $series->pa1;
                $transferenciaNuevo->pa2= $series->pa2;
                $transferenciaNuevo->pa3= $series->pa3;
                $transferenciaNuevo->pa4= $series->pa4;
                $transferenciaNuevo->ua= $series->ua;
                $transferenciaNuevo->ncrias= $series->ncrias;
                $transferenciaNuevo->npartorepor= $series->npartorepor;
                $transferenciaNuevo->nabortoreport= $series->nabortoreport;
                $transferenciaNuevo->id_motivo_salida= $request->motivo;
                $transferenciaNuevo->id_finca= $finca->id_finca;

                $transferenciaNuevo-> save();   

                //Luego creamos la tabla sghsalidas
                if ($series->fecr == null) {
                    $series->fecr = $series->fnac;
                } else {
                    $series->fecr = $series->fecr; 
                }
                

                $serieHistoriaSal = new \App\Models\sghsal;

                $serieHistoriaSal->id_serie = $request->id[$i];
                $serieHistoriaSal->serie = $series->serie;
                $serieHistoriaSal->motivo = $motivosal->nombremotivo;
                $serieHistoriaSal->fechs = $request->fecs;
                $serieHistoriaSal->procede = $finca->nombre;
                $serieHistoriaSal->destino = $fincadestino->nombre;
                $serieHistoriaSal->peso = $series->pesoactual;
                $serieHistoriaSal->feche = $series->fecr;
                $serieHistoriaSal->e_s = 0;
                $serieHistoriaSal->id_motsal = $request->motivo;
                $serieHistoriaSal->obser = $request->obser;
                $serieHistoriaSal->id_finca = $finca->id_finca;

                $serieHistoriaSal-> save();

                //luego creamos la (s) series en la tabla sganims para la nueva finca en estatus activos

                $serieNuevaFinca = new \App\Models\sganim;


                $serieNuevaFinca->serie = $series->serie;
                $serieNuevaFinca->nombrelote= $series->nombrelote;
                $serieNuevaFinca->sub_lote= $series->sub_lote;
                $serieNuevaFinca->codmadre= $series->codmadre;
                $serieNuevaFinca->codpadre= $series->codpadre;
                $serieNuevaFinca->espajuela= $series->espajuela;
                $serieNuevaFinca->pajuela= $series->pajuela;
                $serieNuevaFinca->fnac= $series->fnac;
                $serieNuevaFinca->fecr= $series->fecr;
                //$serieNuevaFinca->fecs= null;
                //$serieNuevaFinca->motivo = null;
                $serieNuevaFinca->fecentrada= $fecsalida;
                $serieNuevaFinca->status= 1;
                $serieNuevaFinca->tipo= $series->tipo;
                $serieNuevaFinca->tipoanterior= $series->tipoanterior;
                $serieNuevaFinca->sexo= $series->sexo;
                $serieNuevaFinca->observa= $series->observa;
                $serieNuevaFinca->procede= $finca->nombre;
                $serieNuevaFinca->pesoi= $series->pesoi;
                $serieNuevaFinca->pesoactual= $series->pesoactual;
                $serieNuevaFinca->fulpes= $series->fulpes;
                $serieNuevaFinca->destatado= $series->destatado;
                $serieNuevaFinca->pesodestete= $series->pesodestete;
                $serieNuevaFinca->fecdes= $series->fecdes;
                $serieNuevaFinca->pa1= $series->pa1;
                $serieNuevaFinca->pa2= $series->pa2;
                $serieNuevaFinca->pa3= $series->pa3;
                $serieNuevaFinca->pa4= $series->pa4;
                $serieNuevaFinca->ua= $series->ua;
                $serieNuevaFinca->nparto= $series->nparto;
                $serieNuevaFinca->dparto= $series->dparto;
                $serieNuevaFinca->nservi= $series->nservi;
                $serieNuevaFinca->fecua= $series->fecua;
                $serieNuevaFinca->fecup= $series->fecup;
                $serieNuevaFinca->abort= $series->abort;
                $serieNuevaFinca->edad= $series->edad;
                $serieNuevaFinca->edadpp= $series->edadpp;
                $serieNuevaFinca->pesopp= $series->pesopp;
                $serieNuevaFinca->ultgdp= $series->ultgdp;
                $serieNuevaFinca->ncrias= $series->ncrias;
                $serieNuevaFinca->npartorepor= $series->npartorepor;
                $serieNuevaFinca->nabortoreport= $series->nabortoreport;
                /*
                * Parametros Tipológicos
                */
                $serieNuevaFinca->nro_monta= $series->nro_monta;
                $serieNuevaFinca->prenada= $series->prenada;
                $serieNuevaFinca->parida= $series->parida;
                $serieNuevaFinca->tienecria= $series->tienecria;
                $serieNuevaFinca->criaviva= $series->criaviva;
                $serieNuevaFinca->ordenho= $series->ordenho;
                $serieNuevaFinca->detectacelo= $series->detectacelo;
                $serieNuevaFinca->id_tipologia= $series->id_tipologia;
                $serieNuevaFinca->idraza= $series->idraza;
                $serieNuevaFinca->id_condicion= $series->id_condicion;
                $serieNuevaFinca->lprod= $series->lprod;
                $serieNuevaFinca->lpast= $series->lpast;
                $serieNuevaFinca->ltemp= $series->ltemp;
                $serieNuevaFinca->lnaci= $series->lnaci;
                $serieNuevaFinca->id_finca= $fincadestino->id_finca;

                $serieNuevaFinca->save(); 

                //Luego acualizamos el status a inactivo en serie origen
                $updateserie = DB::table('sganims')
                            ->where('id',$request->id[$i])
                            ->where('id_finca', $finca->id_finca)
                            ->update(['status'=>0,'motivo'=>$motivosal->nombremotivo,
                                'fecs'=>$fecsalida]);
            }
            
        }   
                    
        return back()->with('msj', 'Serie (s) transferida (s) satisfactoriamente');
    }


    //Retorna a la vista de transferencia.
    public function vista_reportestransferencia(Request $request, $id_finca)
    {
       
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
    
        $destino = \App\Models\sgfinca::all();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();

        $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get();  
        
        $transfrealizada = \App\Models\sgtransferencia::where('id_finca','=',$id_finca)
           ->paginate(10); 

        
          

        return view('info.transferencias_realizadas',compact('finca','transfrealizada','tipologia','destino','motivo'));
    }

     //Retorna a la vista general de reportes
        public function vista_reportesgenerales($id_finca)
    {
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
    
        return view('info.vista_reportes_generales',compact('finca'));
    }

    //Retorna a la vista de transferencia.
    public function vista_reportecatalogoganado(Request $request, $id_finca)
    {
       
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $status = 1; //Status activos

        $lote = \App\Models\sglote::where('id_finca','=',$id_finca)
            ->get();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
            ->get();


    /*
        $catalogoganado = \App\Models\sganim::where('id_finca','=',$id_finca)
           ->paginate(10); 
    */
           $catalogoganado = DB::table('sganims')
                ->select('sganims.serie', 'sgrazas.nombreraza','sgcondicioncorporals.nombre_condicion', 'sganims.codmadre', 'sganims.edad','sgtipologias.nomenclatura', 'sganims.fnac', 'sganims.pesoi','sganims.nombrelote','sganims.sub_lote','sganims.codpadre', 'sganims.fulpes','sganims.pesoactual' )
                ->join('sgrazas', 'sgrazas.idraza', '=', 'sganims.idraza')
                ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')
                ->join('sgcondicioncorporals', 'sgcondicioncorporals.id_condicion', '=', 'sganims.id_condicion')
                ->where('sganims.id_finca','=',$finca->id_finca)
                ->where('sganims.status','=',$status)
                ->paginate(10);

        //return $catalogoganado->all();
                
        return view('info.catalogo_de_ganado',compact('finca','catalogoganado','tipologia','lote'));
    }

    //Retorna a la vista de transferencia.
    public function vista_reportepajuela(Request $request, $id_finca)
    {
       
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $pajuela = \App\Models\sgpaju::where('id_finca','=',$id_finca)
            ->paginate(10);
        
        //return $pajuela->all();
                
        return view('info.catalogo_de_paju',compact('finca','pajuela'));
    }
   

    //Retorna a la vista de transferencia.
    public function vista_reportehistsalida(Request $request, $id_finca)
    {
       
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $destino = \App\Models\sgfinca::all();
    
        $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get(); 
    
        $historialsalida = \App\Models\sghsal::where('id_finca','=',$id_finca)
            ->paginate(10);
        
        //return $pajuela->all();
                
        return view('info.historial_salida',compact('finca','destino','motivo','historialsalida'));
    }

    public function vista_reportemovimientolote(Request $request, $id_finca)
    {
       
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $movimientolote = \App\Models\sghistlote::where('id_finca','=',$id_finca)
            ->paginate(10);
    
        //return $movimientolote->all();
                
        return view('info.movimiento_lote',compact('finca','movimientolote'));
    }


}
