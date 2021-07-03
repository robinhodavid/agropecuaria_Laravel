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
use App\Models\Role;
use App\Models\Permission;
use App\Models;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Gate::authorize('haveaccess','roles.index');

        if (! empty($request->search) ) {
            $rol = DB::table('roles')
                ->where('name','like',"%".$request->search."%")
                ->orderBy('id','ASC')
                ->take(4)->paginate(4);
            } else {
            $rol = DB::table('roles')
                ->where('name','like',"%".$request->search."%")
                ->orderBy('id','ASC')
                ->take(4)->paginate(4);
        }

        $permisos = Permission::get();     
            
        return view('auth.roles.roles',compact('rol','permisos'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return $request; 
        Gate::authorize('haveaccess','roles.create');
        $permisos = Permission::get(); 
        return view('auth.roles.roles_create',compact('permisos'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('haveaccess','roles.create');
        #Validando los datos
        $request->validate([
            'name'=> [
                'required',
                 Rule::unique('roles')->ignore($request->id),
            ],
            
        ]);

        $campoSlug = str::slug($request['name'], '-');

        $rolNuevo = Role::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'full-access'=>$request->fullaccess,
            'slug'=> $campoSlug,
        ]); 
        
        if ($request->get('idpermiso')) {

           $rolNuevo->permissions()->sync($request->get('idpermiso')); 
        }
    
        return redirect()->route('roles.index')
            ->with('msj', 'Rol registrado satisfactoriamente');
       
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
    public function edit(Role $role)
    {   
        Gate::authorize('haveaccess','roles.edit');
        #Con esta verificamos si existe una relación role-permission
        $cont=count($role->permissions);

        if ($cont>0) {
            #Si existe entonces recorremos el foreach.
            foreach ($role->permissions as $key ) {
                $permission_role[] = $key->id;    
            }    
        } else {
            #Si no exste el valor de la variable, la pasamos a null
            $permission_role = null; 
        }
        
        $permisos = Permission::get();     

        return view('auth.roles.roles_edit',compact('permisos','role','permission_role'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('haveaccess','roles.edit');
        #Validando los datos
        $request->validate([
            //'name'=> 'required|unique:roles,name,'.$role->id,
            'name'=> 'required',
        ]);

        $campoSlug = str::slug($request['name'], '-');

        $role->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'full-access'=>$request->fullaccess,
            'slug'=> $campoSlug,
        ]);

        if ($request->get('idpermiso')) {

           $role->permissions()->sync($request->get('idpermiso')); 
        }

        return redirect()->route('roles.index')
            ->with('msj', 'Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Gate::authorize('haveaccess','roles.destroy');

        try {
        
            $role->delete();
            return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            
            return back()->with('mensaje', 'error');
        }
    }
}
