<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class PurchaseDetails extends Model {
	    protected $table="purchase_details";
	    protected $appends = ['product','product_color','product_size'];

	    public function purchase() {
	    	return $this->belongsTo('App\Models\Purchase','purchase_id');
	    }

	    public function product_amount() {
	    	return $this->belongsTo('App\Models\ProductAmount','product_amount_id');
	    }

	    public function getProductAttribute($value) {
		    return $this->product_amount->product_color->product;
		}

		public function getProductColorAttribute($value) {
		    return $this->product_amount->product_color;
		}

		public function getProductSizeAttribute($value) {
		    return $this->product_amount->category_size->size;
		}
	}
