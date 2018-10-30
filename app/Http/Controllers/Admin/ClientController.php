<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ClientController extends Controller
{
    public function index() 
    {
        $clients = User::where('nivel', '1')->with('pais', 'estado', 'pedidos.details', 'pedidos.exchange')->get();
   
        return view('admin.clients.index', ['clients' => $clients]);
    }
}
