<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\User;

	class PerfilController extends Controller {
	    
	    public function get() {
	    	return View('perfil.home');
	    }
	}
