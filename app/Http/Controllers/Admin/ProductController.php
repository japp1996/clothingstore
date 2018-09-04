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

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('id', 'name')
        ->where('status', '1')
        ->with([
            'subcategories' => function ($sql) {
                $sql->select('subcategories.id', 'subcategories.name', 'subcategories.category_id');
            },
            'sizes'
        ])
        ->get();

        $collections = Collection::select('id', 'name')
        ->where('status', '1')
        ->get();

        $designs = Design::select('id', 'name')
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
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        //
    }
}
