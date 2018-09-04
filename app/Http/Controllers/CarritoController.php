<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Libraries\Cart;

	class CarritoController extends Controller {
	    
	    public function get() {
	    	$carrito = [];
	    	return View('carrito.home')->with(['carrito' => $carrito]);
	    }
	}
