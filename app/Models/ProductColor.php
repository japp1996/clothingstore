<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class ProductColor extends Model {
	    protected $table = "product_colors";

	    public function product() {
	    	return $this->belongsTo(Product::class,'product_id');
	    }
	}
