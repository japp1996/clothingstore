<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class CarritoController extends Controller {
	    
	    public function get() {
	    	return View('carrito.home');
	    }
	}
