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

    public function userDataDetailAjax(Request $request)
    {
        $postData = $request->post();

        $validateResult = $this->validatePostData($postData);

        $userData = [
            'userValidateResult' => $validateResult,
        ];

        return view('user.user_data_detail', ['userData' => $userData]);
    }

    private function validatePostData($postData)
    {
        if (is_null($postData['user_email'])) {
            return 'Please enter user email';
        } else if (!filter_var($postData['user_email'], FILTER_VALIDATE_EMAIL)) {
            return 'User email type not allowed';
        } else {
            return NULL;
        }
    }
}
