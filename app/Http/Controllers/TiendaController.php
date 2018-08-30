<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;

	class TiendaController extends Controller {
	    
	    public function get() {
	    	return View('tienda.home');
	    }
	}
