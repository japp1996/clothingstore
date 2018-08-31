<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class BlogImage extends Model {
	    protected $table="blog_images";

	    public function blog() {
	    	return $this->belongsTo('App\Models\Blog','blog_id');
	    }
	}
