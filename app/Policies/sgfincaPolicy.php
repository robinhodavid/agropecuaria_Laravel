<?php

namespace App\Policies;

use App\Models\User;
use App\Models\sgfinca;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Arr;

class sgfincaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\sgfinca  $sgfinca
     * @return mixed
     */
    public function fincas (User $usuario, sgfinca $finca)
    {
        #Comprobamos si el perfil tiene o no Accesos completos
        foreach ($usuario->roles as $role) {
            #Si tiene accessos completos
            if ($role['full-access']=='yes') {
                #devolvemos el valor de true
               return true; 
            }else{ 
                //return "No tiene todos los accesos";
                #Buscamos las fincas asociadas a ese perfil
                #comprobamos si tenemos una relación usuario-finca
                $cont = count($usuario->sgfincas);    
                if ($cont>0) {
                    foreach ($usuario->sgfincas as $key) { 
                         #Aqui obtenemos un array con los id de las fincas
                         $idfinca [] = $key->id_finca;                        
                    }
                    # Guardamos el array en una collection par luego 
                    # ubicar su valor 
                    $colletionIdFinca = collect($idfinca);
                }
                    return $colletionIdFinca->contains($finca->id_finca);
                }
            }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\sgfinca  $sgfinca
     * @return mixed
     */
    public function update(User $user, sgfinca $sgfinca)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\sgfinca  $sgfinca
     * @return mixed
     */
    public function delete(User $user, sgfinca $sgfinca)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\sgfinca  $sgfinca
     * @return mixed
     */
    public function restore(User $user, sgfinca $sgfinca)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\sgfinca  $sgfinca
     * @return mixed
     */
    public function forceDelete(User $user, sgfinca $sgfinca)
    {
        //
    }
}
