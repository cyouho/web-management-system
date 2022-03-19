<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $userData = [
            'current_page' => 'active',
        ];

        return view('user.user_index', ['userData' => $userData]);
    }
}
