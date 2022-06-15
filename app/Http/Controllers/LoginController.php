<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('/login/index', []);
    }

    public function authentication(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return redirect('/login/')->with('loginError','Nama pengguna atau kata sandi yang anda masukkan salah');
    }
}
