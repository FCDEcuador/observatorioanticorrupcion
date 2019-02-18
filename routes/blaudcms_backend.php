<?php

/*
|--------------------------------------------------------------------------
| Web Routes Frontend
|--------------------------------------------------------------------------
|
| Aquí es donde debe registrar las rutas web para el BACKEND de la aplicacion 
| Estas rutas son cargadas por el RouteServiceProvider dentro de un grupo que contiene
| el "web" middleware group.
|
*/

Route::group(array('prefix' => '/backend'), function(){

	Route::get('/', function(){
		return redirect()->route('backend.login');
	})->name('backend.home');

	// Rutas para pantalla de login de backend
	Route::get('/login', 'Backend\Auth\LoginController@login')->name('backend.login');
	Route::post('/login', 'Backend\Auth\LoginController@loginValidate')->name('backend.login.validate');

	// Ruta para reseteo de clave
	Route::post('/reset-password', 'Backend\Auth\LoginController@resetPassword')->name('backend.reset.password');

	// Ruta para cierre de sesion
	Route::get('/logout', 'Backend\Auth\LoginController@logout')->name('backend.logout');

	// Ruta para pantalla del home del backend una vez que el usuario se ha logueado
	Route::get('/dashboard', 'Backend\HomeController@dashboard')->name('backend.dashboard');

	// Rutas de perfil de usuario
	Route::get('/my-profile', 'Backend\Auth\ProfileController@profile')->name('backend.profile');
	Route::match(['PUT', 'PATCH'], '/my-profile', 'Backend\Auth\ProfileController@saveProfile')->name('backend.profile.save');

	/***********************************************************************************************************


			RUTAS PARA ADMINISTRACION DEL MODULO DE AUTENTICACION/AUTORIZACION DEL SISTEMA


	************************************************************************************************************/
	Route::group(array('prefix' => '/auth'), function(){
		
		/******************************************************************************************************


				RUTAS PARA ADMINISTRACION DE ROLES DEL SISTEMA


		*******************************************************************************************************/
		Route::group(array('prefix' => '/roles'), function(){
			// Ruta para ver la lista de roles del sistema
			Route::get('/list', 'Backend\Auth\RolesController@index')->name('backend.auth.roles.list');

			// Rutas para crear un nuevo rol en el sistema
			Route::get('/add', 'Backend\Auth\RolesController@create')->name('backend.auth.roles.create');
			Route::post('/add', 'Backend\Auth\RolesController@store')->name('backend.auth.roles.store');

			// Rutas para editar un rol de acuerdo a su ID
			Route::get('/edit/{sId?}', 'Backend\Auth\RolesController@edit')->name('backend.auth.roles.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Auth\RolesController@update')->name('backend.auth.roles.update');

			// Ruta para eliminar un rol en particular seleccionado por su ID
			Route::delete('/delete/{sId?}', 'Backend\Auth\RolesController@destroy')->name('backend.auth.roles.delete');
		});

		/*****************************************************************************************************


				RUTAS PARA ADMINISTRACION DE USUARIOS DEL SISTEMA


		******************************************************************************************************/
		Route::group(array('prefix' => '/users'), function(){
			// Ruta para ver la lista de usuarios del sistema
			Route::match(['GET', 'POST'], '/list', 'Backend\Auth\UsersController@index')->name('backend.auth.users.list');

			// Rutas para crear un nuevo usuario en el sistema
			Route::get('/add', 'Backend\Auth\UsersController@create')->name('backend.auth.users.create');
			Route::post('/add', 'Backend\Auth\UsersController@store')->name('backend.auth.users.store');

			// Rutas para editar un usuario de acuerdo a su ID
			Route::get('/edit/{sId?}', 'Backend\Auth\UsersController@edit')->name('backend.auth.users.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Auth\UsersController@update')->name('backend.auth.users.update');

			// Ruta para cambiar el estado de un usuario
			Route::get('/change-status/{sId?}', 'Backend\Auth\UsersController@changeStatus')->name('backend.auth.users.changeStatus');

			// Ruta para eliminar un usuario en particular seleccionado por su ID
			Route::delete('/delete/{sId?}', 'Backend\Auth\UsersController@destroy')->name('backend.auth.users.delete');
		});

	});


	/***********************************************************************************************************


			RUTAS PARA PARAMETRIZACION DEL SISTEMA


	************************************************************************************************************/
	Route::group(array('prefix' => '/parametrization'), function(){

		// Rutas para administracion de parametros de configuracion del sistema
		Route::get('/configuration', 'Backend\Parametrization\ConfigurationsController@edit')->name('backend.parametrization.configuration');
		Route::match(['PUT', 'PATCH'], '/configuration', 'Backend\Parametrization\ConfigurationsController@update')->name('backend.parametrization.configuration.save');

		/******************************************************************************************************


				RUTAS PARA ADMINISTRACION DE META TAGS


		*******************************************************************************************************/
		Route::group(array('prefix' => '/meta-tags'), function(){
			// Ruta para ver la lista de meta tags
			Route::get('/list', 'Backend\Parametrization\MetaTagsController@index')->name('backend.parametrization.meta-tags.list');

			// Rutas para crear un nuevo meta tag en el sistema
			Route::get('/add', 'Backend\Parametrization\MetaTagsController@create')->name('backend.parametrization.meta-tags.create');
			Route::post('/add', 'Backend\Parametrization\MetaTagsController@store')->name('backend.parametrization.meta-tags.store');

			// Rutas para editar un meta tag de acuerdo a su ID
			Route::get('/edit/{iId?}', 'Backend\Parametrization\MetaTagsController@edit')->name('backend.parametrization.meta-tags.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{iId?}', 'Backend\Parametrization\MetaTagsController@update')->name('backend.parametrization.meta-tags.update');

			// Ruta para eliminar un meta tag en particular seleccionado por su ID
			Route::delete('/delete/{iId?}', 'Backend\Parametrization\MetaTagsController@destroy')->name('backend.parametrization.meta-tags.delete');
		});


		/***********************************************************************************************************


				RUTAS PARA ADMINISRACION DE CATALOGOS DEL SISTEMA


		************************************************************************************************************/
		Route::group(array('prefix' => '/catalogs'), function(){

			/******************************************************************************************************


					RUTAS PARA ADMINISTRACION DE PROVINCIAS


			*******************************************************************************************************/
			Route::group(array('prefix' => '/states'), function(){
				// Ruta para ver la lista de provincias
				Route::match(['GET', 'POST'], '/list', 'Backend\Parametrization\Catalogs\StatesController@index')->name('backend.parametrization.catalogs.states.list');

				// Rutas para crear una nueva provincia en el sistema
				Route::get('/add', 'Backend\Parametrization\Catalogs\StatesController@create')->name('backend.parametrization.catalogs.states.create');
				Route::post('/add', 'Backend\Parametrization\Catalogs\StatesController@store')->name('backend.parametrization.catalogs.states.store');

				// Rutas para editar una provincia de acuerdo a su ID
				Route::get('/edit/{iId?}', 'Backend\Parametrization\Catalogs\StatesController@edit')->name('backend.parametrization.catalogs.states.edit');
				Route::match(['PUT', 'PATCH'], '/edit/{iId?}', 'Backend\Parametrization\Catalogs\StatesController@update')->name('backend.parametrization.catalogs.states.update');

				// Ruta para eliminar una provincia en particular seleccionado por su ID
				Route::delete('/delete/{iId?}', 'Backend\Parametrization\Catalogs\StatesController@destroy')->name('backend.parametrization.catalogs.states.delete');
			});

			/******************************************************************************************************


					RUTAS PARA ADMINISTRACION DE CIUDADES


			*******************************************************************************************************/
			Route::group(array('prefix' => '/cities'), function(){
				// Ruta para ver la lista de ciudades
				Route::match(['GET', 'POST'], '/cities/{sStateId?}', 'Backend\Parametrization\Catalogs\CitiesController@index')->name('backend.parametrization.catalogs.cities.list');

				// Rutas para crear una nueva ciudad en el sistema
				Route::get('/add/{sStateId?}', 'Backend\Parametrization\Catalogs\CitiesController@create')->name('backend.parametrization.catalogs.cities.create');
				Route::post('/add', 'Backend\Parametrization\Catalogs\CitiesController@store')->name('backend.parametrization.catalogs.cities.store');

				// Rutas para editar una ciudad de acuerdo a su ID
				Route::get('/edit/{sId?}', 'Backend\Parametrization\Catalogs\CitiesController@edit')->name('backend.parametrization.catalogs.cities.edit');
				Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Parametrization\Catalogs\CitiesController@update')->name('backend.parametrization.catalogs.cities.update');

				// Ruta para eliminar una ciudad en particular seleccionado por su ID
				Route::delete('/delete/{sId?}', 'Backend\Parametrization\Catalogs\CitiesController@destroy')->name('backend.parametrization.catalogs.cities.delete');
			});
		});
	});

});
