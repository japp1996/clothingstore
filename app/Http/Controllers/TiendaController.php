<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Models\Product;
	use App\Models\ProductAmount;
	use App\Models\Category;
	use App\Models\CategorySize;
	use App\Libraries\Cart;
	use App\Models\Filter;
	use Validator;
	use Lang;
	use Auth;
	use App\Models\Wholesaler;

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
	    // 		if (Auth::check() && Auth::user()->type == '2' && $request->cantidad < 12) {
					// return response()->json([
		   //  			'result' => false,
		   //  			'error' => Lang::get('Page.Carrito.Piezas')
		   //  		]);
	    // 		}

	    		$item = [
	    			'cantidad' => $request->cantidad,
	    			'id' => $request->id,
	    			'talla' => $request->talla,
	    			'color' => $request->color
	    		];

	    		$producto = Product::find($request->id);

	    		$category_size = CategorySize::where('category_id',$producto->category_id)->where('size_id',$request->talla)->first();
		    	$producto->amount = ProductAmount::where('product_color_id',$request->color)
																	->where('category_size_id',$category_size->id)
																	->first();

				if ($request->cantidad > $producto->amount->amount) {
					return response()->json([
			    		'result' => false,
			    		'error' => Lang::get('Page.Carrito.NoCantidad').$producto->amount->amount
		    		]);
				}

	    		Cart::set($item);		
		    	return response()->json([
		    		'result' => true,
		    		'carrito' => Cart::get()
		    	]);
		    }
	    }

	    public function getProducto(Request $request) {
	    	if (!Auth::check() || (Auth::check() && Auth::user()->type == 1)) {
	    		$producto = Product::with(['designs','collections','images','categories' => function($q) {
		    		$q->with(['sizes']);
		    	},'colors'])->where('status','1')->where('id',$request->id)->first();
	    	}
	    	else {
	    		$producto = Wholesaler::with(['images'])->where('status','1')->where('id',$request->id)->first();
	    	}	    	
			return response()->json([
				'result' => true,
				'producto' => $producto,
				'carrito' => Cart::get()
			]);
	    }

	    public function ajax(Request $request) {
	    	if (!Auth::check() || (Auth::check() && Auth::user()->type == 1)) {
		    	$query = Product::with(['designs','collections','images','categories' => function($q) {
		    		$q->with(['sizes']);
		    	},'colors'])->whereHas('categories',function($q) use ($request) {
		    		if ($request->has('catalogo')) {
		    			$q->whereHas('filters',function($q) use ($request) {
		    				$q->where('filters.id',$request->catalogo);
		    			});
		    		}
		    	});
		    }
		    else {
		    	$query = Wholesaler::with(['images']);
		    }

	    	if ($request->has('catalogo')) {
	    		if ($request->has('categorias') && count($request->categorias) > 0) {
		    		$query->whereIn('category_id',$request->categorias);
		    	}
	    	}    	

	    	$productos = $query->where('status','1')->paginate(8);

	    	$categorias = Category::orderBy('name','asc')->with(['filters'])->get();
	    	$filtros = Filter::orderBy('name','asc')->with(['categories'])->get();

	    	return response()->json([
	    		'result' => true,
	    		'productos' => $productos,
	    		'carrito' => Cart::get(),
	    		'categorias' => $categorias,
	    		'filtros' => $filtros
	    	]);
	    }
	}
