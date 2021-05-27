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
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;



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

        $colorpelaje = \App\Models\colorescampo::where('id_finca', '=', $finca->id_finca)
        ->get(); 
        $procedencia = \App\Models\sgprocedencia::where('id_finca', '=', $finca->id_finca)
        ->get();
        $procedenciaFinca = \App\Models\sgfinca::all();       

        //return $serietoro->all();
        //Modelo donde a través de un id se ubica la información en otra tabla.
        $seriesrecords = DB::table('sganims')
        ->join('sgtipologias', 'sgtipologias.id_tipologia', '=', 'sganims.id_tipologia')->where('sganims.id_finca','=',$finca->id_finca)
        ->where('sganims.status','=',$status)->paginate(10);

        $lote = \App\Models\sglote::where('id_finca', '=', $finca->id_finca)->get();

        
        return view('ganaderia.fichaganado',compact('finca', 'raza','pajuela', 'tipologia','condicion_corporal','serie','seriesrecords','lote','serie','serietoro','colorpelaje','procedencia','procedenciaFinca'));
    }


    //Filtra la tipologia por sexo
    public function filterSexo(Request $request, $sexo)
    {
        if($request->ajax()){
            $tipologia=\App\Models\sgtipologia::filtrartiposexo($sexo); 
            return response()->json($tipologia);
        }
    }

         //Filtra la tipologia por sexo
    public function filterTipologia(Request $request, $id_tipologia)
    {
        if($request->ajax()){
            $tipologia=\App\Models\sgtipologia::filtrartipologia($id_tipologia); 
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
        $serieNueva->color_pelaje = $request->colorpelaje;
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

        if ($codserie->count()>0) {
                    //recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
            foreach ($codserie as $serieid) {
                $id= (int) $serieid->id;
            }
        } else {
            return back()->with('mensaje','ok'); 
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

            $colorpelaje = \App\Models\colorescampo::where('id_finca', '=', $id_finca)
            ->get();
            
            $procedencia = \App\Models\sgprocedencia::where('id_finca', '=', $finca->id_finca)
            ->get();
            
            $procedenciaFinca = \App\Models\sgfinca::all();           

            $lote = \App\Models\sglote::where('id_finca', '=', $finca->id_finca)->get();
             //return $serieraza->all();
             //Se trae el modelo de pajuela por el id de finca
            
            $pajuela = \App\Models\sgpaju::where('id_finca', '=', $finca->id_finca)->get();

            $serietoro = \App\Models\sganim::where('id_finca', '=', $finca->id_finca)
            ->where('codpadre','<>',Null)
            ->where('id_tipologia','=',18)
            ->where('status','=',1)->get();

            /*
            * Aqui sacaremos el número de Hijos que posee esta serie como vientre
            */
            $mv1 = DB::table('sgmv1s')
            ->where('codmadre','=',$ser)
            ->get();
            #Contamos cuantos hijos posee    
            $nrohijos = $mv1->count();    

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
            $codbisabuelosmaternomadre = \App\Models\sganim::where('serie', '=',$codmadre)
            ->get(); 
        } else {
            $codbisabuelosmaternomadre = \App\Models\sganim::where('serie', '=',"")
            ->get(); 
        } 

           //return $codbisabuelosmaternomadre;

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

        return view('ganaderia.editarfichaganado', 
         compact('serie','tipologia','raza','serieraza',
            'condicion_corporal','seriecondicion','lote','pajuela','serietoro',
            'codabuelopaterno', 'codabuelapaterna','codbisabuelospaternospadre',
            'codbisabuelospaternomadre',
            'codabuelomaterno','codabuelamaterna','codbisabuelosmaternomadre',
            'codbisabuelosmaternospadre','finca','motivoentrada','colorpelaje','procedencia','procedenciaFinca','nrohijos'));
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
        
        $tipoanterior = $serieUpdate->tipo; 

        $serieUpdate->serie = $request->serie;
        $serieUpdate->sexo = $request->sexo;
        $serieUpdate->color_pelaje = $request->colorpelaje;
        $serieUpdate->fnac = $request->fnac;
        
        $serieUpdate->idraza = $request->raza;
        $serieUpdate->id_tipologia = $request->tipologia;
        $serieUpdate->tipo = $tipologia->nombre_tipologia;
        $serieUpdate->tipoanterior = $tipoanterior;
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

    return view('ganaderia.pesoespecifico', compact('serie', 'finca', 'registropeso','dias','graficapeso','graficafecha'));
} 


public function crear_pesoespecifico (Request $request,  $id_finca, $ser)
{
         # Se validan los campos   
    $request->validate([
        'fecha'=>[
            'required',
                    //'unique:sgpesos,fecha,NULL,NULL,id_finca,'.$id_finca,
                    # Va a permitir que no se creen pesos específicos para la misma fecha
        ],
        'peso'=>[
            'required',
        ],
    ]);
         # Obtenemos los datos de la finca con el id_finca   
    $finca = \App\Models\sgfinca::findOrFail($id_finca);

         # A través del código serie se obtiene el id y lo pasamos al modelo
    $codserie = DB::table('sganims')->select('id')->where('serie', '=', $ser)->get();

         # Recorremos el modelo y obtenemos el id este id lo pasamos al modelo de $serie.
    foreach ($codserie as $serieid) {
        $id= (int) $serieid->id;
    }

    $serie = \App\Models\sganim::findOrFail($id);
    
        # validamos la condicion si se trata de un peso de destete
    $request->destatado = ($request->destatado=="on")?($request->destatado=true):($request->destatado=false);

            /*
            * Edad minima y edad maxima
            */
            $edadmin = DB::table('sgtipologias')
            ->select(DB::raw('MIN(edad) as edadminima'))
            ->where('id_finca','=',$id_finca)
            ->get();

            foreach ($edadmin as $key ) {
                $emin = (int) $key->edadminima;    
            }    

            $edadmax = DB::table('sgtipologias')
            ->select(DB::raw('MAX(edad) as edadmax'))
            ->where('id_finca','=',$id_finca)
            ->get();    

            foreach ($edadmax as $key ) {
                $emax = (int) $key->edadmax;    
            }     

            /*
            * Peso minimo y máximo
            */    
            $pesomin = DB::table('sgtipologias')
            ->select(DB::raw('MIN(peso) as pesominimo'))
            ->where('id_finca','=',$id_finca)
            ->get();
            
            foreach ($pesomin as $key ) {
                $pmin = (int) $key->pesominimo;    
            }
            
            $pesomax = DB::table('sgtipologias')
            ->select(DB::raw('MAX(peso) as pesomaximo'))
            ->where('id_finca','=',$id_finca)
            ->get();    

            foreach ($pesomax as $key ) {
                $pmax = (int) $key->pesomaximo;    
            }         
            $edad = Carbon::parse($serie->fnac)->diffInDays($request->fecha);

            $tipoanterior = $serie->tipo; 

            /*
            * Aquí obtenemos el parametro tiempo de secado.
            */
            $pG = \App\Models\sgparametros_ganaderia::where('id_finca', '=', $finca->id_finca)->get();
            
            foreach ($pG as $key) {
                //$tgesta = Tiempo de Gestación (días)
                $pAjust12 = $key->pesoajustado12m;
                $pAjust18 = $key->pesoajustado18m;
                $pAjust24 = $key->pesoajustado24m; 
                $pAjustDestete = $key->pesoajustadoaldestete; 
            }

            if ($request->destatado=="on")  {
            # Si e trata de un peso de destete.
            # Se comprueba que la edad de la serie cumple
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
            * Identificamos que el peso registrado es un peso de destete
            * Para así cambiar la tipologia.
            */
            $pesaje = DB::table('sgpesos')
            ->where('fecha','=',$request->fecha)
            ->where('serie', '=', $serie->serie)
            ->where('id_finca','=',$id_finca)
            ->get();   

                //return $pesaje;

            foreach ($pesaje as $key ) {
                $fechadestete = $key->fecha;
                $peso = $key->peso;
                $dias = $key->dias;
                $destetado= $key->destetado; 
            }  
                /*
                * Buscamo la Tipologia para luego Actualizarla   
                * de forma automática, para efectuar el cambio de la misma.
                * Aqui se hace el destete y se pasa a la tipologia de destete.
                */  
                $buscatipologia = DB::table('sgtipologias')->select('id_tipologia')
                ->where('id_finca','=',$id_finca)
                ->where('destetado','=',$destetado)
                ->where('sexo','=',$serie->sexo)
                ->where('peso','>=',$request->peso)
                ->where('peso','<',$pmax)
                ->get();
                foreach ($buscatipologia as $id_tipo) 
                {
                    $idtipo = (int) $id_tipo->id_tipologia;
                }     


                $tipologia = \App\Models\sgtipologia::findOrFail(4);
                
                $fuedestetado = $destetado;
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
                    'tipoanterior'=> $tipoanterior,
                    'id_tipologia'=> $tipologia->id_tipologia,
                    'nro_monta'=> $tipologia->nro_monta,
                    'prenada'=> $tipologia->prenada,
                    'parida'=> $tipologia->parida,
                    'tienecria'=> $tipologia->tienecria,
                    'criaviva'=> $tipologia->criaviva,
                    'ordenho'=> $tipologia->ordenho,
                    'detectacelo'=> $tipologia->detectacelo]);

                return back()->with('mensaje', 'ok'); 
            } else {
                # Si Es un registro de peso normal
              
                # Si se hace un registro de peso no destete
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

                # Se realiza la actualización de la tabla Sganims.  
                $updatepesoserie = DB::table('sganims')
                ->where('id',$serie->id)
                ->where('id_finca', $finca->id_finca)
                ->update(['pesoactual'=>$request->peso,
                    'fulpes'=>$request->fecha,
                    'ultgdp'=>$request->gdp]);
                return back()->with('msj', 'Registro creado satisfactoriamente');
                
        } //End /.if
    }

    public function eliminar_pesoespecifico($id_finca, $id_peso)
    {
        
        $pesoEspecificoEliminar = \App\Models\sgpeso::findOrFail($id_peso);
        
            #con este valor sabremos si la fecha a eliminar se trata de una 
            #fecha de destete.
        $pesodestete = $pesoEspecificoEliminar->destetado;

            #Obtenemos el Id de la Serie segun el peso a eliminar
        $serie = \App\Models\sganim::findOrFail($pesoEspecificoEliminar->id_serie);

            #Con la Tiplologia anterior buscamos el id y el nombre de la tipología para actualizar
        $tipologia = \App\Models\sgtipologia::where('nombre_tipologia','=',$serie->tipoanterior)->get();

           // dd($pesodestete, $serie); 

        foreach ($tipologia as $key) {
            $idtipoAnte = $key->id_tipologia;
        }   

        try {
            
            $pesoEspecificoEliminar->delete();

            if ($pesodestete==1) {
                   #si es un peso de destete que fue eliminado, actualzamos la tabla sganims 
                   # de la siguiente forma
                $ultimaFechaPeso = DB::table('sgpesos')
                ->select(DB::raw('MAX(fecha) as ultpeso'))
                ->where('serie', '=', $serie->serie)
                ->where('id_finca','=',$id_finca)
                ->get(); 
                /*
                *->| Comprueba el ultimo peso y se actualiza el campo Fecha ultimo pesaje en la tabla sganims.  
                */  
                foreach ($ultimaFechaPeso as $key) {
                    $ultpesaje = $key->ultpeso;
                }
                # Con la Fecha Actualizamos buscamo el peso y actualiamos la tabla sganim
                $uP = DB::table('sgpesos')
                ->where('serie', '=', $serie->serie)
                ->where('id_finca','=',$id_finca)
                ->where('fecha','=',$ultpesaje)
                ->get(); 

                foreach ($uP as $key) {
                    $peso = $key->peso;
                }            
                
                $ultimoPesaje = DB::table('sganims')
                ->where('id','=',$serie->id)
                ->where('id_finca','=', $id_finca)
                ->update(['fulpes'=>$ultpesaje,
                  'pesodestete'=>NULL,
                  'fecdes'=>NULL,
                  'destatado'=>NULL,
                  'pesoactual'=>$peso,
                  'id_tipologia'=>$idtipoAnte,
                  'tipo'=>$serie->tipoanterior]);  

                return back()->with('mensaje', 'dok');                      

            } else {

                $ultimaFechaPeso = DB::table('sgpesos')
                ->select(DB::raw('MAX(fecha) as ultpeso'))
                ->where('serie', '=', $serie->serie)
                ->where('id_finca','=',$id_finca)
                ->get();
                /*
                *->| Comprueba el ultimo peso y se actualiza el campo Fecha ultimo pesaje en la tabla sganims.  
                */  
                foreach ($ultimaFechaPeso as $key) {
                    $ultpesaje = $key->ultpeso;
                }   
                $ultimoPesaje = DB::table('sganims')
                ->where('id','=',$serie->id_serie)
                ->where('id_finca','=', $id_finca)
                ->update(['fulpes'=>$ultpesaje]);
            }
            return back()->with('mensaje', 'dok');  

        }catch (\Illuminate\Database\QueryException $e){
            return back()->with('mensaje', 'error');
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

        return view('ganaderia.lote', compact('lote', 'finca'));
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
        return view('ganaderia.editarlote', compact('lote', 'finca'));
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
      
      return view('ganaderia.sublote', compact('sublote','lote','finca'));
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

return view('ganaderia.detalleserielote', compact('seriesenlote','lote','finca'));
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

return view('ganaderia.detalleseriesublote', compact('seriesensublote','sublote','finca'));
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

return view('ganaderia.asignarseries', compact('asignarseries','lote', 'finca'));

}

public function filterName(Request $request, $id_finca, $nombre_lote)
{
  
    if($request->ajax()){
        $sublote=\App\Models\sgsublote::filtrarlotesublote($id_finca, $nombre_lote); 
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
                return view('ganaderia.pajuela', compact('pajuela','finca','raza','records','especie'));
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
                

                return view('ganaderia.editarpajuela', compact('pajuela','finca','raza','especie'));
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
            
            $idtrans = 4; //Hardcode
            
            $motivo = \App\Models\sgmotivoentradasalida::where('id','=',$idtrans)
                ->get(); //Harcode

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

            return view('ganaderia.transferencia',compact('finca','transferseries','motivo', 'destino','transfrealizada'));
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


    /*
    * Inicio de Salida de Animales
    */

    //Retorna a la vista transferencia
    public function salida(Request $request, $id_finca)
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
    
            $idtrans = 4; //hardcode
            $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')
            ->where('id','<>',$idtrans)
                ->get(); //Harcode
                
                $destino = \App\Models\sgdestinosalida::where('id_finca','=',$id_finca)->get();  

                $fecsalida = Carbon::now()->subDay(1)->format('Y-m-d');

                $salidarealizada = \App\Models\sghsal::whereDate('fechs','=',$fecsalida) 
                ->where('id_finca','=',$id_finca)
                ->get();

                return view('ganaderia.salida_animales',compact('finca','transferseries','motivo', 'destino','salidarealizada'));
            }

            public function salida_series(Request $request, $id_finca)
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
                    'obser'=>[
                        'required',
                    ],
                    'destino'=>[
                        'required',
                    ],    
                ]);
                
        //Aquí ubicamos destino        
                $destino = \App\Models\sgdestinosalida::where('id_finca','=',$id_finca)->get();

        //Corremos el indice para cada serie qe viene en el array[$request]
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){    
                    
            //Obtenemos las series que se van a transferir con su ID
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
            //Obtenemos  el motivo de salida
                    $motivosal = \App\Models\sgmotivoentradasalida::findOrFail($request->motivo);
             /*
             * Se comprueba que la serie existe $seriefincadestino
             * Luego se ubica (n)  la (s) serie (s)
             * Se registran en sghsal
             * Luego seactualizan (update) de los datos de la serie transferida 
             */
             $fecsalida = Carbon::now();
             
             $serieHistoriaSal = new \App\Models\sghsal;

             $serieHistoriaSal->id_serie = $request->id[$i];
             $serieHistoriaSal->serie = $series->serie;
             $serieHistoriaSal->motivo = $motivosal->nombremotivo;
             $serieHistoriaSal->fechs = $request->fecs;
             $serieHistoriaSal->procede = $finca->nombre;
             $serieHistoriaSal->destino = $request->destino;
             $serieHistoriaSal->peso = $series->pesoactual;
             $serieHistoriaSal->feche = $series->fecr;
             $serieHistoriaSal->e_s = 0;
             $serieHistoriaSal->id_motsal = $request->motivo;
             $serieHistoriaSal->obser = $request->obser;
             $serieHistoriaSal->id_finca = $finca->id_finca;

             $serieHistoriaSal-> save();

                //Luego acualizamos el status a inactivo en serie origen
             $updateserie = DB::table('sganims')
             ->where('id',$request->id[$i])
             ->where('id_finca', $finca->id_finca)
             ->update(['status'=>0,'motivo'=>$motivosal->nombremotivo,
                'fecs'=>$fecsalida]);    
         }            
         return back()->with('msj', 'Serie (s) transferida (s) satisfactoriamente');

     }


    //Retorna a la vista de transferencia.
     public function vista_reportes_salida(Request $request, $id_finca)
     {
         
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $destino = \App\Models\sgdestinosalida::all();
        
        $tipologia = \App\Models\sgtipologia::where('id_finca','=',$id_finca)
        ->get();

        $motivo = \App\Models\sgmotivoentradasalida::where('tipo','=','Salida')->get();  
        
        $salidarealizada = \App\Models\sghsal::where('id_finca','=',$id_finca)
        ->paginate(10); 

        
        return view('info.salidas_realizadas',compact('finca','salidarealizada','tipologia','destino','motivo'));
    }

    /*
    * FIN SALIDA DE SERIES
    */

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

    /*
    * Aquí los controller de la vista Cambio de Tipologia
    */

        //Retorna a la vista lote
    public function cambio_tipologia ($id_finca)
    {
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        
        $tipologiaActualMacho = DB::table('sgtipologias')
        ->where('id_finca','=',$id_finca)
        ->where('sexo','=',1)
        ->whereIn('secuencia',[0,1,2])
        ->where('secuencia','<>',null) 
        ->get();
        $tipologiaActualHembra = DB::table('sgtipologias')
        ->where('id_finca','=',$id_finca)
        ->where('sexo','=',0)
        ->whereIn('secuencia',[0,1])
        ->where('secuencia','<>',null) 
        ->get();    

        return view('ganaderia.cambio_tipologia', compact('finca','tipologiaActualMacho','tipologiaActualHembra'));
        //return view('lote');
    }

     //Con esto Agregamos datos en la tabla lote
    public function cambiar_tipo(Request $request, $id_finca)
    {
        
        $tipoActual = DB::table('sgtipologias')
        ->where('id_finca','=',$id_finca)
        ->where('nombre_tipologia','=',$request->tipo_actual)
        ->get();

        foreach ($tipoActual as $key ) {
            # obtenermos el id de la tipologia actual ...
            $idtipoAct = $key->id_tipologia;
        }
        $tipoPropuest = DB::table('sgtipologias')
        ->where('id_finca','=',$id_finca)
        ->where('nombre_tipologia','=',$request->tipopropuesta)
        ->get();
        
        foreach ($tipoPropuest as $key ) {
            # obtenermos el id de la tipologia Propuesta
            $idtipoPropuesta = $key->id_tipologia;
        }        

        #Primer caso Por peso
        if ($request->criterio == 0) {
            # Buscamos la tipo logia actual con el peso actual

            $serieUpdate = DB::table('sganims')
            ->where('id_tipologia',$idtipoAct)
            ->where('id_finca', $id_finca)
            ->where('pesoactual','>=',$request->peso)
            ->update(['id_tipologia'=>$idtipoPropuesta,
                'tipo'=>$request->tipopropuesta,
                'tipoanterior'=>$request->tipo_actual]);
        }

        #Segundo caso Por Edad
        if ($request->criterio == 1) {
            # Buscamos la tipo logia actual con el peso actual

            $serieUpdate = DB::table('sganims')
            ->where('id_tipologia',$idtipoAct)
            ->where('id_finca', $id_finca)
            ->where('edad','=',$request->edad)
            ->update(['id_tipologia'=>$idtipoPropuesta,
                'tipo'=>$request->tipopropuesta,
                'tipoanterior'=>$request->tipo_actual]);
        }

        #Segundo caso Por Peso y Edad
        if ($request->criterio == 2) {
            # Buscamos la tipo logia actual con el peso actual

            $serieUpdate = DB::table('sganims')
            ->where('id_tipologia',$idtipoAct)
            ->where('id_finca', $id_finca)
            ->where('pesoactual','>=',$request->peso)
            ->where('edad','=',$request->edad)
            ->update(['id_tipologia'=>$idtipoPropuesta,
                'tipo'=>$request->tipopropuesta,
                'tipoanterior'=>$request->tipo_actual]);
        }
        
        //return response()->json(['slug' => $loteNuevo->slug]);
        return back()->with('msj', 'Cambio realizado satisfactoriamente');
    }

   //Peso Ajustado
    public function peso_ajustado (Request $request, $id_finca)
    {
     
        //return $request; 
        
        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $pG = \App\Models\sgparametros_ganaderia::all();

        foreach ($pG as $key ) {
            $pGDiasDestete = $key->diasaldestete;
            $pGPesoAjustadoAlDestete = $key->pesoajustadoaldestete;
            $pGPesoAjustado12m = $key->pesoajustado12m;
            $pGPesoAjustado18m = $key->pesoajustado18m;
            $pGPesoAjustado24m = $key->pesoajustado24m;
        }
        
        #1.- Caso Cuando Estan todos los campos Vacios
        if ($request->sexo==null and $request->desde==null and $request->hasta==null) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
            ->take(10)->paginate(10);
        }

        #2.- Caso cuando se filtra solo por sexo        
        if ( !($request->sexo==null) and $request->desde==null and $request->hasta==null) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
            ->where('sexo','=',$request->sexo)
            ->take(10)->paginate(10);
        }  

        #3.- Cuando se filtrar por sexo y fecha inicial de destete
        if ( !($request->sexo==null) and !($request->desde==null) and $request->hasta==null) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
            ->where('sexo','=',$request->sexo)
            ->where('fecdes','>=',$request->desde)
            ->take(10)->paginate(10);
        }  

        #4.- Cuando se filtrar por sexo, fecha inicial y fecha final de destete
        if ( !($request->sexo==null) and !($request->desde==null) and !($request->hasta==null) ) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
            ->where('sexo','=',$request->sexo)
            ->where('fecdes','>=',$request->desde)
            ->where('fecdes','<=',$request->hasta)
            ->take(10)->paginate(10);
        }

        #5.- Cuando se filtrar por fecha inicial y fecha final de destete
        if ( ($request->sexo==null) and !($request->desde==null) and !($request->hasta==null) ) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
               // ->where('sexo','=',$request->sexo)
            ->where('fecdes','>=',$request->desde)
            ->where('fecdes','<=',$request->hasta)
            ->take(10)->paginate(10);
        }

        #6.- Cuando se filtrar por fecha final de destete
        if ( ($request->sexo==null) and ($request->desde==null) and !($request->hasta==null) ) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
               // ->where('sexo','=',$request->sexo)
                //->where('fecdes','>=',$request->desde)
            ->where('fecdes','<=',$request->hasta)
            ->take(10)->paginate(10);
        }

        #7.- #6.- Cuando se filtrar por fecha Inicial de estet
        if ( ($request->sexo==null) and !($request->desde==null) and ($request->hasta==null) ) {
            
            $seriesMaute = DB::table('sganims')
            ->select(DB::raw('DATEDIFF(fecdes,fnac) as diasaldestete, id, serie,sexo ,DATEDIFF(CURDATE(),fnac) as edaddias, tipo, codmadre, codpadre, fecdes, pesodestete'))
            ->whereRaw("DATEDIFF(fecdes,fnac)  >".$pGDiasDestete)
            ->where('id_finca','=',$id_finca)
            ->where('pesoactual','>=', 180)
            ->where('pesoactual','<', 300)
               // ->where('sexo','=',$request->sexo)
                //->where('fecdes','>=',$request->desde)
            ->where('fecdes','>=',$request->desde)
            ->take(10)->paginate(10);
        }               
        
        
        return view('ganaderia.peso_ajustado', compact('finca','seriesMaute'));
        //return view('lote');
    }
    

    public function calcular_peso_ajustado (Request $request, $id_finca)
    {
        //return $request; 

        //Se buscala finca por su id - Segun modelo
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $pG = \App\Models\sgparametros_ganaderia::all();

        foreach ($pG as $key ) {
            $pGDiasDestete = $key->diasaldestete;
            $pGPesoAjustadoAlDestete = $key->pesoajustadoaldestete;
            $pGPesoAjustado12m = $key->pesoajustado12m;
            $pGPesoAjustado18m = $key->pesoajustado18m;
            $pGPesoAjustado24m = $key->pesoajustado24m;
        }

        # 0.-Caso  de Ajuste  ninguno activo

        if (!($request->paj205=="on") and !($request->paj365=="on") and !($request->paj540=="on") and !($request->paj730=="on") ) {
           return back()->with('mensaje', 'info');    
       }

        # 1.-Primer Caso de Ajuste Paj205
       if ( ($request->paj205=="on") and !($request->paj365=="on") and !($request->paj540=="on") and !($request->paj730=="on") ) {
        $request->validate([
            'id'=>[
                'required',
            ],
        ]);
        $cont = count($request->id);
                # Este for es para grabar en la base de datos
        for($i=0; $i < $cont; $i++){

            
            $series = \App\Models\sganim::findOrFail($request->id[$i]);
            
            $fecregistro = Carbon::now();

            $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

            $ajusteNuevo = new \App\Models\sgajust;

            $ajusteNuevo->id_serie = $request->id[$i];
            $ajusteNuevo->serie = $series->serie;
            $ajusteNuevo->sexo = $series->sexo;
            $ajusteNuevo->fecha = $fecregistro;
            $ajusteNuevo->pesdes = $series->pesodestete;
            $ajusteNuevo->peso = $series->pesoactual;
            $ajusteNuevo->difdia = $edad;
            $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
            $ajusteNuevo->pesoi = $series->pesoi;
            $ajusteNuevo->pa1 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

            $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
            $ajusteNuevo->fnac = $series->fnac;
            $ajusteNuevo->idraza = $series->idraza;
            $ajusteNuevo->lote = $series->nombrelote;
            
            $ajusteNuevo->id_finca = $id_finca;

            $ajusteNuevo-> save(); 
        }

                #Este for es para Calcular los promedios y actualizar los resultados
        for($i=0; $i < $cont; $i++){
            $paj205Prom = DB::table('sgajusts')
            ->select(DB::raw('AVG(pa1) as prompaj205'))
            ->where('id_finca','=',$id_finca)
            ->whereDate('fecha','=',$fecregistro)
            ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
            foreach ($paj205Prom as $key ) {
                $prom205 = $key->prompaj205;       
            } 

                    #Obtenemos el peso Ajustado individual 
            $ajustSerie = DB::table('sgajusts')
            ->where('id_finca','=',$id_finca)
            ->where('id_serie','=',$request->id[$i])
            ->get();

            foreach ($ajustSerie as $key ) {
                $pa1 = $key->pa1;
            }    
                    #Calculamos el Promedio
            $indice = ($pa1/$prom205)*100;  


                    #Actualizamos la tabla sgajusts con e indice para cada id serie
            $ajustSerie = DB::table('sgajusts')
            ->where('id_finca','=',$id_finca)
            ->where('id_serie','=',$request->id[$i])
            ->update(['c1'=>$indice]);
            $rpa1 =((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;    
            $pajserie = DB::table('sganims')
            ->where('id',$request->id[$i])
            ->where('id_finca', $finca->id_finca)
            ->update(['pa1'=>$rpa1]);       
        }
    }

        # 2.- Segundo caso de Ajuste paj365
    if ( !($request->paj205=="on") and ($request->paj365=="on") and !($request->paj540=="on") and !($request->paj730=="on") ) {
      
      $cont = count($request->id);
      for($i=0; $i < $cont; $i++){

        
        $series = \App\Models\sganim::findOrFail($request->id[$i]);
        
        $fecregistro = Carbon::now();

        $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

        $ajusteNuevo = new \App\Models\sgajust;

        $ajusteNuevo->id_serie = $request->id[$i];
        $ajusteNuevo->serie = $series->serie;
        $ajusteNuevo->sexo = $series->sexo;
        $ajusteNuevo->fecha = $fecregistro;
        $ajusteNuevo->pesdes = $series->pesodestete;
        $ajusteNuevo->peso = $series->pesoactual;
        $ajusteNuevo->difdia = $edad;
        $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
        $ajusteNuevo->pesoi = $series->pesoi;
        $ajusteNuevo->pa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

        $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
        $ajusteNuevo->fnac = $series->fnac;
        $ajusteNuevo->idraza = $series->idraza;
        $ajusteNuevo->lote = $series->nombrelote;
        
        $ajusteNuevo->id_finca = $id_finca;

        $ajusteNuevo-> save(); 

    }

    for($i=0; $i < $cont; $i++){
     $paj365Prom = DB::table('sgajusts')
     ->select(DB::raw('AVG(pa2) as prompaj365'))
     ->where('id_finca','=',$id_finca)
     ->whereDate('fecha','=',$fecregistro)
     ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
     foreach ($paj365Prom as $key ) {
        $prom365 = $key->prompaj365;       
    }  

                    #Obtenemos el peso Ajustado individual 
    $ajustSerie = DB::table('sgajusts')
    ->where('id_finca','=',$id_finca)
    ->where('id_serie','=',$request->id[$i])
    ->get();

    foreach ($ajustSerie as $key ) {
        $pa2 = $key->pa2;
    }    
                    #Calculamos el Promedio
    $indice = ($pa2/$prom365)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
    $ajustSerie = DB::table('sgajusts')
    ->where('id_finca','=',$id_finca)
    ->where('id_serie','=',$request->id[$i])
    ->update(['c2'=>$indice]);

    $rpa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;   
    $pajserie = DB::table('sganims')
    ->where('id',$request->id[$i])
    ->where('id_finca', $finca->id_finca)
    ->update(['pa2'=>$rpa2]);    

}
}

        # 3.- Caso de Ajuste de Peso Paj540
if (!($request->paj205=="on") and !($request->paj365=="on") and ($request->paj540=="on") and !($request->paj730=="on")) {
 $cont = count($request->id);
 for($i=0; $i < $cont; $i++){

    
    $series = \App\Models\sganim::findOrFail($request->id[$i]);
    
    $fecregistro = Carbon::now();

    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

    $ajusteNuevo = new \App\Models\sgajust;

    $ajusteNuevo->id_serie = $request->id[$i];
    $ajusteNuevo->serie = $series->serie;
    $ajusteNuevo->sexo = $series->sexo;
    $ajusteNuevo->fecha = $fecregistro;
    $ajusteNuevo->pesdes = $series->pesodestete;
    $ajusteNuevo->peso = $series->pesoactual;
    $ajusteNuevo->difdia = $edad;
    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
    $ajusteNuevo->pesoi = $series->pesoi;
    $ajusteNuevo->pa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
    $ajusteNuevo->fnac = $series->fnac;
    $ajusteNuevo->idraza = $series->idraza;
    $ajusteNuevo->lote = $series->nombrelote;
    
    $ajusteNuevo->id_finca = $id_finca;

    $ajusteNuevo-> save(); 

}  
for($i=0; $i < $cont; $i++){
  $paj540Prom = DB::table('sgajusts')
  ->select(DB::raw('AVG(pa3) as prompaj540'))
  ->where('id_finca','=',$id_finca)
  ->whereDate('fecha','=',$fecregistro)
  ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
  foreach ($paj540Prom as $key ) {
    $prom540 = $key->prompaj540;       
}  

                    #Obtenemos el peso Ajustado individual 
$ajustSerie = DB::table('sgajusts')
->where('id_finca','=',$id_finca)
->where('id_serie','=',$request->id[$i])
->get();

foreach ($ajustSerie as $key ) {
    $pa3 = $key->pa3;
}    
                    #Calculamos el Promedio
$indice = ($pa3/$prom540)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
$ajustSerie = DB::table('sgajusts')
->where('id_finca','=',$id_finca)
->where('id_serie','=',$request->id[$i])
->update(['c3'=>$indice]);
$rpa3 =((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;    
$pajserie = DB::table('sganims')
->where('id',$request->id[$i])
->where('id_finca', $finca->id_finca)
->update(['pa3'=>$rpa3]);      
} 
}

        # 4.- Caso de Ajuste de Peso Paj730
if (!($request->paj205=="on") and !($request->paj365=="on") and !($request->paj540=="on") and ($request->paj730=="on")) {
 $cont = count($request->id);
 for($i=0; $i < $cont; $i++){

    
    $series = \App\Models\sganim::findOrFail($request->id[$i]);
    
    $fecregistro = Carbon::now();

    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

    $ajusteNuevo = new \App\Models\sgajust;

    $ajusteNuevo->id_serie = $request->id[$i];
    $ajusteNuevo->serie = $series->serie;
    $ajusteNuevo->sexo = $series->sexo;
    $ajusteNuevo->fecha = $fecregistro;
    $ajusteNuevo->pesdes = $series->pesodestete;
    $ajusteNuevo->peso = $series->pesoactual;
    $ajusteNuevo->difdia = $edad;
    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
    $ajusteNuevo->pesoi = $series->pesoi;
    $ajusteNuevo->pa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
    $ajusteNuevo->fnac = $series->fnac;
    $ajusteNuevo->idraza = $series->idraza;
    $ajusteNuevo->lote = $series->nombrelote;
    
    $ajusteNuevo->id_finca = $id_finca;

    $ajusteNuevo-> save(); 
}

for($i=0; $i < $cont; $i++){   
    $paj730Prom = DB::table('sgajusts')
    ->select(DB::raw('AVG(pa4) as prompaj730'))
    ->where('id_finca','=',$id_finca)
    ->whereDate('fecha','=',$fecregistro)
    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
    foreach ($paj730Prom as $key ) {
        $prom730 = $key->prompaj730;       
    }  

                    #Obtenemos el peso Ajustado individual 
    $ajustSerie = DB::table('sgajusts')
    ->where('id_finca','=',$id_finca)
    ->where('id_serie','=',$request->id[$i])
    ->get();

    foreach ($ajustSerie as $key ) {
        $pa4 = $key->pa4;
    }    
                    #Calculamos el Promedio
    $indice = ($pa4/$prom730)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
    $ajustSerie = DB::table('sgajusts')
    ->where('id_finca','=',$id_finca)
    ->where('id_serie','=',$request->id[$i])
    ->update(['c4'=>$indice]);
    $rpa4 =((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;    
    $pajserie = DB::table('sganims')
    ->where('id',$request->id[$i])
    ->where('id_finca', $finca->id_finca)
    ->update(['pa4'=>$rpa4]);        

}
}

        # 5.- Quinto Caso de Ajuste de Peso Paj205 y Paj365
if (($request->paj205=="on") and ($request->paj365=="on") and !($request->paj540=="on") and !($request->paj730=="on")) {
  
  $cont = count($request->id);
  for($i=0; $i < $cont; $i++){

    
    $series = \App\Models\sganim::findOrFail($request->id[$i]);
    
    $fecregistro = Carbon::now();

    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

    $ajusteNuevo = new \App\Models\sgajust;

    $ajusteNuevo->id_serie = $request->id[$i];
    $ajusteNuevo->serie = $series->serie;
    $ajusteNuevo->sexo = $series->sexo;
    $ajusteNuevo->fecha = $fecregistro;
    $ajusteNuevo->pesdes = $series->pesodestete;
    $ajusteNuevo->peso = $series->pesoactual;
    $ajusteNuevo->difdia = $edad;
    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
    $ajusteNuevo->pesoi = $series->pesoi;
    $ajusteNuevo->pa1 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;
    $ajusteNuevo->pa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
    $ajusteNuevo->fnac = $series->fnac;
    $ajusteNuevo->idraza = $series->idraza;
    $ajusteNuevo->lote = $series->nombrelote;
    
    $ajusteNuevo->id_finca = $id_finca;

    $ajusteNuevo-> save(); 
    
}

for($i=0; $i < $cont; $i++){ 
                /*
                    * Promedios 205
                    */
                $paj205Prom = DB::table('sgajusts')
                ->select(DB::raw('AVG(pa1) as prompaj205'))
                ->where('id_finca','=',$id_finca)
                ->whereDate('fecha','=',$fecregistro)
                ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                foreach ($paj205Prom as $key ) {
                    $prom205 = $key->prompaj205;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa1 = $key->pa1;
                }    
                    #Calculamos el Promedio
                $indice = ($pa1/$prom205)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c1'=>$indice]);


                    /*
                    * Promedios de 365
                    */
                    $paj365Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa2) as prompaj365'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj365Prom as $key ) {
                        $prom365 = $key->prompaj365;       
                    }  

                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa2 = $key->pa2;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa2/$prom365)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c2'=>$indice]);

                    $rpa1= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;
                    $rpa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa1'=>$rpa1,
                      'pa2'=>$rpa2]);

                }

            #      
            }

        # 6.- Caso de Ajuste de Peso Paj205 y Paj540
            if (($request->paj205=="on") and !($request->paj365=="on") and ($request->paj540=="on") and !($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa1 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $ajusteNuevo->pa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save(); 
                    
                }

                for($i=0; $i < $cont; $i++){
                  /*
                    * Promedios 205
                    */
                  $paj205Prom = DB::table('sgajusts')
                  ->select(DB::raw('AVG(pa1) as prompaj205'))
                  ->where('id_finca','=',$id_finca)
                  ->whereDate('fecha','=',$fecregistro)
                  ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                  foreach ($paj205Prom as $key ) {
                    $prom205 = $key->prompaj205;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa1 = $key->pa1;
                }    
                    #Calculamos el Promedio
                $indice = ($pa1/$prom205)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c1'=>$indice]);
                    /*
                    * Promedios de 540
                    */
                    $paj540Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa3) as prompaj540'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj540Prom as $key ) {
                        $prom540 = $key->prompaj540;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa3 = $key->pa3;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa3/$prom540)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c3'=>$indice]);

                    $rpa1= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $rpa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa1'=>$rpa1,
                      'pa3'=>$rpa3]);    
                }

            #      
            }

        # 7.- Caso de Ajuste de Peso Paj205 y Paj730
            if (($request->paj205=="on") and !($request->paj365=="on") and !($request->paj540=="on") and ($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa1 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $ajusteNuevo->pa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save(); 
                }

                for($i=0; $i < $cont; $i++){
                  /*
                    * Promedios 205
                    */
                  $paj205Prom = DB::table('sgajusts')
                  ->select(DB::raw('AVG(pa1) as prompaj205'))
                  ->where('id_finca','=',$id_finca)
                  ->whereDate('fecha','=',$fecregistro)
                  ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                  foreach ($paj205Prom as $key ) {
                    $prom205 = $key->prompaj205;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa1 = $key->pa1;
                }    
                    #Calculamos el Promedio
                $indice = ($pa1/$prom205)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c1'=>$indice]);
                    /*
                    * Promedios de 730
                    */
                    $paj730Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa4) as prompaj730'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj730Prom as $key ) {
                        $prom730 = $key->prompaj730;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa4 = $key->pa4;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa4/$prom730)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c4'=>$indice]);

                    $rpa1= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $rpa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa1'=>$rpa1,
                      'pa4'=>$rpa4]);   
                }

            #      
            }

        # 8.- Caso de Ajuste de Peso Paj365 y Paj540
            if (!($request->paj205=="on") and ($request->paj365=="on") and ($request->paj540=="on") and !($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $ajusteNuevo->pa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save(); 

                    
                }
                
                for($i=0; $i < $cont; $i++){
                /*
                    * Promedios 205
                    */
                $paj365Prom = DB::table('sgajusts')
                ->select(DB::raw('AVG(pa2) as prompaj365'))
                ->where('id_finca','=',$id_finca)
                ->whereDate('fecha','=',$fecregistro)
                ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                foreach ($paj365Prom as $key ) {
                    $prom365 = $key->prompaj365;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa2 = $key->pa2;
                }    
                    #Calculamos el Promedio
                $indice = ($pa2/$prom365)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c2'=>$indice]);
                    /*
                    * Promedios de 730
                    */
                    $paj540Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa3) as prompaj540'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj540Prom as $key ) {
                        $prom540 = $key->prompaj540;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa3 = $key->pa3;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa3/$prom540)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c3'=>$indice]);

                    $rpa2= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $rpa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa2'=>$rpa2,
                      'pa3'=>$rpa3]);       
                }

            #      
            }

        # 9.- Caso de Ajuste de Peso Paj365 y Paj730
            if (!($request->paj205=="on") and ($request->paj365=="on") and !($request->paj540=="on") and ($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $ajusteNuevo->pa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save();    
                }

                for($i=0; $i < $cont; $i++){
                    /*
                    * Promedios 365
                    */
                    $paj365Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa2) as prompaj365'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj365Prom as $key ) {
                        $prom365 = $key->prompaj365;       
                    }  

                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa2 = $key->pa2;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa2/$prom365)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c2'=>$indice]);
                    /*
                    * Promedios de 730
                    */
                    $paj730Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa4) as prompaj730'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj730Prom as $key ) {
                        $prom730 = $key->prompaj730;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa4 = $key->pa4;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa4/$prom730)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c4'=>$indice]);

                    $rpa2= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $rpa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa2'=>$rpa2,
                      'pa4'=>$rpa4]); 
                }

            #      
            }

        # 10.- Caso de Ajuste de Peso Paj540 y Paj730
            if (!($request->paj205=="on") and !($request->paj365=="on") and ($request->paj540=="on") and ($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $ajusteNuevo->pa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save();   
                }

                for($i=0; $i < $cont; $i++){ 
                 /*
                    * Promedios 540
                    */
                 $paj540Prom = DB::table('sgajusts')
                 ->select(DB::raw('AVG(pa3) as prompaj540'))
                 ->where('id_finca','=',$id_finca)
                 ->whereDate('fecha','=',$fecregistro)
                 ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                 foreach ($paj540Prom as $key ) {
                    $prom540 = $key->prompaj540;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa3 = $key->pa3;
                }    
                    #Calculamos el Promedio
                $indice = ($pa3/$prom540)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c3'=>$indice]);
                    /*
                    * Promedios de 730
                    */
                    $paj730Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa4) as prompaj730'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj730Prom as $key ) {
                        $prom730 = $key->prompaj730;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa4 = $key->pa4;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa4/$prom730)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c4'=>$indice]);

                    $rpa3= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $rpa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa3'=>$rpa3,
                      'pa4'=>$rpa4]);      
                }

            #      
            }

        # 11.- Caso de Ajuste de Peso Paj205, Paj365, Paj540 y Paj730
            if (($request->paj205=="on") and ($request->paj365=="on") and ($request->paj540=="on") and ($request->paj730=="on")) {
              
                $cont = count($request->id);
                for($i=0; $i < $cont; $i++){
                   
                    $series = \App\Models\sganim::findOrFail($request->id[$i]);
                    
                    $fecregistro = Carbon::now();

                    $edad =  Carbon::parse($series->fnac)->diffInDays($series->fecdes);

                    $ajusteNuevo = new \App\Models\sgajust;

                    $ajusteNuevo->id_serie = $request->id[$i];
                    $ajusteNuevo->serie = $series->serie;
                    $ajusteNuevo->sexo = $series->sexo;
                    $ajusteNuevo->fecha = $fecregistro;
                    $ajusteNuevo->pesdes = $series->pesodestete;
                    $ajusteNuevo->peso = $series->pesoactual;
                    $ajusteNuevo->difdia = $edad;
                    $ajusteNuevo->difpeso = $series->pesoactual - $series->pesoi;
                    $ajusteNuevo->pesoi = $series->pesoi;

                    $ajusteNuevo->pa1 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $ajusteNuevo->pa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;

                    $ajusteNuevo->pa3 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $ajusteNuevo->pa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $ajusteNuevo->gdp = ($series->pesodestete - $series->pesoi) / $edad;
                    $ajusteNuevo->fnac = $series->fnac;
                    $ajusteNuevo->idraza = $series->idraza;
                    $ajusteNuevo->lote = $series->nombrelote;
                    
                    $ajusteNuevo->id_finca = $id_finca;

                    $ajusteNuevo-> save(); 
                }

                for($i=0; $i < $cont; $i++){
                 /*
                    * Promedios 205
                    */
                 $paj205Prom = DB::table('sgajusts')
                 ->select(DB::raw('AVG(pa1) as prompaj205'))
                 ->where('id_finca','=',$id_finca)
                 ->whereDate('fecha','=',$fecregistro)
                 ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                 foreach ($paj205Prom as $key ) {
                    $prom205 = $key->prompaj205;       
                }  

                    #Obtenemos el peso Ajustado individual 
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                foreach ($ajustSerie as $key ) {
                    $pa1 = $key->pa1;
                }    
                    #Calculamos el Promedio
                $indice = ($pa1/$prom205)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                $ajustSerie = DB::table('sgajusts')
                ->where('id_finca','=',$id_finca)
                ->where('id_serie','=',$request->id[$i])
                ->update(['c1'=>$indice]);
                    /*
                    * Promedios de 365
                    */
                    $paj365Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa2) as prompaj365'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj365Prom as $key ) {
                        $prom365 = $key->prompaj365;       
                    }  

                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa2 = $key->pa2;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa2/$prom365)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c2'=>$indice]);
                    /*
                    * Promedios 540
                    */
                    $paj540Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa3) as prompaj540'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj540Prom as $key ) {
                        $prom540 = $key->prompaj540;       
                    }  

                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa3 = $key->pa3;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa3/$prom540)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c3'=>$indice]);
                    /*
                    * Promedios de 730
                    */
                    $paj730Prom = DB::table('sgajusts')
                    ->select(DB::raw('AVG(pa4) as prompaj730'))
                    ->where('id_finca','=',$id_finca)
                    ->whereDate('fecha','=',$fecregistro)
                    ->get();
                    #Obtenemos el promedio del peso ajustado para poder calcular el indice    
                    foreach ($paj730Prom as $key ) {
                        $prom730 = $key->prompaj730;       
                    }  
                    #Obtenemos el peso Ajustado individual 
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->get();

                    foreach ($ajustSerie as $key ) {
                        $pa4 = $key->pa4;
                    }    
                    #Calculamos el Promedio
                    $indice = ($pa4/$prom730)*100;    

                    #Actualizamos la tabla sgajusts con e indice para cada id serie
                    $ajustSerie = DB::table('sgajusts')
                    ->where('id_finca','=',$id_finca)
                    ->where('id_serie','=',$request->id[$i])
                    ->update(['c4'=>$indice]);

                    $rpa1= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustadoAlDestete ) + $series->pesoi;

                    $rpa2 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado12m ) + $series->pesoi;
                    
                    $rpa3= ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado18m ) + $series->pesoi;

                    $rpa4 = ((($series->pesodestete - $series->pesoi) / $edad) *$pGPesoAjustado24m ) + $series->pesoi;

                    $pajserie = DB::table('sganims')
                    ->where('id',$request->id[$i])
                    ->where('id_finca', $finca->id_finca)
                    ->update(['pa1'=>$rpa1,
                      'pa2'=>$rpa2,
                      'pa3'=>$rpa3,
                      'pa4'=>$rpa4]);   
                    
                }

            #      
            }
            
            return back()->with('msj', 'Ajuste de Peso realizado satisfactoriamente');
            
        }

        public function detalle_ajustepeso ($id_finca)
        {

            $fecha= Carbon::now();

            $ajust = DB::table('sgajusts')
            ->where('id_finca','=',$id_finca)
            ->whereDate('fecha','=',$fecha)
            ->get(); 

            $promPesoDestete = round(collect($ajust)->avg('pesdes'),2);            

            $promPa1 = round(collect($ajust)->avg('pa1'),2);

            $promPa2 = round(collect($ajust)->avg('pa2'),2);
            $promPa3 = round(collect($ajust)->avg('pa3'),2);
            $promPa4 = round(collect($ajust)->avg('pa4'),2);            
            
            
            return view('ganaderia.pesoajustado_results', compact('finca','ajust','promPesoDestete','promPa1','promPa2','promPa3','promPa4'));

        }



    #Retorna a la vista de reortes peso ajustados
        public function vista_reportespesoajustado(Request $request, $id_finca)
        {
         
        //return $request; 
            $finca = \App\Models\sgfinca::findOrFail($id_finca);


            
        #0. En caso Desde inactivo y Hasta Ianctivo
            if ( ($request->desde == null) and ($request->hasta==null) ) {
             
             $pesAjusReal = \App\Models\sgajust::where('sgajusts.id_finca','=',$id_finca)
             ->select('sgajusts.id','sgajusts.fecha','sgajusts.id_serie','sgajusts.serie','sgajusts.sexo','sgajusts.pesdes', 'sgajusts.peso', 'sgajusts.difdia', 'sgajusts.difpeso', 'sgajusts.pesoi','sgajusts.pa1','sgajusts.c1','sgajusts.gdp','sgajusts.idraza','sgajusts.fnac','sgajusts.lote','sgajusts.id_finca','sganims.codmadre','sganims.fecdes','sganims.tipo','sganims.edad' )

             ->join('sganims','sganims.id','=','sgajusts.id_serie')
             ->take(7)->paginate(7);
            //return $pesAjusReal;    
         }

        #1.- Caso Desde activo Hasta Inactivo
         if ( !($request->desde == null) and ($request->hasta==null) ) {
             
             $pesAjusReal = \App\Models\sgajust::where('sgajusts.id_finca','=',$id_finca)
             ->select('sgajusts.id','sgajusts.fecha','sgajusts.id_serie','sgajusts.serie','sgajusts.sexo','sgajusts.pesdes', 'sgajusts.peso', 'sgajusts.difdia', 'sgajusts.difpeso', 'sgajusts.pesoi','sgajusts.pa1','sgajusts.c1','sgajusts.gdp','sgajusts.idraza','sgajusts.fnac','sgajusts.lote','sgajusts.id_finca','sganims.codmadre','sganims.fecdes','sganims.tipo','sganims.edad' )

             ->join('sganims','sganims.id','=','sgajusts.id_serie')
             ->whereDate('fecha','>=',$request->desde)
             ->take(7)->paginate(7);

         }

        #2.- Caso Desde inactivo Hasta Activo

         if ( ($request->desde == null) and !($request->hasta==null) ) {
             
             $pesAjusReal = \App\Models\sgajust::where('sgajusts.id_finca','=',$id_finca)
             ->select('sgajusts.id','sgajusts.fecha','sgajusts.id_serie','sgajusts.serie','sgajusts.sexo','sgajusts.pesdes', 'sgajusts.peso', 'sgajusts.difdia', 'sgajusts.difpeso', 'sgajusts.pesoi','sgajusts.pa1','sgajusts.c1','sgajusts.gdp','sgajusts.idraza','sgajusts.fnac','sgajusts.lote','sgajusts.id_finca','sganims.codmadre','sganims.fecdes','sganims.tipo','sganims.edad')
             ->join('sganims','sganims.id','=','sgajusts.id_serie')
             ->whereDate('fecha','<=',$request->hasta)
             ->take(7)->paginate(7);
         }

        #3.- Caso Desde Activo y Hasta Activo

         if ( !($request->desde == null) and !($request->hasta==null) ) {
             
             $pesAjusReal = \App\Models\sgajust::where('sgajusts.id_finca','=',$id_finca)
             ->select('sgajusts.id','sgajusts.fecha','sgajusts.id_serie','sgajusts.serie','sgajusts.sexo','sgajusts.pesdes', 'sgajusts.peso', 'sgajusts.difdia', 'sgajusts.difpeso', 'sgajusts.pesoi','sgajusts.pa1','sgajusts.c1','sgajusts.gdp','sgajusts.idraza','sgajusts.fnac','sgajusts.lote','sgajusts.id_finca','sganims.codmadre','sganims.fecdes','sganims.tipo','sganims.edad')
             ->join('sganims','sganims.id','=','sgajusts.id_serie')
             ->whereDate('fecha','>=',$request->desde)
             ->whereDate('fecha','<=',$request->hasta)
             ->take(7)->paginate(7);
         }

       // return $pesAjusReal;  

         return view('info.pesosajustados_realizados',compact('finca','pesAjusReal'));
     }

    /*
    * Trabajo de Campo en 
    */
    public function tc_inventario(Request $request, $id_finca)
    {
        //return $request; 
        $finca = \App\Models\sgfinca::findOrFail($id_finca); 

        if (($request->tc == null) or empty($request->tc)) {
            # Si tc es nulo que muestre todo
            $trabajoCampo = DB::table('trabajocampos')
            ->where('id_finca','=',$id_finca)
            ->paginate(5);
        } else {
            
            $trabajoCampo = DB::table('trabajocampos')
            ->where('id_finca','=',$id_finca)
            ->where('nombre','like',"%".$request->tc."%")
            ->take(3)->paginate(5);
        }
        # 0. debemos comprobar si existe

        # 1.- Si existe comprobar que tenga registros para evitar division por cero

        # 2.- Si existe mostrar sino dejar vacio.

        return view('trabajocampo.vista_principal_inventario', compact('finca','trabajoCampo'));
    }

    public function crear_tc(Request $request, $id_finca)
    {
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca); 

        $request->validate([
            'nombre'=>[
                'required',
            ],
            'fi'=>[
                'required',
            ],
            'ff'=>[
                'required',
            ],
        ]);

        #Aqui Guardamos los datos del trabajo de campo

        $trabajoCampoNuevo = new \App\Models\trabajocampo;

        $trabajoCampoNuevo->nombre = $request->nombre;
        $trabajoCampoNuevo->fi = $request->fi;
        $trabajoCampoNuevo->ff = $request->ff;

        $trabajoCampoNuevo->id_finca = $id_finca;

        $trabajoCampoNuevo->save();


        return back()->with('msj', 'Registro realizado satisfactoriamente');
    }

    public function detalle_tc(Request $request, $id_finca, $id_tc)
    {
        
        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $tc = \App\Models\trabajocampo::findOrFail($id_tc);
        
        $tipologia = DB::table('sgtipologias')
        ->where('id_finca','=',$id_finca)
        ->get();

        $diagnostic = DB::table('sgdiagnosticpalpaciones')
        ->where('id_finca','=',$id_finca)
        ->get();    
        
        $patologias =DB::table('sgpatologias')
        ->where('id_finca','=',$id_finca)
        ->get();    

        #Se filtran las series segun        
        if (($request->tipo==null) and ($request->serie==null)){ 
            $series = DB::table('sganims')
            ->where('id_finca','=',$id_finca)
            ->take(7)->paginate(7);
        } 

        if (!($request->tipo==null) and ($request->serie==null)){
            $series = DB::table('sganims')
            ->where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)
            ->take(7)->paginate(7);
        }

        if (($request->tipo==null) and !($request->serie==null)){
            $series = DB::table('sganims')
            ->where('id_finca','=',$id_finca)
            ->where('serie','like',$request->serie."%")
            ->take(7)->paginate(7);
        }

        if (!($request->tipo==null) and !($request->serie==null)){
            $series = DB::table('sganims')
            ->where('id_finca','=',$id_finca)
            ->where('id_tipologia','=',$request->tipo)
            ->where('serie','like',$request->serie."%")
            ->take(7)->paginate(7);
        }

        $tcdetalle = DB::table('detalle_trabajo_campos')
        ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
        ->where('detalle_trabajo_campos.id_tc','=', $id_tc)
        ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
        ->paginate(7);

        return view('trabajocampo.detalle_trabajocampo', compact('finca', 'tipologia','series','diagnostic','patologias','tc','tcdetalle'));
    }

    public function guardar_tc(Request $request, $id_finca, $id_tc)
    {
        
        if ($request->id==null) {
            return back()->with('msjinfo','ok');
        } else {
            #Si no es nulo que lo active el contador con la cantidad de registros
            $cont = count($request->id);
            #recorremos el Array
            for($i=0; $i < $cont; $i++){

            #Comprobamos que exista el serial    
                $serieDtc = DB::table('detalle_trabajo_campos')
                ->where('id_finca','=',$id_finca)
                ->where('id_tc','=',$id_tc)
                ->where('id_serie','=',$request->id[$i])
                ->get();

                if ($serieDtc->count()>0) {
                    #Si existe que no lo guarde
                   return back()->with('mesaj', 'Registro Seleccionado ya existe');
               } else {
                    #Si no existe que lo guarde
                $series = \App\Models\sganim::findOrFail($request->id[$i]);
                
                $detalleTrabajoNuevo = new \App\Models\detalle_trabajo_campo;

                $detalleTrabajoNuevo->id_serie = $request->id[$i];
                $detalleTrabajoNuevo->serie = $series->serie;
                $detalleTrabajoNuevo->sexo = $series->sexo;
                $detalleTrabajoNuevo->observacion = $request->observacion[$i];
                $detalleTrabajoNuevo->paso = $request->paso[$i];
                $detalleTrabajoNuevo->diagnostico = $request->diagnostico[$i];
                $detalleTrabajoNuevo->evaluacion = $request->patologia[$i];
                    $detalleTrabajoNuevo->caso = $series->tipo; //Manejamos la Tipologia

                    $detalleTrabajoNuevo->id_finca = $id_finca;
                    $detalleTrabajoNuevo->id_tc = $id_tc;

                    $detalleTrabajoNuevo->save();

                    $observa = $request->observacion[$i];
                    #Actualizamos la tabla sganims el campo de observacion 
                    $updateSerie = DB::table ('sganims')
                    ->where('id','=',$request->id[$i])
                    ->where('id_finca','=',$id_finca)
                    ->update(['observa'=>$observa]); 
                }
            }
            
            return back()->with('msj', 'Registro realizado satisfactoriamente');    
        }
    }  

    public function tc_comparar(Request $request, $id_finca)
    {
        
        $fechadereporte = Carbon::now();

        $finca = \App\Models\sgfinca::findOrFail($id_finca);

        $tc = \App\Models\trabajocampo::where('id_finca','=',$id_finca)
        ->get();

        #0.- Si los Select estan en null o vacío que no muestre nada        
        if (($request->tca==null) or empty($request->tca) or ($request->tcb==null) or empty($request->tcb) ) {
             # Paso para que se carguen los select
          
            $tcABarray = [$request->tca, $request->tcb]; 

            $tcA = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('id_tc','=',$request->tca)
            ->get();
            
            $tcB = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('id_tc','=',$request->tcb)
            ->get();
            
            #Con este Modelo Obtenemos los que no pasó en A ni en B
            $tcABNoPaso = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',0)
            ->whereIn('id_tc',$tcABarray)
                //->where('id_tc','=',$request->tca)
                //->where('id_tc','=',$request->tcb)
            ->distinct()->get();
            
            #Con este Modelo Obtenemos los que pasaron en A ni en B
            $tcABPaso = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',1)
            ->whereIn('id_tc',$tcABarray)
                //->where('id_tc','=',$request->tca)
                //->where('id_tc','=',$request->tcb)
            ->distinct()->get(); 

            #Modelo 1 Todos los que pasan en A        
            $modelo1 = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',1)
            ->where('id_tc','=',$request->tca)
            ->get();

            #Almacenams en un Array todos las series
            foreach ($modelo1 as $key ) {
                $arrayIdSerie [] = $key->serie;  
            }

            $arrayIdSerie = [0]; 

            #Modelo A Todos los que no pasaron en A        
            $modeloA = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',0)
            ->where('id_tc','=',$request->tca)
            ->get();

            #Almacenams en un Array todos las series
            foreach ($modeloA as $key ) {
                $arrayIdSerieNp [] = $key->serie;  
            }    

            $arrayIdSerieNp = [0]; 

            #Modelo 2 Animales que pasaron en A y en B.
            $modelo2 = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',1)
            ->where('id_tc','=',$request->tcb)
            ->whereIn('serie',$arrayIdSerie)
            ->get();

            $contm2 = $modelo2->count();

            #Modelo 3 Animales que Pasaron en A y no B 
            $modelo3 = DB::table('detalle_trabajo_campos')
            ->where('id_finca','=',$id_finca)
            ->where('paso','=',0)
            ->where('id_tc','=',$request->tcb)
            ->whereIn('serie',$arrayIdSerie)
            ->get();

            $contm3 = $modelo3->count();                   
            
            #Los contadores los colocamos a 0 para que las variables no den error. 
            $contA = 0;
            $contB = 0;
            $contABNp = 0;
            $contABp = 0;
            $contm2 = 0; 
            $contm3 = 0; 

            $tcANombre=null; 
            $tcBNombre=null;

            $tcABarray =[0];
            $vartca=0;
            $vartcb= 0;
            $arregloSNp =[0];
            $arregloPAnB =[0];

        } else {


            if ($request->tca == $request->tcb) {
                return back()->with('mensaje','equal');
            } else {
                $tcABarray = [$request->tca, $request->tcb];    
                
                $vartca = $request->tca;
                $vartcb = $request->tcb;

                $tcA = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.id_tc','=',$request->tca)
                ->get();

                $contA = $tcA->count(); 

                foreach ($tcA as $key) {
                    $idtcA = $key->id_tc; 
                }
            #Con el Id_tc buscamo enl nombre del trabajo de campo.
                $tcAname = \App\Models\trabajocampo::findOrFail($idtcA);

                $tcB = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.id_tc','=',$request->tcb)
                ->get();     

                $contB = $tcB->count();

                foreach ($tcB as $key) {
                    $idtcB = $key->id_tc; 
                }
            #Con el Id_tc buscamo enl nombre del trabajo de campo.
                $tcBname = \App\Models\trabajocampo::findOrFail($idtcB);         
                
            #Con este Modelo Obtenemos los que no pasó en A ni en B
                $tcABNoPaso = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.paso','=',0)
                ->whereIn('detalle_trabajo_campos.id_tc',$tcABarray)
                    //->where('id_tc','=',$request->tca)
                    //->where('id_tc','=',$request->tcb)
                ->distinct()->get();
                
                $contABNp = $tcABNoPaso->count();

            #Con este Modelo Obtenemos los que pasaron en A ni en B
                $tcABPaso = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.paso','=',1)
                ->whereIn('detalle_trabajo_campos.id_tc',$tcABarray)
                    //->where('id_tc','=',$request->tca)
                    //->where('id_tc','=',$request->tcb)
                ->distinct()->get();

                $contABp = $tcABPaso->count();        
                
            #Modelo 1 Todos los que pasan en A        
                $modelo1 = DB::table('detalle_trabajo_campos')
                ->where('id_finca','=',$id_finca)
                ->where('paso','=',1)
                ->where('id_tc','=',$request->tca)
                ->get();

            #Almacenams en un Array todos las series
                foreach ($modelo1 as $key ) {
                    $arrayIdSerie [] = $key->serie;  
                }

            #Modelo A Todos los que no pasaron en A        
                $modeloA = DB::table('detalle_trabajo_campos')
                ->where('id_finca','=',$id_finca)
                ->where('paso','=',0)
                ->where('id_tc','=',$request->tca)
                ->get();

            #Almacenams en un Array todos las series
                foreach ($modeloA as $key ) {
                    $arrayIdSerieNp [] = $key->serie;  
                }

            #Modelo 2 Animales que no pasaron en A y y tampoco en B.
                $modelo2 = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.paso','=',0)
                ->where('detalle_trabajo_campos.id_tc','=',$request->tcb)
                ->whereIn('detalle_trabajo_campos.serie',$arrayIdSerieNp)
                ->get();

                $contm2 = $modelo2->count();

            #Modelo 3 Animales que Pasaron en A y no B 
                $modelo3 = DB::table('detalle_trabajo_campos')
                ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
                ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
                ->where('detalle_trabajo_campos.paso','=',0)
                ->where('detalle_trabajo_campos.id_tc','=',$request->tcb)
                ->whereIn('detalle_trabajo_campos.serie',$arrayIdSerie)
                ->get();

                $contm3 = $modelo3->count();        
                
                $tcANombre = $tcAname->nombre; 
                $tcBNombre = $tcBname->nombre;
                $arregloSNp =$arrayIdSerieNp;
                $arregloPAnB =$arrayIdSerie;
            }
        }
        
        return view('trabajocampo.comparar_tc', compact('finca','tc','tcA','tcB','tcABNoPaso','tcABPaso','contA','contB','contABNp','contABp','contm2','tcANombre','tcBNombre','contm3','modelo3','modelo2','vartca','vartcb','arregloSNp','arregloPAnB'));
    }

    public function tc_imprimir(Request $request, $id_finca)
    {
        
       //return $request;
        
      
        $finca = \App\Models\sgfinca::findOrFail($id_finca);
        $fechadereporte = Carbon::now();

        
        if ($request->prin == 1) {
            # Reporte para los que no pasaron en AxB
            $Array = [$request->vartca,$request->vartcb];

            $tcABNoPaso = DB::table('detalle_trabajo_campos')
            ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
            ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
            ->where('detalle_trabajo_campos.paso','=',0)
            ->whereIn('detalle_trabajo_campos.id_tc',$Array)
            ->distinct()->orderBy('caso','ASC')->get();
            
            $cantregistro = $tcABNoPaso->count();

            $pdf = PDF::loadView('reports.animales_modelo1',compact('finca','tcABNoPaso','fechadereporte','cantregistro'));  
            return $pdf->stream('Reporte_Animales_que_no_pasaron_en_A_B.pdf'); 
            //return view('reports.animales_nopasaronAB',compact('finca','tcABNoPaso','fechadereporte','cantregistro'));   
        }

        if ($request->prin == 2) {
            
            #Utilizamos este arreglo para almecenar las series
            $Array = $request->serie;
            $id_tcb = $request->vartcb;
            
            #Modelo 2 Animales que no pasaron en A y y tampoco en B.
            $modelo2 = DB::table('detalle_trabajo_campos')
            ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
            ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
            ->where('detalle_trabajo_campos.paso','=',0)
            ->where('detalle_trabajo_campos.id_tc','=',$id_tcb)
            ->whereIn('detalle_trabajo_campos.serie',$Array)
            ->orderBy('caso','ASC')->get();
            $cantregistro = $modelo2->count();

            $pdf = PDF::loadView('reports.animales_modelo2',compact('finca','modelo2','fechadereporte','cantregistro'));  

            return $pdf->stream('Reporte_Animales_que_no_pasaron_en_A_ni_en_B.pdf'); 
            //return view('reports.animales_nopasaronAB',compact('finca','tcABNoPaso','fechadereporte','cantregistro'));   
        }

        if ($request->prin==3) {
            
            //return $request;
            #Utilizamos este arreglo para almecenar las series
            $Array = $request->idserie;
            $id_tcb = $request->vartcb;

            #Modelo 3 Animales que Pasaron en A y no B 
            $modelo3 = DB::table('detalle_trabajo_campos')
            ->join('sganims','sganims.id','=','detalle_trabajo_campos.id_serie')
            ->where('detalle_trabajo_campos.id_finca','=',$id_finca)
            ->where('detalle_trabajo_campos.paso','=',0)
            ->where('detalle_trabajo_campos.id_tc','=',$id_tcb)
            ->whereIn('detalle_trabajo_campos.serie',$Array)
            ->orderBy('caso','ASC')->get(); 

            $cantregistro = $modelo3->count();

            $pdf = PDF::loadView('reports.animales_modelo3',compact('finca','modelo3','fechadereporte','cantregistro'));  

            return $pdf->stream('Reporte_Animales_que_pasaron_en_A_pero_no_en_B.pdf'); 
            //return view('reports.animales_nopasaronAB',compact('finca','tcABNoPaso','fechadereporte','cantregistro'));
        }

    }


    public function eliminar_tc(Request $request, $id_finca, $id_tc)
    {
       
      $tcEliminar = \App\Models\trabajocampo::findOrFail($id_tc);
      
       // return $tcEliminar;
      try {
        $detalleTc = DB::table('detalle_trabajo_campos')
        ->where('id_finca','=',$id_finca)
        ->where('id_tc','=',$id_tc)
        ->delete();

        $tcEliminar->delete();    
        
        return back()->with('mensaje', 'ok');     

    }catch (\Illuminate\Database\QueryException $e){
        return back()->with('mensaje', 'error');
    }
}

}
