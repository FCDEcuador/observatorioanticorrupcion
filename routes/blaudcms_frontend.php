<?php

/*
|--------------------------------------------------------------------------
| Web Routes Frontend
|--------------------------------------------------------------------------
|
| Aquí es donde debe registrar las rutas web para el FRONTEND de la aplicacion 
| Estas rutas son cargadas por el RouteServiceProvider dentro de un grupo que contiene
| el "web" middleware group.
|
*/

Route::get('/', 'Frontend\HomeController@home')->name('home');

Route::get('/sobre-el-observatorio', 'Frontend\StaticPagesController@about')->name('about-us');
Route::get('/contactenos', 'Frontend\StaticPagesController@contact')->name('contact-us');
Route::post('/contactenos','Frontend\StaticPagesController@contactSend')->name('contact-us.send');

Route::get('/casos-de-corrupcion', 'Frontend\CorruptionCasesController@index')->name('corruption-cases');
Route::get('/casos-de-corrupcion/{corruptionCaseSlug?}', 'Frontend\CorruptionCasesController@show')->name('corruption-cases.show');

Route::get('/biblioteca-legal', 'Frontend\LegalLibraryController@index')->name('legal-library');
Route::get('/biblioteca-legal/{legalLibrarySlug?}', 'Frontend\LegalLibraryController@show')->name('legal-library.show');

Route::get('/historias-de-exito', 'Frontend\SuccessStoriesController@index')->name('success-stories');

Route::get('/{contentCategorySlug?}', 'Frontend\ContentCategories@index')->name('content-category');
Route::get('/{contentCategorySlug?}/{contentArticleSlug?}', 'Frontend\ContentCategories@show')->name('content-article');

