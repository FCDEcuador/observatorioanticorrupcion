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

			// Ruta para validar si el email que se esta ingresando de un usuario existe o no
			Route::match(['GET', 'POST'], '/validate/{sId?}', 'Backend\Auth\UsersController@validateUser')->name('backend.auth.users.validate');

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


		/****************************************************************************************************


				RUTAS PARA ADMINISRACION DE CATALOGOS DEL SISTEMA


		*****************************************************************************************************/
		Route::group(array('prefix' => '/catalogs'), function(){

			/*************************************************************************************************


					RUTAS PARA ADMINISTRACION DE PROVINCIAS


			*************************************************************************************************/
			Route::group(array('prefix' => '/provinces'), function(){
				// Ruta para ver la lista de provincias
				Route::match(['GET', 'POST'], '/list', 'Backend\Parametrization\Catalogs\ProvincesController@index')->name('backend.parametrization.catalogs.provinces.list');

				// Rutas para crear una nueva provincia en el sistema
				Route::get('/add', 'Backend\Parametrization\Catalogs\ProvincesController@create')->name('backend.parametrization.catalogs.provinces.create');
				Route::post('/add', 'Backend\Parametrization\Catalogs\ProvincesController@store')->name('backend.parametrization.catalogs.provinces.store');

				// Rutas para editar una provincia de acuerdo a su ID
				Route::get('/edit/{iId?}', 'Backend\Parametrization\Catalogs\ProvincesController@edit')->name('backend.parametrization.catalogs.provinces.edit');
				Route::match(['PUT', 'PATCH'], '/edit/{iId?}', 'Backend\Parametrization\Catalogs\ProvincesController@update')->name('backend.parametrization.catalogs.provinces.update');

				// Ruta para eliminar una provincia en particular seleccionado por su ID
				Route::delete('/delete/{iId?}', 'Backend\Parametrization\Catalogs\ProvincesController@destroy')->name('backend.parametrization.catalogs.provinces.delete');
			});

			
		});
	});


	/***********************************************************************************************************


			RUTAS PARA ADMINISTRACION DEL MODULO DE CONTENIDO DEL SISTEMA


	************************************************************************************************************/
	
	Route::group(array('prefix' => '/content'), function(){
		
		/*************************************************************************************************************


			RUTAS PARA ADMINISTRACION DE ITEMS DE MENU


		***************************************************************************************************************/
		Route::group(array('prefix' => '/menu-items'), function(){
			// Ruta para ver la lista de items de menu
			Route::get('/list/{sMenuId?}/{sMenuItemId?}', 'Backend\Content\MenuItemsController@index')->name('backend.content.menu-items.list');

			Route::get('/list-json/{sMenuId?}', 'Backend\Content\MenuItemsController@listJson')->name('backend.content.menu-items.list.json');

			// Rutas para crear un nuevo item de menu
			Route::get('/add/{sMenuId?}/{sMenuItemId?}', 'Backend\Content\MenuItemsController@create')->name('backend.content.menu-items.create');
			Route::post('/add', 'Backend\Content\MenuItemsController@store')->name('backend.content.menu-items.store');

			// Rutas para editar un item de menu de acuerdo a su ID
			Route::get('/edit/{iId?}', 'Backend\Content\MenuItemsController@edit')->name('backend.content.menu-items.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{iId?}', 'Backend\Content\MenuItemsController@update')->name('backend.content.menu-items.update');

			// Ruta para eliminar un item de menu en particular seleccionada por su ID
			Route::delete('/delete/{iId?}', 'Backend\Content\MenuItemsController@destroy')->name('backend.content.menu-items.delete');

			// Ruta para cambiar el estado de un item de menu
			Route::get('/change-status/{iId?}', 'Backend\Content\MenuItemsController@changeStatus')->name('backend.content.menu-items.changeStatus');
		});


		/******************************************************************************************************


				RUTAS PARA ADMINISTRACION DE CATEGORIAS O SECCIONES DE CONTENIDO


		*******************************************************************************************************/
		Route::group(array('prefix' => '/content-categories'), function(){
			// Ruta para ver la lista de categorias o secciones de contenido
			Route::match(['GET', 'POST'], '/list/{sSuperContentCategoryId?}', 'Backend\Content\ContentCategoriesController@index')->name('backend.content.content-categories.list');

			// Rutas para crear una nueva categoria o seccion de contenido
			Route::get('/add/{sSuperContentCategoryId?}', 'Backend\Content\ContentCategoriesController@create')->name('backend.content.content-categories.create');
			Route::post('/add', 'Backend\Content\ContentCategoriesController@store')->name('backend.content.content-categories.store');

			// Rutas para editar una categoria o seccion de contenido acuerdo a su ID
			Route::get('/edit/{sId?}', 'Backend\Content\ContentCategoriesController@edit')->name('backend.content.content-categories.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Content\ContentCategoriesController@update')->name('backend.content.content-categories.update');

			// Ruta para eliminar una categoria o seccion de contenido en particular seleccionada por su ID
			Route::delete('/delete/{sId?}', 'Backend\Content\ContentCategoriesController@destroy')->name('backend.content.content-categories.delete');
		});

		/******************************************************************************************************


				RUTAS PARA ADMINISTRACION DE ARTICULOS DE CONTENIDO


		*******************************************************************************************************/
		Route::group(array('prefix' => '/content-articles'), function(){
			// Ruta para ver la lista de articulos de contenido
			Route::match(['GET', 'POST'], '/list', 'Backend\Content\ContentArticlesController@index')->name('backend.content.content-articles.list');

			// Rutas para crear un nuevo articulo de contenido
			Route::get('/add', 'Backend\Content\ContentArticlesController@create')->name('backend.content.content-articles.create');
			Route::post('/add', 'Backend\Content\ContentArticlesController@store')->name('backend.content.content-articles.store');

			// Rutas para editar un articulo de contenido acuerdo a su ID
			Route::get('/edit/{sId?}', 'Backend\Content\ContentArticlesController@edit')->name('backend.content.content-articles.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Content\ContentArticlesController@update')->name('backend.content.content-articles.update');

			// Ruta para cambiar el estado de un articulo de contenido
			Route::get('/change-status/{sId?}', 'Backend\Content\ContentArticlesController@changeStatus')->name('backend.content.content-articles.changeStatus');

			// Ruta para eliminar un articulo de contenido en particular seleccionada por su ID
			Route::delete('/delete/{sId?}', 'Backend\Content\ContentArticlesController@destroy')->name('backend.content.content-articles.delete');
		});


		/******************************************************************************************************


				RUTAS PARA ADMINISTRACION DE HISTORIAS DE EXITO


		*******************************************************************************************************/
		Route::group(array('prefix' => '/success-stories'), function(){
			// Ruta para ver la lista de links externos del sistema
			Route::match(['GET', 'POST'], '/list', 'Backend\Content\SuccessStoriesController@index')->name('backend.content.success-stories.list');

			// Rutas para crear una nueva Historia de Exito
			Route::get('/add', 'Backend\Content\SuccessStoriesController@create')->name('backend.content.success-stories.create');
			Route::post('/add', 'Backend\Content\SuccessStoriesController@store')->name('backend.content.success-stories.store');

			// Rutas para editar una historia de exito acuerdo a su ID
			Route::get('/edit/{sId?}', 'Backend\Content\SuccessStoriesController@edit')->name('backend.content.success-stories.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{sId?}', 'Backend\Content\SuccessStoriesController@update')->name('backend.content.success-stories.update');

			// Ruta para cambiar el estado de una historia de exito
			Route::get('/change-status/{sId?}', 'Backend\Content\SuccessStoriesController@changeStatus')->name('backend.content.success-stories.changeStatus');

			// Ruta para eliminar una historia de exito en particular seleccionada por su ID
			Route::delete('/delete/{sId?}', 'Backend\Content\SuccessStoriesController@destroy')->name('backend.content.success-stories.delete');
		});


		/*************************************************************************************************


				RUTAS PARA ADMINISTRACION DE CASOS DE CORRUPCION


		*************************************************************************************************/

		Route::group(array('prefix' => '/corruption-cases'), function(){
			// Ruta para ver la lista de provincias
			Route::match(['GET', 'POST'], '/list', 'Backend\Content\CorruptionCasesController@index')->name('backend.content.corruption-cases.list');

			Route::get('/case-stage-details/{sCaseStageId?}', 'Backend\Content\CorruptionCasesController@caseStageDetails')->name('backend.content.corruption-cases.case-stage-details');

			// Rutas para crear una nueva provincia en el sistema
			Route::get('/add', 'Backend\Content\CorruptionCasesController@create')->name('backend.content.corruption-cases.create');
			Route::post('/add', 'Backend\Content\CorruptionCasesController@store')->name('backend.content.corruption-cases.store');

			// Rutas para editar una provincia de acuerdo a su ID
			Route::get('/edit/{iId?}', 'Backend\Content\CorruptionCasesController@edit')->name('backend.content.corruption-cases.edit');
			Route::match(['PUT', 'PATCH'], '/edit/{iId?}', 'Backend\Content\CorruptionCasesController@update')->name('backend.content.corruption-cases.update');

			// Ruta para eliminar una provincia en particular seleccionado por su ID
			Route::delete('/delete/{iId?}', 'Backend\Content\CorruptionCasesController@destroy')->name('backend.content.corruption-cases.delete');

			Route::get('/delete-what-happened/{sWhatHappenedId}', 'Backend\Content\CorruptionCasesController@destroyWH')->name('backend.content.corruption-cases.deleteWH');
		});
	});

});
