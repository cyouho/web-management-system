<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\UserLoginRecord;
use App\Http\Controllers\Utils as ControllerUtils;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $_legal_data_array = [7, 14, 30];

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

        return view('user.user_data_detail', ['userId' => $getUserResult[0]['user_id']]);
    }

    public function userLoginRecordAjax(Request $request)
    {
        $postData = $request->post();

        $userId = $postData['userId'];
        $loginRecordDate = $postData['recordDay'];

        $result = in_array($loginRecordDate, $this->_legal_data_array) ?
            $this->getUserLoginRecord($userId, $loginRecordDate) :
            $this->getUserLoginRecord($userId, 7);

        $dateResult = ControllerUtils::arrangeLoginDateWithLoginTimes(
            json_decode($result, true),
            $loginRecordDate
        );

        return response()->json($dateResult);
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

    private function getUserLoginRecord(int $userId, int $loginRecordDate)
    {
        $user = new UserLoginRecord();
        $result = $user->getUserLoginRecord(
            $columnName = [
                DB::raw('DATE_FORMAT(login_at, ' . "'%Y-%m-%d'" . ') as login_at'),
                'login_times'
            ],
            $condition = [
                ['user_id', $userId],
                ['login_at', '>=', DB::raw('date_sub(curdate(), INTERVAL ' . $loginRecordDate . ' DAY)')]
            ],
            $orderByColumnName = 'login_at',
            $orderBy = 'desc',
        );

        return $result;
    }
}
