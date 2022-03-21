<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;

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

        if ($validateResult) {
            $userData = [
                'userValidateResult' => $validateResult,
                'getUserResult'      => NULL,
            ];

            return view('user.user_data_detail', ['userData' => $userData]);
        }

        $getUserResult = $this->getUser($postData['user_email']);

        if (!$getUserResult) {
            $userData = [
                'userValidateResult' => NULL,
                'getUserResult'      => 'User not exsist',
            ];

            return view('user.user_data_detail', ['userData' => $userData]);
        }

        return view('user.user_data_detail');
    }

    private function validatePostData(array $postData)
    {
        if (is_null($postData['user_email'])) {
            return 'Please enter user email';
        } else if (!filter_var($postData['user_email'], FILTER_VALIDATE_EMAIL)) {
            return 'User email type not allowed';
        } else {
            return NULL;
        }
    }

    private function getUser(string $userEmail)
    {
        $user = new UserAccount();
        $result = $user->getUserAccount($columnName = ['user_id'], $condition = [['user_email', $userEmail]]);

        return json_decode($result, TRUE) ? json_decode($result, TRUE) : NULL;
    }
}
