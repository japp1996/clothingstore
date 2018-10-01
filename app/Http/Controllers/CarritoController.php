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
	use App\Models\ExchangeRate;
	use App\Libraries\IpCheck;
	use MP;
	use Auth;
	use Lang;

	class CarritoController extends Controller {

		public $currency;
		public $exchange;

		public function __construct() {
			$this->exchange = ExchangeRate::orderBy('id','desc')->first();

			if (IpCheck::get() == 'VE') {
				$this->currency = '1';
			}
			else {
				$this->currency = '2';
			}
		}
	    
	    public function get() { 	
	    	$carrito = $this->getCarrito();

            foreach($carrito as $item) {
                if ($item['producto']['amount']['amount'] <= 0) {
                    Cart::delete($item);
                }
                if ($item['cantidad'] > $item['producto']['amount']['amount']) {
                    $item['cantidad'] = $item['producto']['amount']['amount'];
                    Cart::set($item);
                }
            }
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
		    	$carrito[$n]['producto']['color'] = ProductColor::find($carrito[$n]['color']);
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
	    		if (isset($data['code']))
	    			$compra->transaction_code = $data['code'];
	    		if (isset($data['transaction']))
	    			$compra->transaction = json_encode($data['transaction']);   		
	    		$compra->exchange_rate_id = $this->exchange->id;
	    		if (isset($data['transfer_id']))
	    			$compra->transfer_id = $data['transfer_id'];
	    	$compra->save();

	    	foreach($carrito as $item) {
	    		$detalle = new PurchaseDetails;
	    			$detalle->purchase_id = $compra->id;
	    			// $detalle->price = $this->getPrice(
	    			// 	$item['producto']['price_1'],
	    			// 	$item['producto']['price_2'],
	    			// 	$item['producto']['coin'],
	    			// 	$item['cantidad']
	    			// );
	    			$detalle->price = $item['cantidad'] >= 12 ? $item['producto']['price_2'] : $item['producto']['price_1'];
	    			$detalle->coin = $item['producto']['coin'];
	    			$detalle->product_amount_id = $item['producto']['amount']['id'];
	    			$detalle->quantity = $item['cantidad'];
	    		$detalle->save();

	    		$amount = ProductAmount::find($item['producto']['amount']['id']);
	    			$amount->amount = ($amount->amount - $item['cantidad']) < 0 ? 0 : $amount->amount - $item['cantidad'];
	    		$amount->save();
	    	}

	    	Cart::destroy();
	    }

	    public function getPrice($precio_1,$precio_2,$coin,$cantidad) {
	    	$precio = $cantidad >= 12 ? $precio_2 : $precio_1;
	    	$price = $precio;
			if ($coin == '1' && $this->currency == '2') {
				$price = $price / $this->exchange->change;
			}
			else if ($coin == '2' && $this->currency == '1') {
				$price = $price * $this->exchange->change;
			}
	    	return $price;
	    }

	    public function check() {
	    	$carrito = $this->getCarrito();

	    	foreach($carrito as $item) {
	    		if (Auth::check() && Auth::user()->type == '2' && $item['cantidad'] < 12) {
					return response()->json([
		    			'result' => false,
		    			'error' => Lang::get('Page.Carrito.PiezasName',['producto' => \App::getLocale() == 'es' ? $item['producto']['name'] : $item['producto']['name_english']])
		    		]);
	    		}
	    		
	    		if ($item['cantidad'] > $item['producto']['amount']['amount']) {
	    			return response()->json([
			    		'result' => false,
			    		'error' => Lang::get('Page.Carrito.NoCantidadProducto',[
			    			'cantidad' => $item['producto']['amount']['amount'],
			    			'producto' => \App::getLocale() == 'es' ? $item['producto']['name'] : $item['producto']['name_english']
			    		])
			    	]);
	    		}
	    	}

	    	return response()->json([
	    		'result' => true
	    	]);
	    }

	    public function delete(Request $request) {
	    	Cart::delete($request->item);
	    	return response()->json([
	    		'result' => true,
	    		'carrito' => $this->getCarrito()
	    	]);
	    }
	}
