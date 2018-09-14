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
	Route::get('terminos','HomeController@terminos');
	Route::get('contacto','HomeController@getContacto');
	Route::post('contacto','HomeController@postContacto');

	// Tienda
	Route::group(['middleware' => 'active:3'],function() {

		Route::get('tienda','TiendaController@get');
		Route::post('tienda/ajax','TiendaController@ajax');
		Route::get('tienda/ver/{id}','TiendaController@ver');
		Route::post('tienda/get','TiendaController@getProducto');
		Route::post('tienda/add','TiendaController@add');
	});
	
	// Carrito
	Route::group(['middleware' => 'active:5'],function() {

		Route::get('carrito','CarritoController@get');
		Route::post('carrito/ajax','CarritoController@ajax');
		Route::post('carrito/delete','CarritoController@delete');
		Route::post('carrito/check','CarritoController@check');
		Route::get('mercadopago','MPController@create');
		Route::get('transferencia','TransferenciaController@get');
		Route::post('transferencia','TransferenciaController@post');
		Route::get('carrito/response','MPController@response');
	});

	// Perfil
	Route::group(['middleware' => ['active:6','auth']],function() {

		Route::get('perfil','PerfilController@get');
		Route::post('perfil','PerfilController@post');
		Route::post('password','PerfilController@password');
		Route::post('perfil/pedidos','PerfilController@pedidos');
	});	

	// Auth
	Route::group(['middleware' => 'login'],function() {

		Route::get('login','AuthController@getLogin');
		Route::post('login','AuthController@postLogin');
		Route::get('register','AuthController@getRegister');
		Route::post('register','AuthController@postRegister');

		Route::get('recuperar','ResetController@get');
		Route::post('recuperar/send','ResetController@send');
		Route::post('recuperar/codigo','ResetController@codigo');
		Route::post('recuperar/reenviar','ResetController@reenviar');
		Route::post('recuperar/recuperar','ResetController@recuperar');
	});

	Route::group(['middleware' => 'auth'],function() {
		Route::get('payment', [
			'as' => 'payment',
			'uses' => 'PaypalController@postPayment',
		]);

		Route::get('payment/status', [
			'as' => 'payment.status',
			'uses' => 'PaypalController@getPaymentStatus',
		]);	
	});
	
	Route::get('logout','AuthController@logout');

	Route::get('destroy',function() {
		\App\Libraries\Cart::destroy();
		return Back();
	});

	// Lang
	Route::get('lang/{lang}','LangController@change');

	// Admin
	
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
		// Home
		Route::get('/', 'AdminController@index');
		Route::post('login', 'AuthController@singIn');
		
		Route::group(['middleware' => 'Auth'], function() {
			Route::get('home', 'AdminController@home');
			// Sizes			
			Route::resource('sizes', 'SizeController');
			Route::get('sizes-all', 'SizeController@all');
			// Categories			
			Route::resource('categories', 'CategoryController');			
			// Collection
			Route::resource('collections', 'CollectionController');
			// Desigs			
			Route::resource('designs', 'DesignController');
			Route::get('designs-all', 'DesignController@allData');
			// Products			
			Route::resource('products', 'ProductController');
			
		});
	});
	