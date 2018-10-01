<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class AliadoFoto extends Model {
	    protected $table="aliados_fotos";

	    public function aliado() {
	    	return $this->belongsTo('App\Models\Aliado','aliado_id');
	    }
	}
