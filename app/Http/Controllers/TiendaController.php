<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\ProductAmount;
	use App\Libraries\Cart;
	use Validator;
	use Lang;

	class TiendaController extends Controller {
	    
	    public function get() {
	    	return View('tienda.home');
	    }

	    public function ver($id) {
			return View('tienda.ver')->with(['id' => $id]);
	    }

	    public function add(Request $request) {
	    	$reglas = [
	    		'talla' => 'required',
	    		'color' => 'required'
	    	];
	    	$atributos = [
	    		'talla' => Lang::get('Controllers.Atributos.Talla'),
	    		'color' => Lang::get('Controllers.Atributos.Color')
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
	    		$item = [
	    			'cantidad' => $request->cantidad,
	    			'id' => $request->id,
	    			'talla' => $request->talla,
	    			'color' => $request->color
	    		];
	    		Cart::set($item);		
		    	return response()->json([
		    		'result' => true,
		    		'carrito' => Cart::get()
		    	]);
		    }
	    }

	    public function getProducto(Request $request) {
	    	$producto = Product::with(['designs','collections','images','categories' => function($q) {
	    		$q->with(['sizes']);
	    	},'colors'])->where('status','1')->where('id',$request->id)->first();
			return response()->json([
				'result' => true,
				'producto' => $producto,
				'carrito' => Cart::get()
			]);
	    }

	    public function ajax(Request $request) {
	    	$productos = Product::with(['designs','collections','images' => function($q) {
	    		$q->where('main','1')->first();
	    	},'categories' => function($q) {
	    		$q->with(['sizes']);
	    	},'colors'])->where('status','1')->paginate(8);

	    	return response()->json([
	    		'result' => true,
	    		'productos' => $productos,
	    		'carrito' => Cart::get()
	    	]);
	    }
	}
