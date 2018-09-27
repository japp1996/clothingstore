<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Transfer extends Model {
	    protected $table="transfers";

	    public function to() {
	    	return $this->belongsTo('App\Models\BankAccount','to_bank_id');
	    }

	    public function from() {
	    	return $this->belongsTo('App\Models\Bank','from_bank_id');
	    }

	    public function user() {
	    	return $this->belongsTo('App\User','user_id');
	    }
	}
