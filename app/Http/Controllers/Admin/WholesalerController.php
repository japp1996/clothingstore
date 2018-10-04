<?php

namespace App\Http\Controllers\Admin;

use App\Models\Wholesaler;
use App\Models\WholesalerImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Filter;

class WholesalerController extends Controller
{
    
    private $url = "img/wholesalers/";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Wholesaler::orderBy('id', 'desc')->get());
        return view('admin.wholesalers.index', 
        [
            'wholesalers' => Wholesaler::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filters = Filter::pluck('name', 'id');
        
        return view('admin.wholesalers.create', ['filters' => $filters]);
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
     * @param  \App\Models\Wholesaler  $wholesaler
     * @return \Illuminate\Http\Response
     */
    public function show(Wholesaler $wholesaler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wholesaler  $wholesaler
     * @return \Illuminate\Http\Response
     */
    public function edit(Wholesaler $wholesaler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wholesaler  $wholesaler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wholesaler $wholesaler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wholesaler  $wholesaler
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wholesaler $wholesaler)
    {
        //
    }
}
