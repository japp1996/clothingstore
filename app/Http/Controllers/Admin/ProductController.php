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
            'images',
            'colors' => function ($colors) {
                $colors->select('id', 'name', 'name_english', 'product_id')
                ->where('status', '1')
                ->with([
                    'amounts' => function ($q) {
                        $q->select('id as amount_id', 'amount', 'product_color_id', 'category_size_id')
                        ->with([
                            'category_size' => function ($c) {
                                $c->select('id', 'category_id', 'size_id')
                                ->with([
                                    'size' => function ($s) {
                                        $s->select('id', 'name')
                                        ->where('status', '1');
                                    }
                                ]);
                            }
                        ]);
                    }
                ]);
            }
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

        $product = Product::find($id);
        $product->name = $request->name;
        $product->name_english = $request->name_english;
        $product->description = $request->description;
        $product->description_english = $request->description_english;
        $product->coin = $request->coin;
        $product->price_1 = $request->price_1;
        $product->price_2 = $request->price_2;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id != "" && $request->subcategory_id != 'null' ? $request->subcategory_id : NULL;
        $product->collection_id = $request->collection_id;
        $product->design_id = $request->design_id != "" && $request->design_id != 'null' ? $request->design_id : NULL;
        $product->retail = $request->retail;
        $product->wholesale = $request->wholesale;
        $product->save();

        $color_ids = [];
        foreach (json_decode($request->colors) as $key => $colors) {
            if($colors->id > 0){
                $color = ProductColor::find($colors->id)->update(['name' => $colors->name, 'name_english' => $colors->name_english]);
                $color_id = $colors->id;
            }else{
                $color = $product->colors()->create(['name' => $colors->name, 'name_english' => $colors->name_english]);
                $color_id = $color->id;
            }
            $color_ids[] = $color_id;
            foreach ($colors->sizes as $key => $sizes) {
                if ($sizes->amount_id != 0) {
                    $size = ProductAmount::find($sizes->amount_id);
                    $size->amount = $sizes->amount;
                    $size->save();
                } else {
                    $size = new ProductAmount;
                    $size->amount = $sizes->amount;
                    $size->product_color_id = $color_id;
                    $size->category_size_id = $sizes->id;
                    $size->save();
                }
                
            }
        }
        ProductColor::where('product_id', $id)
        ->whereNotIn('id', $color_ids)
        ->whereHas('amounts', function ($query) {
            $query->where('amount', '=', '0');
        })->update(['status' => '0']);

        // Images
        $url = "img/products/";
        if ($request->hasFile('main')) {
            $main = $request->file('main');
            $main_name = SetNameImage::set($main->getClientOriginalName(), $main->getClientOriginalExtension());
            $main->move($url, $main_name);
            ResizeImage::dimenssion($main_name, $main->getClientOriginalExtension(), $url);
            $first = ProductImage::where('product_id', $id)->where('main', '1')->first();
            $old_main = $first->file;
            $first->file = $main_name;
            $first->save();
            File::delete(public_path($url.$old_main));
            // if ($request->count > 0) {
            //     for ($i=1; $i <= $request->count; $i++) {
            //         if ($request->hasFile('file'.$i)) {
            //             $file = $request->file('file'.$i);
            //             $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            //             $file->move($url, $file_name);
            //             ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            //             $second = new ProductImage;
            //             $second->file = $file_name;
            //             $second->product_id = $product->id;
            //             $second->main = '0';
            //             $second->save();
            //         }                    
            //     }
            // }
        }

        return response()->json(['result' => true, 'message' => 'Producto actualizado exitosamente.']);
        
    }

    public function updateImage(Request $request)
    {
        $url = "img/products/";
        if ($request->id == NULL || $request->id == 'null') {
            $item = ProductImage::where('product_id', $request->product_id)->where('main', '1')->first();
            $odlFile = $item->file;
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            File::delete(public_path($url.$odlFile));
            $item->file = $file_name;
            $item->save();
            $fileId = $item->id;
        }
        else if ($request->id == 0) {
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);
            
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            $detail = new ProductImage;
            $detail->file = $file_name;
            $detail->product_id = $request->product_id;
            $detail->save();
            $fileId = $detail->id;
        } else {
            $item = ProductImage::find($request->id);
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

    public function delete(Request $request)
    {
        $url = "img/products/";
        $item = ProductImage::find($request->id);
        $file = $item->file;
        File::delete(public_path($url.$file));
        $item->delete();

        return response()->json(['result' => true]);
    }
}
