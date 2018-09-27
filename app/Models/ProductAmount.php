<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class ProductAmount extends Model {
	    protected $table = "product_amount";

	    public function product_color() {
	    	return $this->belongsTo(ProductColor::class,'product_color_id');
	    }

	    public function category_size() {
	    	return $this->belongsTo(CategorySize::class,'category_size_id');
	    }
	}
