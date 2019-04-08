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


Route::match(['GET', 'POST'], '/casos-de-corrupcion', 'Frontend\CorruptionCasesController@index')->name('corruption-cases');
Route::get('casos-de-corrupcion/json/{sCorruptionCaseId?}', 'Frontend\CorruptionCasesController@detail')->name('corruption-cases.detail-json');
Route::match(['GET', 'POST'], '/casos-de-corrupcion/{corruptionCaseSlug?}', 'Frontend\CorruptionCasesController@show')->name('corruption-cases.show');
Route::get('/casos-de-corrupcion/pdf/{corruptionCaseSlug?}', 'Frontend\CorruptionCasesController@downloadPdf')->name('corruption-cases.download-pdf');


Route::match(['GET', 'POST'], '/biblioteca-legal', 'Frontend\LegalLibraryController@index')->name('legal-library');

Route::match(['GET', 'POST'], '/historias-de-exito', 'Frontend\SuccessStoriesController@index')->name('success-stories');

Route::get('/estadisticas', 'Frontend\StatisticsController@index')->name('statistics');
Route::get('/estadisticas/excel', 'Frontend\StatisticsController@excel')->name('statistics.excel');


Route::match(['GET', 'POST'], '/{contentCategorySlug?}', 'Frontend\ContentCategoriesController@index')->name('content-category');
Route::match(['GET', 'POST'], '/{contentCategorySlug?}/{contentArticleSlug?}', 'Frontend\ContentCategoriesController@show')->name('content-article');

