<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\User;
	use App\Models\Pais;
	use App\Models\Estado;
	use Auth;
	use Validator;
	use Hash;

	class PerfilController extends Controller {
	    
	    public function get() {
	    	$user = User::find(Auth::user()->id);
	    	$paises = Pais::orderBy('nombre','asc')->get()->pluck('nombre','id');
	    	$estados = Estado::orderBy('nombre','asc')->get();
	    	return View('perfil.home')->with([
	    		'user' => $user,
	    		'paises' => $paises,
	    		'estados' => $estados
	    	]);
	    }

	    public function post(Request $request) {
	    	$reglas = [
	    		'name' => 'required',
	    		'email' => 'required|email',
	    		'pais_id' => 'required',
	    		'estado_id' => 'required',
	    		'telefono' => 'required',
	    		'codigo' => 'required'
	    	];
	    	$mensajes = [
	    		'required' => 'El campo :attribute es requerido',
	    		'email' => 'El correo electrónico no es válido'
	    	];
	    	$atributos = [
	    		'name' => 'Nombre Completo',
	    		'email' => 'Correo Electrónico',
	    		'pais_id' => 'País',
	    		'estado_id' => 'Estado',
	    		'telefono' => 'Teléfono',
	    		'codigo' => 'Código Postal'
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
	    		$user = User::find(Auth::id());
	    			$user->email = $request->email;
	    			$user->name = $request->name;
	    			$user->pais_id = $request->pais_id;
	    			$user->estado_id = $request->estado_id;
	    			$user->codigo = $request->codigo;
	    			$user->telefono = $request->telefono;
	    		$user->save();

	    		return response()->json([
	    			'result' => true
	    		]);
	    	}
	    }

	    public function password(Request $request) {
	    	$reglas = [
	    		'password' => 'required|confirmed'
	    	];
	    	$mensajes = [
	    		'required' => 'El campo :attribute es requerido',
	    		'confirmed' => 'Las contraseñas no coinciden'
	    	];
	    	$atributos = [
	    		'password' => 'Contraseña Nueva'
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
	    		$user = User::find(Auth::id());
	    		if (!Hash::check($request->old_password,$user->password))
	    			return response()->json([
		    			'result' => false,
		    			'error' => "La contraseña actual no coincide"
		    		]);
	    			$user->password = Hash::make($request->password);
	    		$user->save();

	    		return response()->json([
	    			'result' => true
	    		]);
	    	}
	    }
	}
