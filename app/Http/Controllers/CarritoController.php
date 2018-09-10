<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Libraries\Cart;
	use App\Models\Product;
	use App\Models\Size;
	use App\Models\ProductColor;
	use MP;

	class CarritoController extends Controller {
	    
	    public function get() { 	
	    	return View('carrito.home');
	    }	    	

	    public function ajax(Request $request) {
	    	$carrito = $this->getCarrito();
	    	return response()->json([
	    		'result' => true,
	    		'carrito' => $carrito
	    	]);
	    }

	    public function getCarrito() {
	    	$carrito = Cart::get();
	    	for($n = 0; $n < count($carrito); $n++) {
	    		$carrito[$n]['producto'] = Product::with(['designs','collections','images','categories' => function($q) {
		    		$q->with(['sizes']);
		    	},'colors'])->where('status','1')->where('id',$carrito[$n]['id'])->first();

		    	$carrito[$n]['producto']['talla'] = Size::find($carrito[$n]['talla'])->first();
		    	$carrito[$n]['producto']['color'] = ProductColor::find($carrito[$n]['color'])->first();
	    	}
	    	return $carrito;
	    }

	    public function delete(Request $request) {
	    	Cart::delete($request->index);
	    	return response()->json([
	    		'result' => true,
	    		'carrito' => $this->getCarrito()
	    	]);
	    }
	}
