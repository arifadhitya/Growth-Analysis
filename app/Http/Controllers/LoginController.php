<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Chart\Title;
//use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index(){
        return view('/login/index', [
            'title' => 'Login',
            'active' => 'login',
        ]);
    }

    public function authentication(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError','Nama pengguna atau kata sandi yang anda masukkan salah');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
