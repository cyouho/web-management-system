<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Utils as ControllerUtils;
use Illuminate\Support\Facades\Cookie;
use App\Models\AdminLoginRecord;

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
            'email' => 'bail|required|email|unique:admin_accounts,admin_email',
            'password' => 'required|min:8|max:16',
        ]);

        $admin = new AdminAccount();
        $adminLoginRecord = new AdminLoginRecord();
        $adminName = ControllerUtils::getNameFromEmail($postData['email']);
        $adminSession = ControllerUtils::getSessionRandomMD5();
        $timestamp = date("Y-m-d H:i:s");
        $password = Hash::make($postData['password']);

        $adminData = [
            'admin_role' => 2,
            'admin_name' => $adminName,
            'admin_email' => $postData['email'],
            'admin_password' => $password,
            'admin_session' => $adminSession,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
            'last_login_at' => $timestamp,
            'total_login_times' => 1,
        ];

        $adminId = $admin->setAdminAccount($adminData);

        $adminLoginRecordData = [
            'admin_id' => $adminId,
            'admin_name' => $adminName,
            'login_at' => date('Y-m-d'),
            'login_times' => 1,
        ];

        $loginRecordId = $adminLoginRecord->setAdminLoginRecord($adminLoginRecordData);

        return response()->redirectTo('/index')->cookie('_zhangfan', $adminSession, 60);
        //return response()->redirectTo('/index');
    }

    public function doLogin(Request $request)
    {
        $postData = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required|min:8|max:16',
        ]);

        $admin = new AdminAccount();
        $adminLoginRecord = new AdminLoginRecord();

        $adminData = $admin->getAdminAccount(
            $condition = [['admin_email', $postData['email']]],
            $columnName = ['admin_id', 'admin_name', 'admin_role']
        );

        if (!isset($adminData[0])) {
            return redirect('/adminLogin')->withErrors(['email' => 'user not exist']);
        } else if (!$admin->checkAdminPassword(
            $condition = [['admin_email', $postData['email']]],
            $columnName = ['admin_password'],
            $postData['password']
        )) {
            return redirect('/adminLogin')->withErrors(['password' => 'admin password not incorrect']);
        }

        $loginTime = date('Y-m-d H:i:s');
        $adminSession = ControllerUtils::getSessionRandomMD5();

        $admin->updateAdminSessionAndLastLoginAtAndTotalLoginTimes(
            $loginTime,
            $adminSession,
            $postData['email']
        );

        return response()->redirectTo('/index')->cookie('_zhangfan', $adminSession, 60);
    }

    public function doLogout()
    {
        $adminCookie = Cookie::forget('_cyouho');
        return response()->redirectTo('/adminLogin')->cookie($adminCookie);
    }
}
