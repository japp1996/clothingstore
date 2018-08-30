<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Validator;
	use Auth;
	use Hash;
	use App\Models\Pais;
	use App\Models\Estado;

	class AuthController extends Controller {
	    
	    public function getLogin() {
	    	return View('auth.login');
	    }

	    public function postLogin(Request $request) {
	    	$reglas = [
	    	
	    	];
	    	$mensajes = [
	    	
	    	];
	    	$atributos = [
	    	
	    	];
	    	$validacion = Validator::make($request->all(),$reglas,$mensajes);
	    	$validacion->setAttributeNames($atributos);
	    	if ($validacion->fails()) {
	    		return response()->json([
	    			'result' => false,
	    			'error' => $validacion->messages()->first()
	    		]);
	    	}
	    	else {
	    		return response()->json([
	    			'result' => true
	    		]);
	    	}
	    }

	    public function getRegister() {
	    	$paises = Pais::orderBy('nombre','asc')->get()->pluck('nombre','id');
	    	$estados = Estado::orderBy('nombre','asc')->get();
	    	return View('auth.register')->with([
	    		'paises' => $paises,
	    		'estados' => $estados
	    	]);
	    }

	    public function postRegister(Request $request) {
	    	$reglas = [
	    	
	    	];
	    	$mensajes = [
	    	
	    	];
	    	$atributos = [
	    	
	    	];
	    	$validacion = Validator::make($request->all(),$reglas,$mensajes);
	    	$validacion->setAttributeNames($atributos);
	    	if ($validacion->fails()) {
	    		return response()->json([
	    			'result' => false,
	    			'error' => $validacion->messages()->first()
	    		]);
	    	}
	    	else {
	    		return response()->json([
	    			'result' => true
	    		]);
	    	}
	    }

	    public function logout() {
	    	Auth::logout();
	    	return Redirect('/');
	    }
	}
