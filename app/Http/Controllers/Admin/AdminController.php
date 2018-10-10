<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('admin/exchange_rate');
        }
        return view('welcome');
    }

    public function home()
    {
        return redirect('admin/exchange_rate');
    }
}
