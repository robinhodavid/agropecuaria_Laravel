<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Validation\Rule;
use App\Models;


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
        return view('home');
    }

    //Retorna a la vista administrativa
        public function admin()
    {
        return view('sisga-admin');
    }

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

    public function eliminar($id_finca){
        $fincasEliminar = \App\Models\sgfinca::findOrFail($id_finca);
        $fincasEliminar->delete();

        return back()->with('msj', 'Nota Eliminada');
    }

    //Retorna la vista especie
    public function especie()
    {
        $especie = \App\Models\sgespecie::all();
        return view('especie',compact('especie'));
    }
    //-->End Vista especie

    

    //Retorna a la vista administrativa /tipologia
    public function tipologia()
    {
        $tipologia = \App\Models\sgtipologia::all();
        return view('tipologia',compact('tipologia'));
    }

    //Con esto Agregamos datos en la tabla finca.
        public function crear_tipo(Request $request)
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
            'nombre_tipologia'=>'required',
            'nomenclatura'=>'required',
            'edad'=>'required',
            'peso'=>'required',
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

        $tipologiaNueva-> save(); 
       
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_tipo($id_tipologia){
           
        $tipologia = \App\Models\sgtipologia::findOrFail($id_tipologia);
        return view('editartipo', compact('tipologia'));
    }


    public function update_tipo(Request $request, $id_tipologia){
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

    public function eliminar_tipo($id_tipologia){
            
            $tipologiaEliminar = \App\Models\sgtipologia::findOrFail($id_tipologia);
            
            $tipologiaEliminar->delete();

            return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
    }

/* End-Tipología (Consultar-Registrar-Editar-Eliminar)*/

/*---> //Retorna a la vista administrativa /condicion-corporal*/
 
    public function condicion_corporal()
    {
        $condicion_corporal = \App\Models\sgcondicioncorporal::all();
        return view('condicioncorporal',compact('condicion_corporal'));
    }

    //Con esto Agregamos datos en la tabla finca.
        public function crear_condicioncorporal(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'nombre_condicion'=>'required',
        ]);
        
         //return  $request ->all();
/**/
        $condicionNueva = new \App\Models\sgcondicioncorporal;

        $condicionNueva->nombre_condicion = $request->nombre_condicion;
        $condicionNueva->descripcion = $request->descripcion;

        $condicionNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_condicion($id_condicion){
       
        $condicion_corporal = \App\Models\sgcondicioncorporal::findOrFail($id_condicion);
        return view('editarcondicion', compact('condicion_corporal'));
    }

    public function update_condicion(Request $request, $id_condicion){
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
    
   public function eliminar_condicion($id_condicion){
            
            $condicionEliminar = \App\Models\sgcondicioncorporal::findOrFail($id_condicion);
            
            $condicionEliminar->delete();

            return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
    }
/*---> End-condicion-corporal*/


/*---> //Retorna a la vista administrativa /condicion-corporal*/
 
    public function diagnostico_palpaciones()
    {
        $diagnostico_palpaciones = \App\Models\sgdiagnosticpalpaciones::all();
        return view('diagnosticopalpaciones',compact('diagnostico_palpaciones'));
    }
//Con esto Agregamos datos en la tabla finca.
        public function crear_diagnosticopalpaciones(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'nombre'=>'required',
            'descrip'=>'required'
        ]);
        
         //return  $request ->all();
/**/
        $diagnosticopalpacionesNueva = new \App\Models\sgdiagnosticpalpaciones;

        $diagnosticopalpacionesNueva->nombre = $request->nombre;
        $diagnosticopalpacionesNueva->descrip = $request->descrip;

        $diagnosticopalpacionesNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }
    public function editar_diagnostico_palpaciones($id_diagnostico){
       
        $diagnostico_palpaciones = \App\Models\sgdiagnosticpalpaciones::findOrFail($id_diagnostico);
        return view('editardiagnosticopalpaciones', compact('diagnostico_palpaciones'));
    }

    public function update_diagnostico_palpaciones(Request $request, $id_diagnostico){
        //Validando los datos
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

    public function eliminar_diagnostico_palpaciones($id_diagnostico){
            
            $diagnostico_palpacionesEliminar = \App\Models\sgdiagnosticpalpaciones::findOrFail($id_diagnostico);
            
            $diagnostico_palpacionesEliminar->delete();

            return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
    }

/*Motivo de las entradas y salidas*/

/*---> //Retorna a la vista administrativa /motivo-entrada-salida*/
 
    public function motivo_entrada_salida()
    {
        $motivo_entrada_salida = \App\Models\sgmotivoentradasalida::all();
        return view('motivoentradasalida', compact('motivo_entrada_salida'));
    }

//Con esto Agregamos datos en la tabla finca.
        public function crear_motivo_entrada_salida(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'nombremotivo'=>'required',
            'nomenclatura'=>'required'
        ]);
        
         //return  $request ->all();
/**/
        $motivo_entrada_salidaNueva = new \App\Models\sgmotivoentradasalida;

        $motivo_entrada_salidaNueva->nombremotivo = $request->nombremotivo;
        $motivo_entrada_salidaNueva->nomenclatura = $request->nomenclatura;
        $motivo_entrada_salidaNueva->tipo = $request->tipo;

       $motivo_entrada_salidaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_motivo_entrada_salida($id){
       
        $motivo_entrada_salida = \App\Models\sgmotivoentradasalida::findOrFail($id);
        return view('editarmotivoentradasalida', compact('motivo_entrada_salida'));
    }

    public function update_motivo_entrada_salida(Request $request, $id){
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

    public function eliminar_motivo_entrada_salida($id){
            
        $motivo_entrada_salidaEliminar = \App\Models\sgmotivoentradasalida::findOrFail($id);
            
        $motivo_entrada_salidaEliminar->delete();

            return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
    }

/*Raza*/

/*---> //Retorna a la vista administrativa /raza*/
 
    public function raza()
    {
        $raza = \App\Models\sgraza::all();
        return view('raza', compact('raza'));
    }

//Con esto Agregamos datos en la tabla raza.
        public function crear_raza(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'nombreraza'=>'required',
            'descripcion'=>'required'
        ]);
        
        //return  $request ->all();
/**/
        $razaNueva = new \App\Models\sgraza;

        $razaNueva->nombreraza = $request->nombreraza;
        $razaNueva->descripcion = $request->descripcion;

        $razaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    public function editar_raza($idraza){
       
        $raza = \App\Models\sgraza::findOrFail($idraza);
        return view('editarraza', compact('raza'));
    }

    public function update_raza(Request $request, $idraza){
        //Validando los datos
        $request->validate([
            'nombreraza'=>'required',
            'descripcion'=>'required'
                  ]);

        $razaUpdate = \App\Models\sgraza::findOrFail($idraza);

        $razaUpdate->nombreraza=$request->nombreraza;
        $razaUpdate->descripcion=$request->descripcion;
        
        $razaUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    public function eliminar_raza($idraza){
            
        $razaEliminar = \App\Models\sgraza::findOrFail($idraza);
            
        $razaEliminar->delete();

            return back()->with('msj', 'Nota Eliminada Satisfactoriamente');
    }

     public function patologia()
    {
        $patologia = \App\Models\sgpatologia::all();
        return view('patologia', compact('patologia'));
    }
     public function crear_patologia(Request $request)
    {
        
        //Validando los datos
        $request->validate([
            'patologia'=>[
                'required',
                Rule::unique('sgpatologias')->ignore($request->id),
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

        $patologiaNueva-> save(); 
   
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }
    public function editar_patologia($id){
       
        $patologia = \App\Models\sgpatologia::findOrFail($id);
        return view('editarpatologia', compact('patologia'));
    }

    public function update_patologia(Request $request, $id){
       //Validando los datos
        $request->validate([
            'patologia'=>[
                'required',
                Rule::unique('sgpatologias')->ignore($request->id),
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
    public function eliminar_patologia($id){
            
        $patologiaEliminar = \App\Models\sgpatologia::findOrFail($id);
            
        $patologiaEliminar->delete();

            return back()->with('msj', 'Registro Eliminado Satisfactoriamente');
    }

    

}
