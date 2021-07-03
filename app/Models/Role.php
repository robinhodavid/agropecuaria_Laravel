<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description','full-access',
    ];
    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    #Relación n:n roles-usuarios
    public function users(){

        return $this->belongsToMany('App\Models\User')->withTimesTamps();
    }

    #
    public function permissions(){

        return $this->belongsToMany('App\Models\Permission')->withTimesTamps();
    }
}
