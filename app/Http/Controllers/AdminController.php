<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminLoginRecord;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Utils as ControllerUtils;

class AdminController extends Controller
{
    private $_legal_data_array = [7, 14, 30];

    public function adminLoginRecordAjax(Request $request)
    {
        $postData = $request->validate([
            'adminId' => 'required|integer',
            'recordDay' => 'required|integer',
        ]);

        $adminId = $postData['adminId'];
        $loginRecordDate = $postData['recordDay'];

        $result = in_array($loginRecordDate, $this->_legal_data_array) ?
            $this->getAdminLoginRecord($adminId, $loginRecordDate) :
            $this->getAdminLoginRecord($adminId, 7);

        $dateResult = ControllerUtils::arrangeLoginDateWithLoginTimes(
            json_decode($result, true),
            $loginRecordDate
        );

        return response()->json($dateResult);
    }

    private function getAdminLoginRecord(int $adminId, int $loginRecordDate)
    {
        $admin = new AdminLoginRecord();
        $result = $admin->getAdminLoginRecord(
            $columnName = [
                DB::raw('DATE_FORMAT(login_at, ' . "'%Y-%m-%d'" . ') as login_at'),
                'login_times'
            ],
            $condition = [
                ['admin_id', $adminId],
                ['login_at', '>=', DB::raw('date_sub(curdate(), INTERVAL ' . $loginRecordDate . ' DAY)')]
            ],
            $orderByColumnName = 'login_at',
            $orderBy = 'desc',
        );

        return $result;
    }
}
