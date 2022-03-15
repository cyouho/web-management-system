<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminLoginRecord;

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

        $result = in_array($loginRecordDate, $this->_legal_data_array) ? $this->getAdminLoginRecord($adminId, $loginRecordDate) : $this->getAdminLoginRecord($adminId, 7);
    }

    private function getAdminLoginRecord(int $adminId, int $loginRecordDate)
    {
        $admin = new AdminLoginRecord();
        $admin->getAdminLoginRecord($adminId, $loginRecordDate);
    }
}
