<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class BlogImage extends Model {
	    protected $table="blog_images";
	    public $timestamps = false;

	    public function blog() {
	    	return $this->belongsTo('App\Models\Blog','blog_id');
	    }
	}
