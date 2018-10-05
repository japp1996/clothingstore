<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Auth;

	class PurchaseDetails extends Model {
	    protected $table="purchase_details";
	    protected $appends = ['product','product_color','product_size'];

	    public function purchase() {
	    	return $this->belongsTo('App\Models\Purchase','purchase_id');
	    }

	    public function product_amount() {
	    	return $this->belongsTo('App\Models\ProductAmount','product_amount_id');
	    }

	    public function wholesaler() {
	    	return $this->belongsTo('App\Models\Wholesaler','wholesalers_id');
	    }

	    public function getProductAttribute($value) {
	    	if (!Auth::check() || Auth::user()->type == 1)
		    	return $this->product_amount != null && $this->product_amount->product_color != null ? $this->product_amount->product_color->product : null;
		    else
		    	return $this->wholesaler();
		}

		public function getProductColorAttribute($value) {
		    return $this->product_amount != null ? $this->product_amount->product_color : null;
		}

		public function getProductSizeAttribute($value) {
		    return $this->product_amount != null && $this->product_amount->category_size != null ? $this->product_amount->category_size->size : null;
		}
	}
