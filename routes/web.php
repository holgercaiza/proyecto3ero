<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function() {

    Route::resource('pensiones', 'PensionesController');
    Route::resource('usuarios', 'UsuariosController');
    Route::post('pensiones.buscar', 'PensionesController@index')->name('pensiones.buscar');
    Route::post('pensiones/create/search_student', 'PensionesController@search_student');
    Route::post('pensiones/{pag_id}/edit/search_student', 'PensionesController@search_student');
    Route::get('reportes', 'PensionesController@reportes')->name('reportes');
    Route::post('reportes', 'PensionesController@reportes')->name('reportes');
    Route::get('/pensiones.editpag/{pag_id}', 'PensionesController@edit')->name('pensiones.editpag');
    Route::get('/profile/{usr_id}', 'UsuariosController@profile')->name('profile');
    
    Route::resource('cargar_datos', 'CargarDatosController');
    
    Route::post('/elimina_registro_pago', 'CargarDatosController@elimina_registro_pago')->name('elimina_registro_pago');
    
    Route::get('/generar_ordenes', 'PensionesController@generar_ordenes')->name('generar_ordenes');

    Route::post('/generar_ordenes', 'PensionesController@generar_ordenes')->name('generar_ordenes');

    Route::get('/ver_ordenes_generadas/{sec}', 'PensionesController@ver_ordenes_generadas')->name('ver_ordenes_generadas');
    Route::get('/excel_ordenes_generadas/{sec}', 'PensionesController@excel_ordenes_generadas')->name('excel_ordenes_generadas');
    Route::post('/elimina_ordenes_generadas', 'PensionesController@elimina_ordenes_generadas')->name('elimina_ordenes_generadas');


});