<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;
use App\Models\UserLoginRecord;
use App\Http\Controllers\Utils as ControllerUtils;
use Illuminate\Support\Facades\DB;
use App\Models\UserServers;

class UserController extends Controller
{
    private $_legal_data_array = [7, 14, 30];

    private $_user_servers_name = [];

    public function __construct()
    {
        $this->_user_servers_name = config('serversname.user_servers_name');
    }

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

        $user = new UserAccount();
        $result = $user->getUserAccount(
            $columnName = ['user_name', 'created_at', 'last_login_at'],
            $condition = [['user_email', $postData['user_email']]]
        );
        $userData = json_decode($result, TRUE)[0]; // 注意这里的 [0], 已经转换成数组 array

        $userServer = new UserServers();
        $userServersResult = $userServer->getUserServers(
            $columnName = ['*'],
            $condition = [['user_id', $getUserResult[0]['user_id']]]
        );
        $userServersData = json_decode($userServersResult, TRUE); // 注意这里已转换为全数组 array

        return view('user.user_data_detail', ['userData' => [
            'userId' => $getUserResult[0]['user_id'],
            'userData' => $userData,
            'userServersData' => isset($userServersData[0]) ? $userServersData : NULL,
            'userServersCHNName' => $this->_user_servers_name,
        ]]);
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

    public function changeUserServerDetailAjax(Request $request)
    {
        $postData = $request->post();

        $userId = $postData['userId'];
        $serverId = $postData['serverId'];

        $userServer = new UserServers();
        $userServer->changeUserServerStatus(
            $conditon = [
                ['server_id', $serverId],
                ['user_id', $userId]
            ],
            $update = [
                'server_status' => DB::raw('IF (server_status = 1, 0, 1)'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        $result = $userServer->getUserServers(
            $columnName = ['*'],
            $condition = [['user_id', $userId]],
        );

        $userServerData = json_decode($result, TRUE); // 转换成数组 array

        return view('user.user_data_server_detail', ['userData' => [
            'userServersData' => isset($userServerData[0]) ? $userServerData : NULL,
            'userServersCHNName' => $this->_user_servers_name,
        ]]);
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
