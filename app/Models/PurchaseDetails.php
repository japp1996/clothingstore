<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class PurchaseDetails extends Model {
	    protected $table="purchase_details";

	    public function purchase() {
	    	return $this->belongsTo('App\Models\Purchase','purchase_id');
	    }

	    public function product_amount() {
	    	return $this->belongsToMany(ProductAmount::class, 'product_amount_id');
	    }

	    public function product() {
	    	return $this->product_amount()->product_color()->product();
	    }
	}
