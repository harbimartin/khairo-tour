<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function view_index(){
        if(isset($_SESSION['ebudget_id']) && !empty($_SESSION['ebudget_id']))
            return view('pages.home', ['data' => $_SESSION['ebudget_id']]);
        header("Location: http://localhost:70/sikar/login.php");
        die();
    }
    public function view_login(Request $request){
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
