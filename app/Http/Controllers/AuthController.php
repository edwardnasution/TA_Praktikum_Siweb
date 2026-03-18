<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginView(Request $request)
    {
        if (session('login')) {
            return redirect('/');
        }
        $saved_username = $request->cookie('remember_username');
        return view('auth.login', ['saved_username' => $saved_username]);
    }
    public function loginAction(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $remember = $request->has('remember');
        if ($username === 'admin' && $password === 'admin123') {

            session(['login' => true, 'username' => $username]);

            if ($remember) {
                Cookie::queue('remember_username', $username, 10080);
            } else {
                Cookie::queue(Cookie::forget('remember_username'));
            }
            return redirect('/');
        }
        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
