<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function view_index(Request $request){
        // if(!Auth::check())
        //     return redirect('/login');
        // $data = $request->cookie('_BSRF');
        // $data = json_encode($request->session()->all());
        session_start();
        return $_SESSION['ebudget_id'];
        // return view('pages.home', [ 'data' => $data, 'test'=>'heyoo']);
    }
    public function view_login(Request $request){
        session_start();
        $_SESSION['ebudget_id'] = 'ehhehe';
        return view('login');
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
