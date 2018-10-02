<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Libraries\ResizeImage;
use App\Libraries\SetNameImage;
use File;


class GenerateBlogController extends Controller
{

    public function index(){
        $blog = Blog::select('id', 'title', 'title_english', 'description', 'description as description_min', 'description_english', 'created_at')
            ->where('status', "!=", '2')
            ->with(["images" => function ($query){
                $query->select('blog_id', 'file');
            }])
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

    public function updateImage(Request $request){
        $url = "img/blogs/";
        if ($request->id == 0) {
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            $detail = new BlogImage;
            $detail->file = $file_name;
            $detail->blog_id = $request->blog_id;
            $detail->save();
            $fileId = $detail->id;
        } else {
            $item = BlogImage::find($request->id);
            $odlFile = $item->file;
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            File::delete(public_path($url.$odlFile));
            $item->file = $file_name;
            $item->save();
            $fileId = $request->id;
        }
        return response()->json(['result' => true, 'id' => $fileId, 'file' => $file_name]);
    }

    public function deleteImage(Request $request){
        $url = "img/blogs/";
        $item = BlogImage::find($request->id);
        $file = $item->file;
        File::delete(public_path($url.$file));
        $item->delete();
        return response()->json(['result' => true]);
    }

    public function destroy($id){
        $blog = Blog::find($id);
        $blog->status = "2";
        $blog->save();
    }
}
