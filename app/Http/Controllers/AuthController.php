<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function view_index(){
        // if(!Auth::check())
        //     return redirect('/login');
        return view('pages.home');
    }

    public function method_login(Request $request){

        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        // if this encrypt password. you can setup encrypt
        // for e-budget, encrypt default laravel
        $credentials['password'] = $request->password;

        if(!Auth::attempt($credentials)){
            return redirect('/user/login')->with('failure','Account anda tidak ditemukan !');
        }
        return redirect('/');
    }
}
