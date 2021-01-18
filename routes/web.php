<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;

/*
Route::get('/', function () {
    return view('welcome');
}); 

/*---> Estas son las rutas para el ingreso 
del sistema según el siste map <---*/

/*Ruta principal del sistemas*/
Route::get('/', [RutasController::class, 'inicio' ]); 
/*--->*/

/*Ruta para la vista administrativa*/

Route::get('/home/sisga-admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin'); 
/*--->*/

/*Ruta para la vista finca*/

Route::get('/home/sisga-admin/fincas', [App\Http\Controllers\HomeController::class, 'fincas'])->name('fincas');

/*Con ésta ruta pasamos los argumentos al controlador registro y guardar en la tabla finca */
Route::post('/home/sisga-admin/fincas', [App\Http\Controllers\HomeController::class, 'crear'])->name('fincas.crear'); 
/*Con ésta ruta pasamos los argumentos al controlador para editar el registro y guardar en la tabla finca */
Route::get('/home/sisga-admin/fincas/{id}', [App\Http\Controllers\HomeController::class, 'editar'])->name('fincas.editar'); 

Route::put('/home/sisga-admin/fincas/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('fincas.update');

Route::delete('/home/sisga-admin/fincas/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar'])->name('fincas.eliminar'); 

/*-->Fin Rutas Finca*/


//-> Inicio Ruta de Variable de Control Especie

Route::get('/home/sisga-admin/especie', [App\Http\Controllers\HomeController::class, 'especie'])->name('especie');

//->> EndEspecie

/*Ruta para la vista tipologia*/

Route::get('/home/sisga-admin/tipologias', [App\Http\Controllers\HomeController::class, 'tipologia'])->name('tipologia');

Route::post('/home/sisga-admin/tipologias', [App\Http\Controllers\HomeController::class, 'crear_tipo'])->name('tipologia.crear'); 

Route::get('/home/sisga-admin/tipologias/{id}', [App\Http\Controllers\HomeController::class, 'editar_tipo'])->name('tipologia.editar'); 

Route::put('/home/sisga-admin/tipologias/{id}', [App\Http\Controllers\HomeController::class, 'update_tipo'])->name('tipologia.update');

Route::delete('/home/sisga-admin/tipologias/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_tipo'])->name('tipologia.eliminar'); 

/*End Route Tipologia */


/*---> Ruta para la vista Condiciones Corporales*/

Route::get('/home/sisga-admin/condicion-corporal', [App\Http\Controllers\HomeController::class, 'condicion_corporal'])->name('condicion_corporal');

Route::post('/home/sisga-admin/condicion-corporal', [App\Http\Controllers\HomeController::class, 'crear_condicioncorporal'])->name('condicion_corporal.crear'); 

Route::get('/home/sisga-admin/condicion-corporal/{id}', [App\Http\Controllers\HomeController::class, 'editar_condicion'])->name('condicion_corporal.editar'); 

Route::put('/home/sisga-admin/condicion-corporal/{id}', [App\Http\Controllers\HomeController::class, 'update_condicion'])->name('condicion_corporal.update');

Route::delete('/home/sisga-admin/condicion-corporal/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_condicion'])->name('condicion_corporal.eliminar'); 

/*End Ruta para Condiciones Corporales*/



/*Ruta para el diagnostico de palpaciones*/

Route::get('/home/sisga-admin/diagnostico-palpaciones', [App\Http\Controllers\HomeController::class, 'diagnostico_palpaciones'])->name('diagnostico_palpaciones');

Route::post('/home/sisga-admin/diagnostico-palpaciones', [App\Http\Controllers\HomeController::class, 'crear_diagnosticopalpaciones'])->name('diagnostico_palpaciones.crear'); 

Route::get('/home/sisga-admin/diagnostico-palpaciones/{id}', [App\Http\Controllers\HomeController::class, 'editar_diagnostico_palpaciones'])->name('diagnostico_palpaciones.editar'); 

Route::put('/home/sisga-admin/diagnostico-palpaciones/{id}', [App\Http\Controllers\HomeController::class, 'update_diagnostico_palpaciones'])->name('diagnostico_palpaciones.update');

Route::delete('/home/sisga-admin/diagnostico-palpaciones/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_diagnostico_palpaciones'])->name('diagnostico_palpaciones.eliminar'); 
/*-->> End Ruta palpaciones*/



/*Ruta para motivos de entrada y salidas de series*/
Route::get('/home/sisga-admin/motivos-entrada-salida', [App\Http\Controllers\HomeController::class, 'motivo_entrada_salida'])->name('motivo_entrada_salida');

Route::post('/home/sisga-admin/motivos-entrada-salida', [App\Http\Controllers\HomeController::class, 'crear_motivo_entrada_salida'])->name('motivo_entrada_salida.crear'); 

Route::get('/home/sisga-admin/motivos-entrada-salida/{id}', [App\Http\Controllers\HomeController::class, 'editar_motivo_entrada_salida'])->name('motivo_entrada_salida.editar'); 

Route::put('/home/sisga-admin/motivos-entrada-salida/{id}', [App\Http\Controllers\HomeController::class, 'update_motivo_entrada_salida'])->name('motivo_entrada_salida.update');

Route::delete('/home/sisga-admin/motivos-entrada-salida/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_motivo_entrada_salida'])->name('motivo_entrada_salida.eliminar'); 
/*-->> End Ruta motivos*/



/*Ruta para el registro de Razas*/

Route::get('/home/sisga-admin/raza', [App\Http\Controllers\HomeController::class, 'raza'])->name('raza');

Route::post('/home/sisga-admin/raza', [App\Http\Controllers\HomeController::class, 'crear_raza'])->name('raza.crear'); 

Route::get('/home/sisga-admin/raza/{id}', [App\Http\Controllers\HomeController::class, 'editar_raza'])->name('raza.editar'); 

Route::put('/home/sisga-admin/raza/{id}', [App\Http\Controllers\HomeController::class, 'update_raza'])->name('raza.update');

Route::delete('/home/sisga-admin/raza/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_raza'])->name('raza.eliminar'); 

/*-->> End Ruta raza*/

/*Ruta para el registro de patologías*/

Route::get('/home/sisga-admin/patologia', [App\Http\Controllers\HomeController::class, 'patologia'])->name('patologia');

Route::post('/home/sisga-admin/patologia', [App\Http\Controllers\HomeController::class, 'crear_patologia'])->name('patologia.crear');

Route::get('/home/sisga-admin/patologia/{id}', [App\Http\Controllers\HomeController::class, 'editar_patologia'])->name('patologia.editar'); 

Route::put('/home/sisga-admin/patologia/{id}', [App\Http\Controllers\HomeController::class, 'update_patologia'])->name('patologia.update');

Route::delete('/home/sisga-admin/patologia/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_patologia'])->name('patologia.eliminar'); 



/*
Route::post('/home/sisga-admin/raza', [App\Http\Controllers\HomeController::class, 'crear_raza'])->name('raza.crear'); 

Route::get('/home/sisga-admin/raza/{id}', [App\Http\Controllers\HomeController::class, 'editar_raza'])->name('raza.editar'); 

Route::put('/home/sisga-admin/raza/{id}', [App\Http\Controllers\HomeController::class, 'update_raza'])->name('raza.update');

Route::delete('/home/sisga-admin/raza/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_raza'])->name('raza.eliminar'); 

/*-->> End Ruta raza*/




/* ----> BeginRoute: Estas son las rutas 
definidas para el Módulo de ganadería <-----*/

/*Ruta para la vista ficha de ganado*/
Route::get('/home/ganaderia/ficha-de-ganado', [App\Http\Controllers\RutasController::class, 'ganaderia'])->name('ficha'); 

	//--> Ruta para filtrar el select Tipologia por sexo en forma dinamica.
	Route::get('/home/ganaderia/ficha-de-ganado/sexo/{sexo}', [App\Http\Controllers\RutasController::class, 'filterSexo'])->name('filterSexo');

Route::post('/home/ganaderia/ficha-de-ganado', [App\Http\Controllers\RutasController::class, 'crear_fichaganado'])->name('fichaganado.crear');

Route::get('/home/ganaderia/ficha-de-ganado/{id}', [App\Http\Controllers\RutasController::class, 'editar_fichaganado'])->name('fichaganado.editar'); 
	







/*Ruta para la vista Lote*/
Route::get('/home/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'lote'])->name('lote'); 

//Ruta con el Slug de Lote
//Route::post('/home/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'chechkSlug_lote'])->name('lote.chechkSlug');

Route::post('/home/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'crear_lote'])->name('lote.crear'); 

Route::get('/home/ganaderia/lote/{id}', [App\Http\Controllers\RutasController::class, 'editar_lote'])->name('lote.editar'); 

Route::put('/home/ganaderia/lote/{id}', [App\Http\Controllers\RutasController::class, 'update_lote'])->name('lote.update');

Route::delete('/home/ganaderia/lote/eliminar/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_lote'])->name('lote.eliminar'); 

/*---> END REGISTRO DE LOTES*/


	/*Ruta para la vista Crear los SubLotes*/
	Route::get('/home/ganaderia/lote/crear-sub-lote/{id}', [App\Http\Controllers\RutasController::class, 'sublote'])->name('sublote'); 

	Route::post('/home/ganaderia/lote/crear-sub-lote/{id}', [App\Http\Controllers\RutasController::class, 'crear_sublote'])->name('sublote.crear'); 


	Route::delete('/home/ganaderia/lote/crear-sub-lote/eliminar/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_sublote'])->name('sublote.eliminar');  
	
	/*----> End Registro de Sub Lote. 


	/*Ruta para la vista ver las series asignadas a un lote*/
	Route::get('/home/ganaderia/lote/series-en-lote/{id}', [App\Http\Controllers\RutasController::class, 'seriesenlote'])->name('seriesenlote'); 

	/*Ruta para la vista ver las series asignadas a un sub lote*/
	Route::get('/home/ganaderia/lote/series-en-sublote/{id}', [App\Http\Controllers\RutasController::class, 'seriesensublote'])->name('seriesensublote'); 

	
	/*Ruta para la vista General para asignar series a un Lote o a un sublote en específico*/
	Route::get('/home/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignarseries'])->name('asignarseries');

	//--> Ruta para filtrar el select sub-lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/{nombre_lote}', [App\Http\Controllers\RutasController::class, 'filterName'])->name('filterName');
	
	//--> Ruta para filtrar el select lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/tipo/{tipo}', [App\Http\Controllers\RutasController::class, 'filterTipo'])->name('filterTipo');

	//--> Ruta que envia los numeros de id y permite hacer en el controlador el update de los campos
	Route::post('/home/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignar_serielote'])->name('serielote.asignar'); 

/*---> END REGISTRO DE LOTES*/
 

 

/*Ruta para la transferencia*/
Route::get('/home/ganaderia/transferencia', [App\Http\Controllers\RutasController::class, 'transferencia'])->name('transferencia'); 
 


/*Ruta para la vista de pajuela*/
Route::get('/home/ganaderia/pajuela', [App\Http\Controllers\RutasController::class, 'pajuela'])->name('pajuela'); 

Route::post('/home/ganaderia/pajuela', [App\Http\Controllers\RutasController::class, 'crear_pajuela'])->name('pajuela.crear'); 

Route::get('/home/ganaderia/pajuela/{id}', [App\Http\Controllers\RutasController::class, 'editar_pajuela'])->name('pajuela.editar'); 

Route::put('/home/ganaderia/pajuela/{id}', [App\Http\Controllers\RutasController::class, 'update_pajuela'])->name('pajuela.update');

Route::delete('/home/ganaderia/pajuela/eliminar/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_pajuela'])->name('pajuela.eliminar'); 

//->END PAJUELA


/* ----> EndRoute Módulo de ganadería <-----*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
