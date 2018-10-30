<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Libraries\SetNameImage;
use App\Libraries\ResizeImage;
use File;
use Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banners = Banner::all();

        return view('admin.banners.index')->with([
            'banners' => $banners
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:jpg,jpeg,png',
        ];

        $messages = [
            'mimes' => 'Formato de archivo incorrecto. Debe ser jpg, jpeg o png'
        ];

        $attributes = [
            'file' => 'banner'
        ];

        $validation = Validator::make($request->all(), $rules, $messages);

        $validation->setAttributeNames($attributes);

        if ($validation->fails()) {
            return response()->json([
                'result' => false,
                'error' => $validation->messages()->first()
            ], 422);
        }

        $url = "img/slider/";
        if ($request->id == 0) {
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);

            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
            $banner = new Banner;
            $banner->foto = $file_name;
            $banner->save();
            $fileId = $banner->id;
        } else {
            $item = Banner::find($request->id);
            $odlFile = $item->foto;
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($url, $file_name);

            $response = ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $url);
           
            File::delete(public_path($url.$odlFile));

            $item->foto = $file_name;
            $item->save();
            $fileId = $request->id;
        }

        return response()->json(['result' => true, 'id' => $fileId, 'file' => $file_name]);
    }

    public function create()
    {
        return view('admin.banners.create');
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
    public function destroy(Request $request)
    {
        $banner = Banner::find($request->id);
            // $banner->status = '2';
        $banner->delete();
    }
}
