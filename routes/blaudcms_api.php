<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => '/v1'], function(){
	
	// Ruta para validar login desde el dispositivo movil
	/* /api/v1/login  */
	Route::post('login', 'Api\LoginController@jwtLogin')->name('api.v1.login');

	/********************************************************
		
		RUTAS PARA CONSUMO DE CATALOGOS DEL SISTEMA

	*********************************************************/
	route::group(['prefix' => '/catalogues'], function(){
		
		
		// Ruta que devuelve todos los catalogos del sistema
		/* /api/v1/catalogues/list  */
		Route::get('/list', 'Api\CataloguesController@index')->name('api.v1.catalogues.list');

		// Ruta que devuelve las provincias por region
		/* /api/v1/catalogues/states/list  */
		Route::get('/states/list', 'Api\CataloguesController@states')->name('api.v1.catalogues.states.list');

		// Ruta que devuelve las ciudades por provincia
		/* /api/v1/catalogues/cities/list  */
		Route::get('/cities/list/{sStateId?}', 'Api\CataloguesController@cities')->name('api.v1.catalogues.cities.list');

		// Ruta que devuelve el detalle de un catálogo
		/* /api/v1/catalogues/detail  */
		Route::get('/detail/{sCatalogueId?}', 'Api\CataloguesController@detail')->name('api.v1.catalogues.detail');

	});

});
