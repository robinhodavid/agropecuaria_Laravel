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
use App\Models\sgfinca;
use App\Models;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('haveaccess','usuario.index');

        $user = User::with('roles')->orderBy('id', 'ASC')->paginate(5); 

        //dd($user);

        return view('auth.roles.user',compact('user'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('haveaccess','usuario.create');

        $finca = sgfinca::get();

        $user = User::get(); 

        $roles = Role::get();

        return view('auth.roles.user_create',compact('roles','user','finca'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         Gate::authorize('haveaccess','usuario.store');
        //return $request; 
        #Validando los datos
        $request->validate([
            'name'=> 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:6',
            'rol'=> 'required',
        ]);

        $password = bcrypt($request->password);         

        $userNuevo = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$password,
        ]); 
        
        #Aqui asignamos a la tabla pivot user_rol
        if ($request->get('rol')) {

           $userNuevo->roles()->sync($request->get('rol')); 
        }

        #Aqui asignamos a la tabla pivot finca_user
        if ($request->get('idfinca')) {

           $userNuevo->sgfincas()->sync($request->get('idfinca')); 
        }
    
        return redirect()->route('usuario.index')
            ->with('msj', 'Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {

        $contador = count($usuario->roles);
        if ($contador>0) {
            #Obtenemos el rol de cada usuario.
            foreach ($usuario->roles as $key ) {
                $roles_user = $key->id;    
            }       
        } else {
           #Entonces lo pasamos a null. 
           $roles_user = null;
        }

        #comprobamos si tenemos una relación usuario-finca
        $cont = count($usuario->sgfincas);

        if ($cont>0) {
            #Si la hay entonces obtenemos los id
            foreach ($usuario->sgfincas as $key ) {
                $sgfinca_user [] = $key->id_finca;    
            }       
        } else {
           #Entonces lo pasamos a null. 
           $sgfinca_user = null;
        }
              
        $finca = sgfinca::get();

        $user = User::get(); 

        $roles = Role::get();

        return view('auth.roles.user_edit',compact('roles','usuario','user','finca','roles_user','sgfinca_user')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        #Validando los datos
        $request->validate([
            'name'=> 'required',
            'email' => 'required',
            'password' => 'required|min:6',
            'rol'=> 'required',
        ]);

        $password = bcrypt($request->password);         

        $usuario->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$password,
        ]); 
        
        #Aqui asignamos a la tabla pivot user_rol
        if ($request->get('rol')) {

           $usuario->roles()->sync($request->get('rol')); 
        }

        #Aqui asignamos a la tabla pivot finca_user
        if ($request->get('idfinca')) {

           $usuario->sgfincas()->sync($request->get('idfinca')); 
        }
    
        return redirect()->route('usuario.index')
            ->with('msj', 'Registro Actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *usuario
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {
      
        try {
        
            $usuario->delete();
            return back()->with('mensaje', 'ok');     

        }catch (\Illuminate\Database\QueryException $e){
            
            return back()->with('mensaje', 'error');
        }
    }
}
