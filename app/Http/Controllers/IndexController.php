<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $indexData = [
            'current_page' => 'active',
        ];

        return view('index', ['indexData' => $indexData]);
    }

    public function getAdminDetails()
    {
    }
}
