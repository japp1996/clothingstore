<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Purchase extends Model {
	    protected $table="purchases";

	    public function details() {
	    	return $this->hasMany('App\Models\PurchaseDetails','purchase_id');
	    }
	}
