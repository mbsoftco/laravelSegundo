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


Route::get('/', 'HomeController@index')->name('home')->middleware('auth');


Route::get('/apunte/{slug}', 'HomeController@index')->name('home');

//CONFIG JSON
Route::get('config/json/apunte-tipos', 'ConfigController@getApunteTiposJson')->name('config.json.apunte.tipos');
Route::get('config/json/ciclos', 'ConfigController@getCiclosJson')->name('config.json.ciclos');

//CONFIG JSON
Route::get('users/json/get', 'UsersController@getUser')->name('users.json.user');
Route::post('users/json/logout', 'UsersController@logout')->name('users.json.logout');

//CURSOS JSON
Route::get('cursos/json/lista', 'CursosController@listJson')->name('cursos.json.lista');

//APUNTES JSON
Route::get('apuntes/json/lista', 'ApuntesController@listJson')->name('apuntes.json.lista');
Route::get('apuntes/json/show/{slug}', 'ApuntesController@getBySlugJson')->name('apuntes.json.show');
Route::post('apuntes/json/store', 'ApuntesController@storeJson')->name('apuntes.json.store');
Route::get('apuntes/json/docentes/{id}', 'ApuntesController@getDocentesJson')->name('apuntes.json.docentes');

// ARCHIVOS

Route::group(['prefix' => 'archivo',  'middleware' => 'auth'], function(){
	
	Route::get('/pdf/{filename}/{token}', 'ArchivosController@getFileToken')->where('filename', '^[^/]+$')->name('archivo.pdf');

});



Route::get('archivo/thumbnail-callback/{id}', 'ArchivosController@thumbnailCallback')->name('archivo.thumbnail.callback');

Route::get('archivo/pdf-callback/{id}', 'ArchivosController@pdfCallback')->name('archivo.pdf.callback');

Route::get('archivo/{filename}', 'ArchivosController@getFile')->where('filename', '^[^/]+$')->name('archivo');
Route::get('archivo/thumbnail/{filename}', 'ArchivosController@getImage')->where('filename', '^[^/]+$')->name('archivo.thumbnail');


//APUNTES


Route::get('apuntes/{slug}', 'ApuntesController@show')->name('apuntes.show');

Route::group(['prefix' => 'apuntes',  'middleware' => 'auth'], function(){

	Route::get('/', 'ApuntesController@index')->name('apuntes.index');
	Route::post('/react/{id}', 'ApuntesController@react')->name('apuntes.react');

});



Route::group(['prefix' => 'mis-apuntes',  'middleware' => 'auth'], function(){
	Route::get('/', 'ApuntesController@listado')->name('misapuntes.index');	
	Route::get('/nuevo', 'ApuntesController@create')->name('misapuntes.create');
	Route::get('/edit/{id}', 'ApuntesController@edit')->name('misapuntes.edit');
	Route::delete('/delete/{id}', 'ApuntesController@destroy')->name('misapuntes.delete');
	Route::post('/store', 'ApuntesController@store')->name('misapuntes.store');
	Route::put('/update/{id}', 'ApuntesController@update')->name('misapuntes.update');

});

Route::get('/apunte-comentarios/{apunte_id}', 'ApunteComentariosController@index')->name('apunte.comentarios.index');	

Route::group(['prefix' => 'apunte-comentarios',  'middleware' => 'auth'], function(){
	Route::post('/store/{apunte_id}', 'ApunteComentariosController@store')->name('apunte.comentarios.store');
	Route::post('/destroy/{id}', 'ApunteComentariosController@destroy')->name('apunte.comentarios.destroy');
	Route::post('/react/{id}', 'ApunteComentariosController@react')->name('apunte.comentarios.react');

});

// LOGIN USER

Auth::routes();
Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

// ADMIN

Route::get('/admin-login', 'AdminAuth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin-login', 'AdminAuth\AdminLoginController@login');
Route::post('admin/logout', 'AdminAuth\AdminLoginController@logout')->name('admin.logout');



// Admin routes

Route::group(['prefix' => 'admin',  'middleware' => 'auth:admin'], function(){


	Route::get('/', 'Admin\AdminHomeController@index')->name('admin');
	Route::get('/apuntes', 'Admin\AdminApuntesController@index')->name('admin.apuntes');

	//Usuarios
	Route::resource('usuarios', 'Admin\AdminUsuariosController');
	Route::get('/usuarios/{order_field?}/{order_direction?}', 'Admin\AdminUsuariosController@index')->name('usuarios.index');

	//Universidades
	Route::resource('universidades', 'Admin\AdminUniversidadesController');
	Route::get('/universidades/{order_field?}/{order_direction?}', 'Admin\AdminUniversidadesController@index')->name('universidades.index');

	//Cursos

	Route::get('/cursos/{id}/edit', 'Admin\AdminCursosController@edit')->name('cursos.edit');
	

	Route::get('/cursos/{universidad_id?}/{order_field?}/{order_direction?}', 'Admin\AdminCursosController@index')->name('cursos.index');

	Route::resource('cursos', 'Admin\AdminCursosController');

});



//Registro
Route::get('terminar_sesiones', 'RegistroController@terminar_sesiones')->name('terminar_sesiones');
Route::get('registro', 'RegistroController@getRegistro')->name('registro');
Route::post('guardar-registro', 'RegistroController@RegistrarDatos')->name('guardar-registro');
Route::get('registro-perfil', 'RegistroController@getRegistroPerfil')->name('registro-perfil');
Route::post('guardar-perfil', 'RegistroController@RegistrarPerfil')->name('guardar-perfil');
Auth::routes();
Route::get('registro-social/{provider}', 'RegistroController@redirectToProvider')->name('registro.social');
Route::get('registro-social/{provider}/callback', 'RegistroController@handleProviderCallback');
Route::get('valida-registro-social', 'RegistroController@getValidaRegistroSocial')->name('valida-registro-social');
Route::post('guardar-clave-social', 'RegistroController@RegistrarClaveSocial')->name('guardar-clave-social');
Route::get('registro-cursos', 'RegistroController@getRegistroCursos')->name('registro-cursos');
Route::post('guardar-cursos', 'RegistroController@RegistrarCursos')->name('guardar-cursos');
Route::get('universidades', 'RegistroController@getUniversidades')->name('universidades');
Route::post('consultar-carrera', 'RegistroController@GetCarrera')->name('consultar-carrera');