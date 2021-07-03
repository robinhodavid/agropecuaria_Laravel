<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
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
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    #Creamos la Vista de lista de Permisos
    public function index(Request $request)
    {
        if (! empty($request->search) ) {
            $permisos = DB::table('permissions')
                ->where('name','like',"%".$request->search."%")
                ->orderBy('id','ASC')
                ->take(4)->paginate(4);
            } else {
            $permisos = DB::table('permissions')
                ->where('name','like',"%".$request->search."%")
                ->orderBy('id','ASC')
                ->take(4)->paginate(4);
        } 
        return view('auth.roles.permission',compact('permisos'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    #Mostramos la Vista del formulario para crear los registros
    public function create(Request $request)
    {
        #Validando los datos
        $request->validate([
            'name'=> [
                'required',
                 Rule::unique('permissions')->ignore($request->id),
            ],
        ]);
       
        $permisoNuevo = new \App\Models\Permission;

        $permisoNuevo->name = $request->name;
        $permisoNuevo->description = $request->description;
        $permisoNuevo->slug =  str::slug($request['name'], '.');

        $permisoNuevo-> save();
       
        return back()->with('msj', 'Registro agregado satisfactoriamente');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permiso = \App\Models\Permission::findOrFail($id);

        return view('auth.roles.permission_edit',compact('permiso'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Validando los datos
        $request->validate([
            'name'=>'required'
            ]);

        $permisoUpdate = \App\Models\Permission::findOrFail($id);
        
        $permisoUpdate->name = $request->name;
        $permisoUpdate->description = $request->description;
        $permisoUpdate->slug =  str::slug($request['name'], '.');
        
        $permisoUpdate->save();

        return back()->with('msj', 'Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permisoEliminar = \App\Models\Permission::findOrFail($id);
 
        try {
            
            $permisoEliminar->delete();
            return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            
            return back()->with('mensaje', 'error');
        }
    }
}
