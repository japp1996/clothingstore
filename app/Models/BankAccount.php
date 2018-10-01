<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class BankAccount extends Model {
	    protected $table="bank_accounts";

	    public function bank() {
	    	return $this->belongsTo('App\Models\Bank','bank_id');
	    }

	    public function getFullNameAttribute() {
	    	return $this->bank->name.' - '.$this->name.' - '.$this->number;
	    }
	}
