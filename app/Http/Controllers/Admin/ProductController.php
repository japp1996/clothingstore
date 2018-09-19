<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Design;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductAmount;
use App\Http\Requests\ProductRequest;
use App\Libraries\SetNameImage;
use App\Libraries\ResizeImage;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name', 'name_english')
        ->where('status', '1')
        ->with([
            'subcategories' => function ($sql) {
                $sql->select('subcategories.id', 'subcategories.name', 'subcategories.name_english', 'subcategories.category_id');
            },
            'sizes' => function ($sizes) {
                $sizes->select('category_sizes.id', 'name');
            }
        ])
        ->get();

        $collections = Collection::select('id', 'name', 'name_english')
        ->where('status', '1')
        ->get();

        $designs = Design::select('id', 'name', 'name_english', 'collection_id')
        ->where('status', '1')
        ->get();

        $products = Product::where('status', '1')
        ->with([
            'categories' => function ($category) {
                $category->select('id', 'name', 'name_english');
            },
            'subcategories' => function ($subcategory) {
                $subcategory->select('id', 'name', 'name_english');
            },
            'designs' => function ($design) {
                $design->select('id', 'name', 'name_english');
            },
            'collections' => function ($collection) {
                $collection->select('id', 'name', 'name_english');
            },
            'images'
        ])
        ->get();

        return view('admin.products.index')->with(['categories' => $categories, 'collections' => $collections, 'designs' => $designs, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->name_english = $request->name_english;
        $product->description = $request->description;
        $product->description_english = $request->description_english;
        $product->coin = $request->coin;
        $product->price_1 = $request->price_1;
        $product->price_2 = $request->price_2;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id != "" ? $request->subcategory_id : NULL;
        $product->collection_id = $request->collection_id;
        $product->design_id = $request->design_id != "" ? $request->design_id : NULL;
        $product->retail = $request->retail;
        $product->wholesale = $request->wholesale;
        $product->save();

        foreach (json_decode($request->colors) as $colors) {
            $color = new ProductColor;
            $color->name = $colors->name;
            $color->name_english = $colors->name_english;
            $color->product_id = $product->id;
            $color->save();

            foreach ($colors->sizes as $sizes) {
                $size = new ProductAmount;
                $size->amount = $sizes->amount;
                $size->product_color_id = $color->id;
                $size->category_size_id = $sizes->id;
                $size->save();
            }
        }

        // Images
        $url = "img/products/";
        $main = $request->file('main');
        $main_name = SetNameImage::set($main->getClientOriginalName(), $main->getClientOriginalExtension());
        $main->move($url, $main_name);
        ResizeImage::dimenssion($main_name, $main->getClientOriginalExtension(), $url);
        $first = new ProductImage;
        $first->file = $main_name;
        $first->product_id = $product->id;
        $first->main = '1';
        $first->save();
        for ($i=1; $i <= $request->count; $i++) { 
            $file = $request->file('file'.$i);
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            $second = new ProductImage;
            $second->file = $file_name;
            $second->product_id = $product->id;
            $second->main = '0';
            $second->save();
        }

        return response()->json(['result' => true, 'message' => 'Producto almacenado exitosamente.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->name_english = $request->name_english;
        $product->description = $request->description;
        $product->description_english = $request->description_english;
        $product->coin = $request->coin;
        $product->price_1 = $request->price_1;
        $product->price_2 = $request->price_2;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id != "" ? $request->subcategory_id : NULL;
        $product->collection_id = $request->collection_id;
        $product->design_id = $request->design_id != "" ? $request->design_id : NULL;
        $product->retail = $request->retail;
        $product->wholesale = $request->wholesale;
        $product->save();

        $color_ids = [];
        foreach (json_decode($request->colors) as $key => $color) {
            if($color->id > 0){
                ProductColor::find($color->id)->update(['name' => $color->name, 'name_english' => $color->name_english]);
            }else{
                $color = $product->colors()->create($color);
            }

            $color_ids[] = $color['id'];
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Product::find($id);
        $destroy->status = "2";
        $destroy->save();
        
        return response()->json(["result" => true, "message" => "Producto eliminado exitosamente."]);
        
    }
}
