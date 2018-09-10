<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Libraries\Cart;
	use App\Models\Product;
	use App\Models\Size;
	use App\Models\ProductColor;
	use App\Models\ProductAmount;
	use App\Models\Purchase;
	use App\Models\PurchaseDetails;
	use App\Models\Category;
	use App\Models\CategorySize;
	use MP;
	use Auth;

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
		    	$category_size = CategorySize::where('category_id',$carrito[$n]['producto']['category_id'])->where('size_id',$carrito[$n]['talla'])->first();
		    	$carrito[$n]['producto']['amount'] = ProductAmount::where('product_color_id',$carrito[$n]['color'])
																	->where('category_size_id',$category_size->id)
																	->first();
	    	}
	    	return $carrito;
	    }

	    public function pay($data) {
	    	$carrito = $this->getCarrito();

	    	$compra = new Purchase;
	    		$compra->payment_type = $data['type'];
	    		$compra->user_id = Auth::id();
	    		$compra->transaction_code = $data['code'];
	    		$compra->transaction = $data['transaction'];
	    	$compra->save();

	    	foreach($carrito as $item) {
	    		$detalle = new PurchaseDetails;
	    			$detalle->purchase_id = $compra->id;
	    			$detalle->price = $item['producto']['price_1'];
	    			$detalle->product_amount_id = $item['producto']['amount'];
	    		$detalle->save();
	    	}
	    }

	    public function check() {
	    	$carrito = $this->getCarrito();

	    	foreach($carrito as $item) {
	    		if ($item['cantidad'] > $item['producto']['amount']['amount']) {
	    			return response()->json([
			    		'result' => false,
			    		'error' => Lang::get('Page.Carrito.NoCantidad').$item['producto']['amount']['amount']
			    	]);
	    		}
	    	}

	    	return response()->json([
	    		'result' => true
	    	]);
	    }

	    public function delete(Request $request) {
	    	Cart::delete($request->index);
	    	return response()->json([
	    		'result' => true,
	    		'carrito' => $this->getCarrito()
	    	]);
	    }
	}
