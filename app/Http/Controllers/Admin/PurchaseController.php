<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['user', 'exchange', 'details', 'exchange'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.purchases.index', ['purchases' => $purchases ]);
    }

    public function date($init, $end)
    {
        $init = new Carbon($init);
        $end = new Carbon($end);
        
        return Purchase::with(['user', 'exchange', 'details', 'exchange'])
            ->orderBy('id', 'DESC')
            ->whereBetween('created_at', [$init->format('Y-m-d'), $end->format('Y-m-d')])
            ->get();
        
    }

}
