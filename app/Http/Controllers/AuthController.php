<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Utils as ControllerUtils;
use Illuminate\Support\Facades\Cookie;
use App\Models\AdminLoginRecord;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Show register page.
     * 显示注册页面。
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show login page.
     * 显示登陆页面。
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Do register function.
     * 注册功能方法。
     */
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
            'login_at' => date('Y-m-d'),
            'login_times' => 1,
        ];

        $loginRecordId = $adminLoginRecord->setAdminLoginRecord($adminLoginRecordData);

        return response()->redirectTo('/index')->cookie('_zhangfan', $adminSession, 60);
        //return response()->redirectTo('/index');
    }

    /**
     * Do login function.
     * 登陆功能方法。
     */
    public function doLogin(Request $request)
    {
        $postData = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'required|min:8|max:16',
        ]);

        $admin = new AdminAccount();
        $adminLoginRecord = new AdminLoginRecord();

        // 获取用户数据 admin_id, admin_name, admin_role
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

        // 更新admin的session，最后登录时间，总登录次数
        $admin->updateAdminSessionAndLastLoginAtAndTotalLoginTimes(
            $loginTime,
            $adminSession,
            $postData['email']
        );

        $loginRecordDate = date('Y-m-d');
        $adminLoginDataColumnName = [
            'admin_id' => $adminData[0]->admin_id,
            'login_at' => $loginRecordDate,
        ];

        $adminLoginDataCondition = [
            'login_at' => $loginRecordDate,
            'login_times' => DB::raw('login_times + 1'),
        ];

        // 更新admin每天登录次数
        $adminLoginRecord->setAdminLoginRecord(
            $adminLoginDataColumnName,
            $adminLoginDataCondition
        );

        return response()->redirectTo('/index')->cookie('_zhangfan', $adminSession, 60);
    }

    /**
     * Do logout function.
     * 登出功能方法。
     */
    public function doLogout()
    {
        $adminCookie = Cookie::forget('_zhangfan');
        return response()->redirectTo('/adminLogin')->cookie($adminCookie);
    }
}
