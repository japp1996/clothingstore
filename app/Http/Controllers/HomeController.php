<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Models\Nosotros;
	use App\Models\Condiciones;
	use App\Models\Slider;
	use App\Models\Pais;
	use App\Models\Aliado;
	use Validator;
	use Mail;
	use Lang;

	class HomeController extends Controller {
	    
	    public function get() {
	    	$slider = Slider::all();
	    	return View('home')->with(['slider' => $slider]);
	    }

	    public function nosotros() {
	    	$nosotros = Nosotros::orderBy('id','desc')->first();
	    	return View('nosotros')->with(['nosotros' => $nosotros]);
	    }

	    public function aliados() {
	    	$aliados = Aliado::with(['fotos'])->paginate(6);
	    	return View('aliados')->with(['aliados' => $aliados]);
	    }

	    public function condiciones() {
	    	$condiciones = Condiciones::orderBy('id','desc')->first();
	    	return View('condiciones')->with(['condiciones' => $condiciones]);
	    }

	    public function intro() {
	    	return View('intro');
	    }

	    public function getContacto() {
	    	$paises = Pais::orderBy('nombre','asc')->get()->pluck('nombre','nombre');
	    	return View('contacto')->with(['paises' => $paises]);
	    }

	    public function postContacto(Request $request) {
	    	$reglas = [
	    		'nombre' => 'required',
	    		'email' => 'required|email',
	    		'pais' => 'required',
	    		'mensaje' => 'required'
	    	];
	    	$atributos = [
	    		'nombre' => Lang::get('Controllers.Atributos.Nombre'),
	    		'email' => Lang::get('Controllers.Atributos.Email'),
	    		'mensaje' => Lang::get('Controllers.Atributos.Mensaje'),
	    		'pais' => Lang::get('Controllers.Atributos.Pais')
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
	    			'nombre' => $request->nombre,
	    			'email' => $request->email,
	    			'pais' => $request->pais,
	    			'mensaje' => $request->mensaje
	    		];

	    		Mail::send('emails.contacto',$data, function ($m) use ($request) {
		            $m->to(env('MAIL_CONTACTO'))
		              ->from($request->email,$request->nombre)
		              ->subject(Lang::get('Page.Contacto.Correo.Title').' | Wará');
		        });

	    		return response()->json([
	    			'result' => true
	    		]);
	    	}
	    }
	}
