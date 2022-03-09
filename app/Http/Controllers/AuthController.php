<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function doRegister(Request $request)
    {
        $postData = $request->validate([
            'email' => 'required|email|unique:admin_accounts,admin_email',
            'password' => 'required|min:8|max:16',
        ]);

        // response()->redirectTo('/')->cookie('_cyouho', $cookie, 60);
        return response()->redirectTo('/index');
    }

    public function doLogin(Request $request)
    {
    }
}
