<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function method_login(Request $request){

        $credentials = $request->validate([
            'nik' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials['password'] = 'appcoregwnih'.$request->password;
        if(!Auth::attempt($credentials)){
            return redirect('/user/login')->with('failure','Account anda tidak ditemukan !');
        }

        // if(session()->get('url_gto'))
        //     return redirect(session()->get('url_gto'));

        // if(Auth::user()->group_id == 2)
        //     return redirect('/mkl/' . Session::getId() . '/' . base64_encode(Auth::user()->id));
        // if(Auth::user()->group_id == 33)
        //     return redirect('/gto/' . Session::getId());
        return redirect('/index');
    } 
}
