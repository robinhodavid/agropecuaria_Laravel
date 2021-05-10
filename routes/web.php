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

Route::get('/home/sisga-admin/finca/{id}/series-inactivas', [App\Http\Controllers\HomeController::class, 'series_inactivas'])->name('series_inactivas');  

Route::get('/home/sisga-admin/finca/{id}/series-por-destetar', [App\Http\Controllers\HomeController::class, 'series_pordestetar'])->name('series_pordestetar');  

Route::get('/home/sisga-admin/finca/{id}/series-productivas', [App\Http\Controllers\HomeController::class, 'series_hembras_productivas'])->name('series_hembras_productivas');  

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

Route::post('/home/sisga-admin/finca/{id_finca}/patologia', [App\Http\Controllers\HomeController::class, 'crear_patologia'])->name('patologia.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'editar_patologia'])->name('patologia.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'update_patologia'])->name('patologia.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/patologia/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_patologia'])->name('patologia.eliminar'); 

/*
*Parámetros de Control Ganaderia
*/

/*Ruta para el registro de patologías*/
Route::get('/home/sisga-admin/finca/{id_finca}/parametros', [App\Http\Controllers\HomeController::class, 'parametros'])->name('parametros');


Route::post('/home/sisga-admin/finca/{id_finca}/parametros-ganaderia', [App\Http\Controllers\HomeController::class, 'crear_parametros_ganaderia'])->name('parametros_ganaderia.crear');

Route::post('/home/sisga-admin/finca/{id_finca}/parametros-reproduccion', [App\Http\Controllers\HomeController::class, 'crear_parametros_reproduccion'])->name('parametros_reproduccion.crear');

Route::post('/home/sisga-admin/finca/{id_finca}/parametros-produccion-lechera', [App\Http\Controllers\HomeController::class, 'crear_parametros_produccion_leche'])->name('parametros_produccion_leche.crear');



Route::get('/home/sisga-admin/finca/{id_finca}/parametros-ganaderia/{id}', [App\Http\Controllers\HomeController::class, 'editar_parametros_ganaderia'])->name('parametros_ganaderia.editar');

Route::get('/home/sisga-admin/finca/{id_finca}/parametros-reproduccion/{id}', [App\Http\Controllers\HomeController::class, 'editar_parametros_reproduccion'])->name('parametros_reproduccion.editar');

Route::get('/home/sisga-admin/finca/{id_finca}/parametros-produccion/{id}', [App\Http\Controllers\HomeController::class, 'editar_parametros_produccion_leche'])->name('parametros_produccion_leche.editar');



Route::put('/home/sisga-admin/finca/{id_finca}/parametros-ganaderia/{id}', [App\Http\Controllers\HomeController::class, 'update_parametros_ganaderia'])->name('parametros_ganaderia.update');

Route::put('/home/sisga-admin/finca/{id_finca}/parametros-reproduccion/{id}', [App\Http\Controllers\HomeController::class, 'update_parametros_reproduccion'])->name('parametros_reproduccion.update');

Route::put('/home/sisga-admin/finca/{id_finca}/parametros-produccion/{id}', [App\Http\Controllers\HomeController::class, 'update_parametros_produccion_leche'])->name('parametros_produccion_leche.update');


/***********************************************
* Inicio Ruta de Variable de Control Tipo de Montas para cada Finca.
************************************************/

Route::get('/home/sisga-admin/finca/{id_finca}/tipo-monta', [App\Http\Controllers\HomeController::class, 'tipomonta'])->name('tipomonta');

Route::post('/home/sisga-admin/finca/{id_finca}/tipo-monta', [App\Http\Controllers\HomeController::class, 'crear_tipomonta'])->name('tipomonta.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/tipo-monta/{id}', [App\Http\Controllers\HomeController::class, 'editar_tipomonta'])->name('tipomonta.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/tipo-monta/{id}', [App\Http\Controllers\HomeController::class, 'update_tipomonta'])->name('tipomonta.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/tipo-monta/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_tipomonta'])->name('tipomonta.eliminar'); 

/*
*-> Rutas para Variables de Control - Tablas menores "Causa de Muertes"
*/

/*Ruta para el registro de Causas de Muertes*/
Route::get('/home/sisga-admin/finca/{id_finca}/causa-de-muerte', [App\Http\Controllers\HomeController::class, 'causamuerte'])->name('causamuerte');

Route::post('/home/sisga-admin/finca/{id_finca}/causa-de-muerte', [App\Http\Controllers\HomeController::class, 'crear_causamuerte'])->name('causamuerte.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/causa-de-muerte/{id}', [App\Http\Controllers\HomeController::class, 'editar_causamuerte'])->name('causamuerte.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/causa-de-muerte/{id}', [App\Http\Controllers\HomeController::class, 'update_causamuerte'])->name('causamuerte.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/causa-de-muerte/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_causamuerte'])->name('causamuerte.eliminar'); 

/*Ruta para el registro Destinos de Salida*/
Route::get('/home/sisga-admin/finca/{id_finca}/destino-salida', [App\Http\Controllers\HomeController::class, 'destinosalida'])->name('destinosalida');

Route::post('/home/sisga-admin/finca/{id_finca}/destino-salida', [App\Http\Controllers\HomeController::class, 'crear_destinosalida'])->name('destinosalida.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/destino-salida/{id}', [App\Http\Controllers\HomeController::class, 'editar_destinosalida'])->name('destinosalida.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/destino-salida/{id}', [App\Http\Controllers\HomeController::class, 'update_destinosalida'])->name('destinosalida.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/destino-salida/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_destinosalida'])->name('destinosalida.eliminar'); 

/*Ruta para el registro Procedencia*/
Route::get('/home/sisga-admin/finca/{id_finca}/procedencia', [App\Http\Controllers\HomeController::class, 'procedencia'])->name('procedencia');

Route::post('/home/sisga-admin/finca/{id_finca}/procedencia', [App\Http\Controllers\HomeController::class, 'crear_procedencia'])->name('procedencia.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/procedencia/{id}', [App\Http\Controllers\HomeController::class, 'editar_procedencia'])->name('procedencia.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/procedencia/{id}', [App\Http\Controllers\HomeController::class, 'update_procedencia'])->name('procedencia.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/procedencia/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_procedencia'])->name('procedencia.eliminar'); 


/*Ruta para el registro Sala de Ordeño*/
Route::get('/home/sisga-admin/finca/{id_finca}/sala-de-ordeno', [App\Http\Controllers\HomeController::class, 'salaordeno'])->name('salaordeno');

Route::post('/home/sisga-admin/finca/{id_finca}/sala-de-ordeno', [App\Http\Controllers\HomeController::class, 'crear_salaordeno'])->name('salaordeno.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/sala-de-ordeno/{id}', [App\Http\Controllers\HomeController::class, 'editar_salaordeno'])->name('salaordeno.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/sala-de-ordeno/{id}', [App\Http\Controllers\HomeController::class, 'update_salaordeno'])->name('salaordeno.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/sala-de-ordeno/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_salaordeno'])->name('salaordeno.eliminar'); 

/*Ruta para el registro Tanque de Enfriamiento*/
Route::get('/home/sisga-admin/finca/{id_finca}/tanque-enfriamiento', [App\Http\Controllers\HomeController::class, 'tanque'])->name('tanque');

Route::post('/home/sisga-admin/finca/{id_finca}/tanque-enfriamiento', [App\Http\Controllers\HomeController::class, 'crear_tanque'])->name('tanque.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/tanque-enfriamiento/{id}', [App\Http\Controllers\HomeController::class, 'editar_tanque'])->name('tanque.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/tanque-enfriamiento/{id}', [App\Http\Controllers\HomeController::class, 'update_tanque'])->name('tanque.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/tanque-enfriamiento/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_tanque'])->name('tanque.eliminar'); 

/*Ruta para el registro de colores utilizados en  el Campo*/
Route::get('/home/sisga-admin/finca/{id_finca}/colores-campo', [App\Http\Controllers\HomeController::class, 'colores'])->name('colores');

Route::post('/home/sisga-admin/finca/{id_finca}/colores-campo', [App\Http\Controllers\HomeController::class, 'crear_colores'])->name('colores.crear');

Route::get('/home/sisga-admin/finca/{id_finca}/colores-campo/{id}', [App\Http\Controllers\HomeController::class, 'editar_colores'])->name('colores.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/colores-campo/{id}', [App\Http\Controllers\HomeController::class, 'update_colores'])->name('colores.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/colores-campo/{id}', [App\Http\Controllers\HomeController::class, 'eliminar_colores'])->name('colores.eliminar'); 

/***********************************************
* Fin de Ruta de Variable de Control Tipo de Montas para cada Finca.
************************************************/





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

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/reportes/catalogo-de-ganado-inactivo', [App\Http\Controllers\ReportController::class, 'report_catalogoganadoinactivo'])->name('catalogoganadoinactivo.reporte'); 

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/reportes/catalogo-de-ganado-por-destetar', [App\Http\Controllers\ReportController::class, 'report_catalogoganadopordestete'])->name('ganadopordestete.reporte'); 

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/reportes/catalogo-de-ganado-hembras-reproductivas', [App\Http\Controllers\ReportController::class, 'report_catalogohemrepro'])->name('catalogohemrepro.reporte'); 
/*
*
*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/peso-especifico/{serie}', [App\Http\Controllers\RutasController::class, 'registar_pesoespecifico'])->name('pesoespecifico.mostrar');

	Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/peso-especifico/{serie}', [App\Http\Controllers\RutasController::class, 'crear_pesoespecifico'])->name('pesoespecifico.crear');

	Route::delete('/home/sisga-admin/finca/{id_finca}/ganaderia/ficha-de-ganado/eliminar-peso-especifico/{id_peso}', [App\Http\Controllers\RutasController::class, 'eliminar_pesoespecifico'])->name('pesoespecifico.eliminar'); 

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
/*----> End Registro de Sub Lote.*/ 


/*---> Rutas para la vista Cambio de Tipologia*/

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/cambio-de-tipologia', [App\Http\Controllers\RutasController::class, 'Cambio_tipologia'])->name('cambio_tipologia'); 

Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/cambio-de-tipologia', [App\Http\Controllers\RutasController::class, 'cambiar_tipo'])->name('tipologia.cambiar'); 


	//--> Ruta para filtrar la Tipologia por secuencia  en forma dinamica.
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/cambio-de-tipologia/filtro/{id_tipo}', [App\Http\Controllers\RutasController::class, 'filterTipologia'])->name('filterTipologia');

/* -> Fin de Rutas para cambio de Tiologia*/



/*Ruta para la vista ver las series asignadas a un lote*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/series-en-lote/{id}', [App\Http\Controllers\RutasController::class, 'seriesenlote'])->name('seriesenlote'); 

	/*Ruta para la vista ver las series asignadas a un sub lote*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/lote/series-en-sublote/{id}', [App\Http\Controllers\RutasController::class, 'seriesensublote'])->name('seriesensublote'); 

	
	/*Ruta para la vista General para asignar series a un Lote o a un sublote en específico*/
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignarseries'])->name('asignarseries');
/*
	//--> Ruta para filtrar el select sub-lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/{nombre_lote}', [App\Http\Controllers\RutasController::class, 'filterName'])->name('filterName');
*/	
	//--> Ruta para filtrar el select sub-lote en forma dinamica.
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/asignar-series/{nombre_lote}', [App\Http\Controllers\RutasController::class, 'filterName'])->name('filterName');


	//--> Ruta para filtrar el select lote en forma dinamica.
	Route::get('/home/ganaderia/asignar-series/tipo/{tipo}', [App\Http\Controllers\RutasController::class, 'filterTipo'])->name('filterTipo');

	//--> Ruta que envia los numeros de id y permite hacer en el controlador el update de los campos
	Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/asignar-series', [App\Http\Controllers\RutasController::class, 'asignar_serielote'])->name('serielote.asignar'); 
/*End Ruta para la vista ver las series asignadas a un lote*/
 

 

/*Ruta para la transferencia*/
Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/transferencia', [App\Http\Controllers\RutasController::class, 'transferencia'])->name('transferencia'); 
 
Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/transferencia', [App\Http\Controllers\RutasController::class, 'transferir_series'])->name('serie.transferir'); 

	//lleva a la vista de reporte de Transferencia 

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-reportes-transferencia', [App\Http\Controllers\RutasController::class, 'vista_reportestransferencia'])->name('reportes_transferencia'); 

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reportes-transferencia', [App\Http\Controllers\ReportController::class, 'report_transferencia'])->name('transferencia.reporte');

/*End Transferencia*/


/*Ruta para la salida de Animales*/
Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/salida-de-series', [App\Http\Controllers\RutasController::class, 'salida'])->name('salida'); 
 
Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/salida-de-series', [App\Http\Controllers\RutasController::class, 'salida_series'])->name('serie.salida'); 

	//lleva a la vista de reporte de Transferencia 

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-reportes-salida-de-series', [App\Http\Controllers\RutasController::class, 'vista_reportes_salida'])->name('reportes_transferencia'); 

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reportes-salida-de-series', [App\Http\Controllers\ReportController::class, 'report_salida'])->name('salida.reporte');
/*End Transferencia*/


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


/*--> Rutas para el Ajuste de Peso*/

Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/peso-ajustado', [App\Http\Controllers\RutasController::class, 'peso_ajustado'])->name('peso_ajustado'); 

Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/calcular-peso-ajustado', [App\Http\Controllers\RutasController::class, 'calcular_peso_ajustado'])->name('calcular_peso_ajustado');

//lleva a la vista de reporte de Transferencia 
	
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-reportes-de-ajuste-de-peso', [App\Http\Controllers\RutasController::class, 'vista_reportespesoajustado'])->name('reportes_pesoajustado');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reportes-peso-ajustado', [App\Http\Controllers\ReportController::class, 'report_pesoajustado'])->name('pesoajustado.reporte');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reportes-de-ajuste-de-peso', [App\Http\Controllers\ReportController::class, 'report_pa'])->name('pa.reporte');

/* End Transferencia */

/*-> FIN de Rutas Ajuste de Peso*/

/*---> Rutas para la vista Cambio de Tipologia*/ 

Route::post('/home/sisga-admin/finca/{id_finca}/ganaderia/peso', [App\Http\Controllers\RutasController::class, 'cambiar_tipo'])->name('tipologia.cambiar'); 

/* -> Fin de Rutas para cambio de Tiologia*/


/*Ruta para la vista de reportes generales*/

Route::get('/home/sisga-admin/finca/{id_finca}/reportes-generales', [App\Http\Controllers\RutasController::class, 'vista_reportesgenerales'])->name('reportes_generales'); 

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-catalogo-de-ganado', [App\Http\Controllers\RutasController::class, 'vista_reportecatalogoganado'])->name('reportes_catalogodeganado');
	
	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reportes-catalogo-de-ganado', [App\Http\Controllers\ReportController::class, 'report_catalogoseries'])->name('catalago.reporte');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-pajuela', [App\Http\Controllers\RutasController::class, 'vista_reportepajuela'])->name('reportes_pajuela');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reporte-pajuela', [App\Http\Controllers\ReportController::class, 'report_pajuela'])->name('pajuela.reporte');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-historial-salida', [App\Http\Controllers\RutasController::class, 'vista_reportehistsalida'])->name('reportes_histsalida');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reporte-historial-salida', [App\Http\Controllers\ReportController::class, 'report_historialsalida'])->name('histsal.reporte');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/vista-movimiento-lote', [App\Http\Controllers\RutasController::class, 'vista_reportemovimientolote'])->name('reportes_movimientolote');

	Route::get('/home/sisga-admin/finca/{id_finca}/ganaderia/reporte-movimiento-lote', [App\Http\Controllers\ReportController::class, 'report_movimientolote'])->name('movimientolote.reporte');

/* ----> EndRoute Módulo de ganadería <-----*/

/***********************************************
* Inicio Rutas Módulo de Reproducción Animal
************************************************/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva', [App\Http\Controllers\ReprodController::class, 'temporada_monta'])->name('temporada_monta');

Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva', [App\Http\Controllers\ReprodController::class, 'crear_temporada'])->name('temporada.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva/{id}', [App\Http\Controllers\ReprodController::class, 'editar_temporada'])->name('temporada.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva/{id}', [App\Http\Controllers\ReprodController::class, 'update_temporada'])->name('temporada.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva/eliminar/{id}', [App\Http\Controllers\ReprodController::class, 'eliminar_temporada'])->name('temporada.eliminar');

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-cierre/{id}', [App\Http\Controllers\ReprodController::class, 'cierre_temporada'])->name('temporada.cerrar');

//Con esta Ruta Ingresamos dentro de la Temporada
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}', [App\Http\Controllers\ReprodController::class, 'temporada_detalle'])->name('temporada.detalle'); 

//Con esta Ruta Creamos el Ciclo reproductivo
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo', [App\Http\Controllers\ReprodController::class, 'ciclo'])->name('ciclo'); 

Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/crear-ciclo', [App\Http\Controllers\ReprodController::class, 'crear_ciclo'])->name('ciclo.crear'); 

Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/editar-ciclo/{id_ciclo}', [App\Http\Controllers\ReprodController::class, 'editar_ciclo'])->name('ciclo.editar'); 

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/editar-ciclo/{id_ciclo}', [App\Http\Controllers\ReprodController::class, 'update_ciclo'])->name('ciclo.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva/{id}/eliminar-ciclo/{id_ciclo}', [App\Http\Controllers\ReprodController::class, 'eliminar_ciclo'])->name('ciclo.eliminar');


/*
*	Aquí se coloca la ruta que mostrara el progreso de la temporada de monta
*/
	Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}', [App\Http\Controllers\ReprodController::class, 'detalle_ciclo'])->name('ciclo.detalle'); 

	// Creamos la ruta que permitira asignar las series a los lotes de montas. 

	Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/lote-de-monta', [App\Http\Controllers\ReprodController::class, 'lotemonta'])->name('lotemonta'); 

	Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/lote-de-monta', [App\Http\Controllers\ReprodController::class, 'crear_lotemonta'])->name('lotemonta.crear'); 

	Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/editar-lote-de-monta/{id_lotemonta}', [App\Http\Controllers\ReprodController::class, 'editar_lotemonta'])->name('lotemonta.editar'); 

	Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/editar-lote-de-monta/{id_lotemonta}', [App\Http\Controllers\ReprodController::class, 'update_lotemonta'])->name('lotemonta.update');

	Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/eliminar-lote-de-monta/{id_lotemonta}', [App\Http\Controllers\ReprodController::class, 'eliminar_lotemonta'])->name('lotemonta.eliminar');

	Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/series-en-lote-de-monta', [App\Http\Controllers\ReprodController::class, 'serieslotemonta'])->name('serieslotemonta'); 


	Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/ciclo/{id_ciclo}/asignando-series-en-lote-de-monta', [App\Http\Controllers\ReprodController::class, 'asignarserieslotemonta'])->name('asignarserieslotemonta'); 
/*						
* Rutas para el registro de cada proceso que se raliza en la monta 
*/

/*
*--->| Registro de Celos
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/celo', [App\Http\Controllers\ReprodController::class,'celos'])->name('celos');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-celo', [App\Http\Controllers\ReprodController::class, 'crear_celos'])->name('celos.crear');


Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/editar-celo/{id_celo}', [App\Http\Controllers\ReprodController::class, 'editar_celos'])->name('celos.editar');

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/actualizar-registro-de-celo/{id_celo}', [App\Http\Controllers\ReprodController::class, 'update_celos'])->name('celos.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-celo/{id_celo}', [App\Http\Controllers\ReprodController::class, 'eliminar_celo'])->name('celos.eliminar');

/*
*--->| Registro de Servicios
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/servicio', [App\Http\Controllers\ReprodController::class,'servicio'])->name('servicio');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-servicio', [App\Http\Controllers\ReprodController::class, 'crear_servicio'])->name('servicio.crear');


Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/editar-servicio/{id_servicio}', [App\Http\Controllers\ReprodController::class, 'editar_servicio'])->name('servicio.editar');

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/actualizar-registro-de-servicio/{id_servicio}', [App\Http\Controllers\ReprodController::class, 'update_servicio'])->name('servicio.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-servicio/{id_servicio}', [App\Http\Controllers\ReprodController::class, 'eliminar_servicio'])->name('servicio.eliminar');


/*
*--->| Registro de Palpaciones
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/palpaciones', [App\Http\Controllers\ReprodController::class,'palpacion'])->name('palpacion');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-palpacion', [App\Http\Controllers\ReprodController::class, 'crear_palpacion'])->name('palpacion.crear');


Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/editar-palpacion/{id_palpacion}', [App\Http\Controllers\ReprodController::class, 'editar_palpacion'])->name('palpacion.editar');

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/actualizar-registro-de-palpacion/{id_palpacion}', [App\Http\Controllers\ReprodController::class, 'update_palpacion'])->name('palpacion.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-palpacion/{id_palpacion}', [App\Http\Controllers\ReprodController::class, 'eliminar_palpacion'])->name('palpacion.eliminar');


/*
*--->| Registro de Preñez
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/prenez', [App\Http\Controllers\ReprodController::class,'prenez'])->name('prenez');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-prenez', [App\Http\Controllers\ReprodController::class, 'crear_prenez'])->name('prenez.crear');


Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/editar-prenez/{id_prenez}', [App\Http\Controllers\ReprodController::class, 'editar_prenez'])->name('prenez.editar');

Route::put('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/actualizar-registro-de-prenez/{id_prenez}', [App\Http\Controllers\ReprodController::class, 'update_prenez'])->name('prenez.update');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-prenez/{id_prenez}', [App\Http\Controllers\ReprodController::class, 'eliminar_prenez'])->name('prenez.eliminar');


/*
*--->| Registro de Preñez
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/parto', [App\Http\Controllers\ReprodController::class,'parto'])->name('parto');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-parto', [App\Http\Controllers\ReprodController::class, 'crear_parto'])->name('parto.crear');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-parto/{id_parto}', [App\Http\Controllers\ReprodController::class, 'eliminar_parto'])->name('parto.eliminar');

/*
*--->| Registro de Preñez
*/
Route::get('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/aborto', [App\Http\Controllers\ReprodController::class,'aborto'])->name('aborto');


Route::post('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/crear-aborto', [App\Http\Controllers\ReprodController::class, 'crear_aborto'])->name('aborto.crear');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/serie/{id_serie}/eliminar-registro-de-aborto/{id_aborto}', [App\Http\Controllers\ReprodController::class, 'eliminar_aborto'])->name('aborto.eliminar');

Route::delete('/home/sisga-admin/finca/{id_finca}/reproduccion/temporada-reproductiva-detalle/{id}/detalle-de-monta/{id_ciclo}/retirar-serie/{id_serie}', [App\Http\Controllers\ReprodController::class, 'eliminar_seriemonta'])->name('seriemonta.eliminar');

/***********************************************
* Fin Rutas Módulo de  Reproducción Animal
************************************************/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
