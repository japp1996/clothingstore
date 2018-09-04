<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Size;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('status', '1')
            ->with([
                'subcategories' => function ($q){
                    $q->select('id', 'name', 'name_english', 'category_id')->withCount('products');
                },
                'sizes' => function ($q){
                    $q->select('sizes.id');
                }
            ])
            ->withCount('products')
            ->get();

        $sizes = Size::where('status', '1')->get();

        return view('admin.categories.index')->with(['categories' => $categories, 'sizes' => $sizes]);
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
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());

        foreach ($request->sizes as $key => $size) {
            $category->sizes()->attach($category->id, ['size_id' => $size]);
        }

        foreach ($request->subcategories as $key => $subcategory) {
            $category->subcategories()->create($subcategory);
        }
        
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
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
            $category->name = $request->name;
            $category->name_english = $request->name_english;
        $category->save();

        $category->sizes()->detach();

        foreach ($request->sizes as $key => $size) {
            $category->sizes()->attach($category->id, ['size_id' => $size]);
        }
        
        $sub_ids = [];
        foreach ($request->subcategories as $key => $subcategory) {
            if($subcategory['id'] > 0){
                Subcategory::find($subcategory['id'])->update(['name' => $subcategory['name'], 'name_english' => $subcategory['name_english']]);
            }else{
                $subcategory = $category->subcategories()->create($subcategory);
            }

            $sub_ids[] = $subcategory['id'];
        }

        Subcategory::where('category_id', $id)->whereNotIn('id', $sub_ids)->doesnthave('products')->update(['status' => '2']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->withCount(['products'])->first();

        if($category->products_count == 0){
                $category->status = "2";
            $category->save();

            Subcategory::where('category_id', $id)->doesnthave('products')->update(['status' => '2']);
        }else{
            return response()->json([
                'error' => "La categoría tiene productos activos",
                'result' => false
            ]);
        }
        
    }
}
