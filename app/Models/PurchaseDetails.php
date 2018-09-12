<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class PurchaseDetails extends Model {
	    protected $table="purchase_details";
	    protected $appends = ['product'];

	    public function purchase() {
	    	return $this->belongsTo('App\Models\Purchase','purchase_id');
	    }

	    public function product_amount() {
	    	return $this->belongsTo('App\Models\ProductAmount','product_amount_id');
	    }

	    public function getProductAttribute($value) {
		    return $this->product_amount->product_color->product;
		}
	}
