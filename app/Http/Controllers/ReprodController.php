<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;
use App\Models;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\sganim;
use Maatwebsite\Excel\Facades\Excel;
Use App\Http\Controllers\Controllers;
use Illuminate\Contracs\View\View;
//use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\SeriesActivas;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ReprodController extends Controller
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

    public function temporada_monta($id_finca){

    	$finca = \App\Models\sgfinca::findOrFail($id_finca);
    	
    	return view('reproduccion.temporada_ciclo');
    }




    
}
