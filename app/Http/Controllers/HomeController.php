<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Models\Nosotros;
	use App\Models\Condiciones;
	use App\Models\Slider;
	use App\Models\Pais;
	use Validator;
	use Mail;

	class HomeController extends Controller {
	    
	    public function get() {
	    	$slider = Slider::all();
	    	return View('home')->with(['slider' => $slider]);
	    }

	    public function nosotros() {
	    	$nosotros = Nosotros::orderBy('id','desc')->first();
	    	return View('nosotros')->with(['nosotros' => $nosotros]);
	    }

	    public function mundo() {
	    	return View('mundo');
	    }

	    public function aliados() {
	    	return View('aliados');
	    }

	    public function condiciones() {
	    	$condiciones = Condiciones::orderBy('id','desc')->first();
	    	return View('condiciones')->with(['condiciones' => $condiciones]);
	    }

	    public function getContacto() {
	    	$paises = Pais::orderBy('nombre','asc')->get()->pluck('nombre','nombre');
	    	return View('contacto')->with(['paises' => $paises]);
	    }

	    public function postContacto(Request $request) {
	    	$reglas = [
	    		'nombre' => 'required',
	    		'email' => 'required',
	    		'pais' => 'required',
	    		'mensaje' => 'required'
	    	];
	    	$mensajes = [
	    		'required' => 'El campo :attribute es requerido'
	    	];
	    	$atributos = [
	    		'nombre' => 'Nombre Completo',
	    		'email' => 'Correo Electrónico',
	    		'mensaje' => 'Mensaje',
	    		'pais' => 'País'
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
	}
