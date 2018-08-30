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
	    		'email' => 'required',
	    		'password' => 'required'
	    	];
	    	$mensajes = [
	    		'required' => "El campo :attribute es requerido"
	    	];
	    	$atributos = [
	    		'email' => 'Correo Electrónico',
	    		'password' => 'Contraseña'
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
	    		$data = [
	    			'email' => $request->email,
	    			'password' => $request->password
	    		];
	    		if (Auth::attempt($data,true))
	    			if (Auth::user()->nivel == '1') {
	    				return response()->json([
			    			'result' => true,
			    			'url' => \URL('/')
			    		]);
	    			}
	    			else {
						return response()->json([
			    			'result' => true,
			    			'url' => \URL('/')
			    		]);
	    			}
	    		else
	    			return response()->json([
	    				'result' => 'error',
	    				'error' => "Correo Electrónico o Contraseña incorrectos"
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
	    		'nombre' => 'required',
	    		'email' => 'required',
	    		'type' => 'required',
	    		'identificacion' => 'required',
	    		'telefono' => 'required',
	    		'pais' => 'required',
	    		'estado' => 'required',
	    		'codigo' => 'required',
	    		'direccion' => 'required',
	    		'password' => 'required|confirmed'
	    	];
	    	$mensajes = [
	    		'required' => 'El campo :attribute es requerido',
	    		'confirmed' => 'Las contraseñas no coinciden'
	    	];
	    	$atributos = [
	    		'nombre' => 'Nombre Completo',
	    		'email' => 'Correo Electrónico',
	    		'type' => 'Tipo de Persona',
	    		'identificacion' => 'Identificación',
	    		'telefono' => 'Teléfono',
	    		'pais' => 'País',
	    		'estado' => 'Estado',
	    		'codigo' => 'Código Postal',
	    		'direccion' => 'Dirección',
	    		'password' => 'Contraseña'
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
	    		if ($request->type == '2' && ($request->empresa == '' || $request->empresa == null)) {
	    			return response()->json([
		    			'result' => false,
		    			'error' => "El campo Nombre de Empresa es requerido"
		    		]);
	    		}
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
