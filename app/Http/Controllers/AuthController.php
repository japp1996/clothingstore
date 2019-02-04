<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Validator;
	use Auth;
	use Hash;
	use App\Models\Pais;
	use App\Models\Estado;
	use App\Libraries\Cart;
	use App\User;
	use Lang;

	class AuthController extends Controller {
	    
	    public function getLogin() {
	    	return View('auth.login');
	    }

	    public function postLogin(Request $request) {
	    	$reglas = [
	    		'email' => 'required',
	    		'password' => 'required'
	    	];
	    	$atributos = [
	    		'email' => Lang::get('Controllers.Atributos.Email'),
	    		'password' => Lang::get('Controllers.Atributos.Password')
	    	];
	    	$validacion = Validator::make($request->all(),$reglas);
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
	    		if (Auth::attempt($data,true)) {
	    			if (Auth::user()->status != 1) {
	    				Auth::logout();
	    				return response()->json([
			    			'result' => false,
			    			'error' => Lang::get('Controllers.NoLogin')
			    		]);
	    			}
	    			if (Auth::user()->type == 2) {
	    				Cart::destroy();
	    			}
	    			if (Auth::user()->nivel == '1') {
	    				return response()->json([
			    			'result' => true,
			    			'url' => \URL('home')
			    		]);
	    			}
	    			else {
						return response()->json([
			    			'result' => true,
			    			'url' => \URL('home')
			    		]);
	    			}
	    		}
	    		else
	    			return response()->json([
	    				'result' => false,
	    				'error' => Lang::get('Controllers.Login')
	    			]);
	    	}
	    }

	    public function getRegister() {
	    	if (\App::getLocale() == 'es')
	    		$paises = Pais::orderBy('nombre','asc')->get()->pluck('nombre','id');
	    	else
	    		$paises = Pais::orderBy('english','asc')->get()->pluck('english','id');
	    	
	    	$estados = Estado::orderBy('nombre','asc')->get();
	    	return View('auth.register')->with([
	    		'paises' => $paises,
	    		'estados' => $estados
	    	]);
	    }

	    public function postRegister(Request $request) {
	    	$reglas = [
	    		'nombre' => 'required',
	    		'email' => 'required|email|unique:users,email',
	    		'type' => 'required',
	    		'identificacion' => 'required|numeric',
	    		'telefono' => 'required|numeric',
	    		'pais' => 'required',
	    		'estado' => 'required',
	    		'codigo' => 'required|numeric',
	    		'direccion' => 'required',
	    		'password' => 'required|confirmed'
	    	];
	    	$atributos = [
	    		'nombre' => Lang::get('Controllers.Atributos.Nombre'),
	    		'email' => Lang::get('Controllers.Atributos.Email'),
	    		'type' => Lang::get('Controllers.Atributos.Tipo'),
	    		'identificacion' => Lang::get('Controllers.Atributos.Identificacion'),
	    		'telefono' => Lang::get('Controllers.Atributos.Telefono'),
	    		'pais' => Lang::get('Controllers.Atributos.Pais'),
	    		'estado' => Lang::get('Controllers.Atributos.Estado'),
	    		'codigo' => Lang::get('Controllers.Atributos.Codigo'),
	    		'direccion' => Lang::get('Controllers.Atributos.Direccion'),
	    		'password' => Lang::get('Controllers.Atributos.Password')
	    	]; 
	    	$validacion = Validator::make($request->all(),$reglas);
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
		    			'error' => Lang::get('Controllers.Empresa')
		    		]);
	    		}

	    		$user = new User;
	    			$user->name = $request->nombre;
	    			$user->email = $request->email;
	    			$user->type = $request->type;
	    			$user->identificacion = $request->identificacion;
	    			$user->telefono = $request->telefono;
	    			$user->pais_id = $request->pais;
	    			$user->estado_id = $request->estado;
	    			$user->codigo = $request->codigo;
	    			$user->direccion = $request->direccion;
	    			$user->password = Hash::make($request->password);
	    			if ($request->type == '2') {
	    				$user->empresa = $request->empresa;
	    			}
	    		$user->save();

	    		return response()->json([
	    			'result' => true,
	    			'url' => \URL('login')
	    		]);
	    	}
	    }

	    public function logout() {
	    	if (Auth::check()) {
	    		if (Auth::user()->type == 2) {
		    		Cart::destroy();
		    	}
		    	Auth::logout();
	    	}	    	
	    	return Redirect('home');
	    }
	}
