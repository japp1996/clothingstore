<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Hash;

class ProfileController extends Controller
{
    //
    public function profile()
    {
        return view('admin.profile.profile');
    }

    public function update(Request $request){
        $user = User::find(Auth::id());
        $user->email = $request->email;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return $user;
    }
}
