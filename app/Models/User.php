<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){

        return $this->belongsToMany('App\Models\Role')->withTimesTamps();
    }

    public function sgfincas(){

        return $this->belongsToMany('App\Models\sgfinca','sgfinca_user','user_id','id_finca')->withTimesTamps();
    }

    #Aqui verificamos que si el usuario tiene un permisos 
    public function havePermission($permission){

        //dd($this->roles); 
        foreach ($this->roles as $role) {
            if ($role['full-access']=='yes') {
                return true;
            } 
            //dd($permission);
            foreach ($role->permissions as $key) { 
               if ($key->slug == $permission) {
                  return true;   
                } 
            }    
        }
        return false; 
    }

    public function adminlte_image(){
        return 'https://picsum.photos/300/300';
    }

}