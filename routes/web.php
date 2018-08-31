<?php

	Route::get('/','HomeController@intro')->middleware('intro');
	Route::get('home','HomeController@get');
	Route::get('nosotros','HomeController@nosotros')->middleware('active:1');

	Route::group(['middleware' => 'active:2'],function() {
		Route::get('mundo','BlogController@get');
		Route::get('mundo/view/{id}','BlogController@view');
	});
	
	Route::get('aliados','HomeController@aliados')->middleware('active:4');
	Route::get('condiciones','HomeController@condiciones');
	Route::get('contacto','HomeController@getContacto');
	Route::post('contacto','HomeController@postContacto');

	// Tienda
	Route::group(['middleware' => 'active:3'],function() {

		Route::get('tienda','TiendaController@get');
	});
	
	// Carrito
	Route::group(['middleware' => 'active:5'],function() {

		Route::get('carrito','CarritoController@get');
	});

	// Perfil
	Route::group(['middleware' => ['active:6','auth']],function() {

		Route::get('perfil','PerfilController@get');
		Route::post('perfil','PerfilController@post');
		Route::post('password','PerfilController@password');
	});	

	// Auth
	Route::group(['middleware' => 'login'],function() {

		Route::get('login','AuthController@getLogin');
		Route::post('login','AuthController@postLogin');
		Route::get('register','AuthController@getRegister');
		Route::post('register','AuthController@postRegister');
	});
	
	Route::get('logout','AuthController@logout');

	// Lang
	Route::get('lang/{lang}','LangController@change');