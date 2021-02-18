<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RutasController;
use App\Http\Controllers\ReportController;

/*
Route::get('/', function () {
    return view('welcome');
}); 

/*---> Estas son las rutas para el ingreso 
del sistema según el siste map <---*/

/*Ruta principal del sistemas*/
Route::get('/', [RutasController::class, 'inicio' ])->name('inicio'); 


/*--->*/
Route::get('home', [RutasController::class, 'home' ])->name('home'); 

/*--->*/

/*En esta ruta obtenemos el listado de todas las fincas*/

Route::get('/home/fincas', [App\Http\Controllers\HomeController::class, 'fincas'])->name('fincas');

/*Con ésta ruta pasamos los argumentos al controlador registro y guardar en la tabla finca */
Route::post('/home/fincas', [App\Http\Controllers\HomeController::class, 'crear'])->name('fincas.crear'); 
/*Con ésta ruta pasamos los argumentos al controlador para editar el registro y guardar en la tabla finca */
Route::get('/home/fincas/{id}', [App\Http\Controllers\HomeController::class, 'editar'])->name('fincas.editar'); 

Route::put('/home/fincas/{id}', [App\Http\Controllers\HomeController::class, 'update'])->name('fincas.update');

Route::delete('/home/fincas/eliminar/{id}', [App\Http\Controllers\HomeController::class, 'eliminar'])->name('fincas.eliminar'); 

/*-->Fin Rutas Finca*/


/*Ruta para la vista administrativa*/

Route::get('/home/sisga-admin/finca/{id}', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');

Route::get('/home/sisga-admin/finca/{id}/series-activas', [App\Http\Controllers\HomeController::class, 'series_activas'])->name('series_activas');  





/*--->*/

/***********************************************
* Inicio Ruta de Variable de Control Especie
************************************************/

Route::get('/home/sisga-admin/finca/{id_finca}/especie', [App\Http\Controllers\HomeController::class, 'especie'])->name('especie');
/*
Route::get('/home/sisga-admin/especie', [App\Http\Controllers\HomeController::class, 'especie'])->name('especie');
*/
Route::post('/home/sisga-admin/finca/{id_finca}/especie', [App\Http\Controllers\HomeController::class, 'crear_especie'])->name('especie.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/especie/{id}', [App\Http\Controllers\HomeController::class, 'editar_especie'])->name('especie.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/especie/{id}', [App\Http\Controllers\HomeController::class, 'update_especie'])->name('especie.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/especie/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_especie'])->name('especie.eliminar'); 

/***********************************************
* Fin Ruta de Variable de Control Especie
************************************************/

/***********************************************
* Inicio Ruta de Variable de Control raza
************************************************/

Route::get('/home/sisga-admin/finca/{id_finca}/raza', [App\Http\Controllers\HomeController::class, 'raza'])->name('raza');
/*
Route::get('/home/sisga-admin/raza', [App\Http\Controllers\HomeController::class, 'raza'])->name('raza');
*/

Route::post('/home/sisga-admin/finca/{id_finca}/raza', [App\Http\Controllers\HomeController::class, 'crear_raza'])->name('raza.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/raza/{id}', [App\Http\Controllers\HomeController::class, 'editar_raza'])->name('raza.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/raza/{id}', [App\Http\Controllers\HomeController::class, 'update_raza'])->name('raza.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/raza/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_raza'])->name('raza.eliminar'); 

/***********************************************
* End Ruta de Variable de Control raza
************************************************/


/***********************************************
* Inicio Ruta de Variable de Control Tipologia
************************************************/
/*Ruta para la vista tipologia*/
Route::get('/home/sisga-admin/finca/{id_finca}/tipologias', [App\Http\Controllers\HomeController::class, 'tipologia'])->name('tipologia');
/*
Route::get('/home/sisga-admin/tipologias', [App\Http\Controllers\HomeController::class, 'tipologia'])->name('tipologia');
*/

Route::post('/home/sisga-admin/finca/{id_finca}/tipologias', [App\Http\Controllers\HomeController::class, 'crear_tipo'])->name('tipologia.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/tipologias/{id}', [App\Http\Controllers\HomeController::class, 'editar_tipo'])->name('tipologia.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/tipologias/{id}', [App\Http\Controllers\HomeController::class, 'update_tipo'])->name('tipologia.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/tipologias/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_tipo'])->name('tipologia.eliminar'); 

/***********************************************
* End Ruta de Variable de Control Tipologia
************************************************/

/***********************************************
* Inicio de Ruta para la vista Condiciones Corporales
************************************************/


Route::get('/home/sisga-admin/finca/{id_finca}/condicion-corporal', [App\Http\Controllers\HomeController::class, 'condicion_corporal'])->name('condicion_corporal');
/*
Route::get('/home/sisga-admin/condicion-corporal', [App\Http\Controllers\HomeController::class, 'condicion_corporal'])->name('condicion_corporal');
*/
Route::post('/home/sisga-admin/finca/{id_finca}/condicion-corporal', [App\Http\Controllers\HomeController::class, 'crear_condicioncorporal'])->name('condicion_corporal.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/condicion-corporal/{id}', [App\Http\Controllers\HomeController::class, 'editar_condicion'])->name('condicion_corporal.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/condicion-corporal/{id}', [App\Http\Controllers\HomeController::class, 'update_condicion'])->name('condicion_corporal.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/condicion-corporal/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_condicion'])->name('condicion_corporal.eliminar'); 

/***********************************************
* End de Ruta para la vista Condiciones Corporales
************************************************/

/***********************************************
* *Ruta para el diagnostico de palpaciones
************************************************/

Route::get('/home/sisga-admin/finca/{id_finca}/diagnostico-palpaciones', [App\Http\Controllers\HomeController::class, 'diagnostico_palpaciones'])->name('diagnostico_palpaciones');
/*
Route::get('/home/sisga-admin/diagnostico-palpaciones', [App\Http\Controllers\HomeController::class, 'diagnostico_palpaciones'])->name('diagnostico_palpaciones'); */

Route::post('/home/sisga-admin/finca/{id_finca}/diagnostico-palpaciones', [App\Http\Controllers\HomeController::class, 'crear_diagnosticopalpaciones'])->name('diagnostico_palpaciones.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/diagnostico-palpaciones/{id}', [App\Http\Controllers\HomeController::class, 'editar_diagnostico_palpaciones'])->name('diagnostico_palpaciones.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/diagnostico-palpaciones/{id}', [App\Http\Controllers\HomeController::class, 'update_diagnostico_palpaciones'])->name('diagnostico_palpaciones.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/diagnostico-palpaciones/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_diagnostico_palpaciones'])->name('diagnostico_palpaciones.eliminar'); 
/*-->> End Ruta palpaciones*/



/*Ruta para motivos de entrada y salidas de series*/

Route::get('/home/sisga-admin/finca/{id_finca}/motivos-entrada-salida', [App\Http\Controllers\HomeController::class, 'motivo_entrada_salida'])->name('motivo_entrada_salida');
/*
Route::get('/home/sisga-admin/motivos-entrada-salida', [App\Http\Controllers\HomeController::class, 'motivo_entrada_salida'])->name('motivo_entrada_salida');
*/
Route::post('/home/sisga-admin/finca/{id_finca}/motivos-entrada-salida', [App\Http\Controllers\HomeController::class, 'crear_motivo_entrada_salida'])->name('motivo_entrada_salida.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/motivos-entrada-salida/{id}', [App\Http\Controllers\HomeController::class, 'editar_motivo_entrada_salida'])->name('motivo_entrada_salida.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/motivos-entrada-salida/{id}', [App\Http\Controllers\HomeController::class, 'update_motivo_entrada_salida'])->name('motivo_entrada_salida.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/motivos-entrada-salida/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_motivo_entrada_salida'])->name('motivo_entrada_salida.eliminar'); 
/*-->> End Ruta motivos*/





/*Ruta para el registro de patologías*/
Route::get('/home/sisga-admin/finca/{id_finca}/patologia', [App\Http\Controllers\HomeController::class, 'patologia'])->name('patologia');
/*
Route::get('/home/sisga-admin/patologia', [App\Http\Controllers\HomeController::class, 'patologia'])->name('patologia');
*/
Route::post('/home/sisga-admin/finca/{id_finca}/patologia', [App\Http\Controllers\HomeController::class, 'crear_patologia'])->name('patologia.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'editar_patologia'])->name('patologia.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'update_patologia'])->name('patologia.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_patologia'])->name('patologia.eliminar'); 




/* ----> BeginRoute: Estas son las rutas 
definidas para el Módulo de ganadería <-----

Route::get('/home/ganaderia/ficha-de-ganado', [App\Http\Controllers\RutasController::class, 'ganaderia'])->name('ficha'); 
*/

/*Ruta para la vista ficha de ganado*/
Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado', [App\Http\Controllers\RutasController::class, 'ganaderia'])->name('ficha'); 

	//--> Ruta para filtrar el select Tipologia por sexo en forma dinamica.
	Route::get('/home/ganaderia/ficha-de-ganado/sexo/{sexo}', [App\Http\Controllers\RutasController::class, 'filterSexo'])->name('filterSexo');

Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado', [App\Http\Controllers\RutasController::class, 'crear_fichaganado'])->name('fichaganado.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/{serie}', [App\Http\Controllers\RutasController::class, 'editar_fichaganado'])->name('fichaganado.editar');

Route::put('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/{serie}', [App\Http\Controllers\RutasController::class, 'update_fichaganado'])->name('fichaganado.update'); 

/*
* Ruta para el reporte de Catalogo de Ganado.
*/
Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/reportes/catalogo-de-ganado', [App\Http\Controllers\ReportController::class, 'report_catalogoganado'])->name('catalogodeganado.reporte'); 

/*
*
*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/peso-especifico/{serie}', [App\Http\Controllers\RutasController::class, 'registar_pesoespecifico'])->name('pesoespecifico.mostrar');

	Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/peso-especifico/{serie}', [App\Http\Controllers\RutasController::class, 'crear_pesoespecifico'])->name('pesoespecifico.crear');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/peso-especifico/reportes/{serie}', [App\Http\Controllers\ReportController::class, 'report_pesoespecifico'])->name('pesoespecifico.reporte');
	


/*Ruta para la vista Lote*/
Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'lote'])->name('lote'); 

//Ruta con el Slug de Lote
//Route::post('/home/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'chechkSlug_lote'])->name('lote.chechkSlug');

Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/lote', [App\Http\Controllers\RutasController::class, 'crear_lote'])->name('lote.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/{id}', [App\Http\Controllers\RutasController::class, 'editar_lote'])->name('lote.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/{id}', [App\Http\Controllers\RutasController::class, 'update_lote'])->name('lote.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_lote'])->name('lote.eliminar'); 

/*---> END REGISTRO DE LOTES*/


/*Ruta para la vista Crear los SubLotes*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/crear-sub-lote/{id}', [App\Http\Controllers\RutasController::class, 'sublote'])->name('sublote'); 

	Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/crear-sub-lote/{id}', [App\Http\Controllers\RutasController::class, 'crear_sublote'])->name('sublote.crear'); 


	Route::delete('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/crear-sub-lote/eliminar/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_sublote'])->name('sublote.eliminar');  	
/*----> End Registro de Sub Lote. 


/*Ruta para la vista ver las series asignadas a un lote*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/series-en-lote/{id}', [App\Http\Controllers\RutasController::class, 'seriesenlote'])->name('seriesenlote'); 

	/*Ruta para la vista ver las series asignadas a un sub lote*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/series-en-sublote/{id}', [App\Http\Controllers\RutasController::class, 'seriesensublote'])->name('seriesensublote'); 

	
	/*Ruta para la vista General para asignar series a un Lote o a un sublote en específico*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignarseries'])->name('asignarseries');

	//--> Ruta para filtrar el select sub-lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/{nombre_lote}', [App\Http\Controllers\RutasController::class, 'filterName'])->name('filterName');
	
	//--> Ruta para filtrar el select lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/tipo/{tipo}', [App\Http\Controllers\RutasController::class, 'filterTipo'])->name('filterTipo');

	//--> Ruta que envia los numeros de id y permite hacer en el controlador el update de los campos
	Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignar_serielote'])->name('serielote.asignar'); 
/*End Ruta para la vista ver las series asignadas a un lote*/
 

 

/*Ruta para la transferencia*/
Route::get('/home/ganaderia/transferencia', [App\Http\Controllers\RutasController::class, 'transferencia'])->name('transferencia'); 
 


/*Ruta para la vista de pajuela*/

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/pajuela', [App\Http\Controllers\RutasController::class, 'pajuela'])->name('pajuela'); 

/*
Route::get('/home/ganaderia/pajuela', [App\Http\Controllers\RutasController::class, 'pajuela'])->name('pajuela'); 
*/
Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/pajuela', [App\Http\Controllers\RutasController::class, 'crear_pajuela'])->name('pajuela.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/pajuela/{id}', [App\Http\Controllers\RutasController::class, 'editar_pajuela'])->name('pajuela.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/ganaderia/pajuela/{id}', [App\Http\Controllers\RutasController::class, 'update_pajuela'])->name('pajuela.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/ganaderia/pajuela/eliminar/{id}', [App\Http\Controllers\RutasController::class, 'eliminar_pajuela'])->name('pajuela.eliminar'); 

//->END PAJUELA


/* ----> EndRoute Módulo de ganadería <-----*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
