<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Libraries\ResizeImage;
use App\Libraries\SetNameImage;


class GenerateBlogController extends Controller
{

    public function index(){
        $blog = Blog::select('id', 'title', 'title_english', 'description', 'description as description_min', 'description_english', 'created_at')
            ->where('status', "!=", '2')
            ->get();
        
        return view('admin.blogs.index')->with(['posts' => $blog]);
    }

    public function create(){
        return view('admin.blogs.create');
    }

    public function store(BlogRequest $request){
        $blog = new Blog;
        $blog->title = $request->title;
        $blog->title_english = $request->title_english;
        $blog->description = $request->description;
        $blog->description_english = $request->description_english;
        $blog->save();
        
        // Images
        $url = "img/blogs/";
        
        // $first = new ProductImage;
        // $first->file = $main_name;
        // $first->product_id = $product->id;
        // $first->main = '1';
        // $first->save();

        for ($i=0; $i < $request->count; $i++) { 
            $file = $request->file('image'.$i);
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            $blog_image = new BlogImage;
            $blog_image->file = $file_name;
            $blog_image->blog_id = $blog->id;
            $blog_image->save();
        }

    }

    public function edit($id){
        $blog = Blog::where('id', $id)
            ->first();
        $blog_images = BlogImage::where('blog_id', $id)->get();
        return view('admin.blogs.edit')->with(['posts' => $blog, 'images' => $blog_images]);
    }

    public function update(BlogRequest $request, $id){
        $blog = Blog::find($id);
        $blog->title = $request->title;
        $blog->title_english = $request->title_english;
        $blog->description = $request->description;
        $blog->description_english = $request->description_english;
        $blog->save();
    }

    public function delete(){

=======

class GenerateBlogController extends Controller
{
    public function index(){

    }

    public function create(){

    }

    public function store(){

    }

    public function show(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function delete(){
        
>>>>>>> d62eac9afe32975df76815793f2974c30899db29
    }
}
