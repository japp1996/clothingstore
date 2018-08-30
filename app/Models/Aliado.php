<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Aliado extends Model {
	    protected $table="aliados";

	    public function fotos() {
	    	return $this->hasMany('App\Models\AliadoFoto','aliado_id');
	    }
	}
