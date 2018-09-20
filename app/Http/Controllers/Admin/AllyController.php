<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AllyRequest;
use App\Models\Aliado;
use App\Models\AliadoFoto;

use App\Libraries\SetNameImage;
use App\Libraries\ResizeImage;
use File;

class AllyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $url = "img/aliados/";

    public function index()
    {
        $allies = Aliado::with([
            'fotos' => function ($query)
            {
                $query->select('id', 'aliado_id', 'foto');
            }
        ])
        ->get();

        return view('admin.allies.index')->with(['allies' => $allies]);
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
    public function store(AllyRequest $request)
    {
        $ally = new Aliado;
        $ally->nombre = $request->nombre;
        $ally->facebook = $request->facebook;
        $ally->twitter = $request->twitter;
        $ally->instagram = $request->instagram;
        $ally->direccion = $request->direccion;
        $ally->save();

        if ($request->count > 0) {
            for ($i=1; $i <= $request->count; $i++) { 
                $file = $request->file('file'.$i);
                $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
                $file->move($this->url, $file_name);
                ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $this->url);
                $photo = new AliadoFoto;
                $photo->foto = $file_name;
                $photo->aliado_id = $ally->id;
                $photo->save();
            }
        }
        return response()->json(['result' => true, 'message' => 'Aliado registrado exitosamente']);
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
    public function update(AllyRequest $request, $id)
    {
        $ally = Aliado::find($id);
        $ally->nombre = $request->nombre;
        $ally->facebook = $request->facebook;
        $ally->twitter = $request->twitter;
        $ally->instagram = $request->instagram;
        $ally->direccion = $request->direccion;
        $ally->save();

        return response()->json(['result' => true, 'message' => 'Aliado actualizado exitosamete.']);
    }

    public function updateImages(Request $request)
    {
        if ($request->id == 0) {
            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->url, $file_name);
            
            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $this->url);

            $photo = new AliadoFoto;
            $photo->foto = $file_name;
            $photo->aliado_id = $request->ally_id;
            $photo->save();
            $id = $photo->id;
        } else {
            $item = AliadoFoto::find($request->id);
            $odlFile = $item->foto;

            $file = $request->file('file');
            $file_name = SetNameImage::set($file->getClientOriginalName(), $file->getClientOriginalExtension());
            $file->move($this->url, $file_name);

            ResizeImage::dimenssion($file_name, $file->getClientOriginalExtension(), $this->url);
            File::delete(public_path($this->url.$odlFile));

            $item->foto = $file_name;
            $item->save();
            $id = $request->id;
        }

        return response()->json(['result' => true, 'id' => $id, 'file' => $file_name]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ally = Aliado::find($id);
        $ally->delete();

        return response()->json(['result' => true, 'message' => 'Aliado eliminado exitosamnete']);
    }

    public function delete(Request $request)
    {
        $item = AliadoFoto::find($request->id);
        $file = $item->foto;
        File::delete(public_path($this->url.$file));
        $item->delete();

        return response()->json(['result' => true]);
    }
}
