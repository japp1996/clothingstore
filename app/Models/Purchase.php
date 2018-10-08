<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Purchase extends Model {
	    protected $table="purchases";

		public function user()
		{
			return $this->belongsTo(\App\User::class);
		}

	    public function details() {
	    	return $this->hasMany('App\Models\PurchaseDetails','purchase_id');
	    }

	    public function exchange() {
	    	return $this->belongsTo('App\Models\ExchangeRate','exchange_rate_id');
	    }

	    public function transfer() {
	    	return $this->belongsTo('App\Models\Transfer','transfer_id');
	    }
	}
