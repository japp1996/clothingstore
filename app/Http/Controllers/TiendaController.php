<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class TiendaController extends Controller {
	    
	    public function get() {
	    	return View('tienda.home');
	    }

	    public function ajax(Request $request) {
	    	return response()->json([
	    		'result' => true
	    	]);
	    }
	}
