<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Admin Model Class.
 * 管理员数据处理类
 */
class AdminAccount extends Model
{
    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'admin_accounts';

    /**
     * Set Admin Account.
     * 设置管理员账户
     * 
     * @param array $data <admin data | 管理员数据>
     * 
     * @param mix function
     */
    public function setAdminAccount($data)
    {
        return $this->createAdminData($data);
    }

    /**
     * Get Admin Account.
     * 获取管理员账户
     * 
     * @param array $condition <DB where condition | 数据库 where 检索约束条件>
     * @param array $columnName <DB column name | 数据库列名>
     * 
     * @return mix function
     */
    public function getAdminAccount(array $condition, array $columnName)
    {
        return $this->selectAdminData($condition, $columnName);
    }

    /**
     * Get Admin Login Record.
     * 获取管理员登录记录
     * 
     * @param int $adminId <admin Id | 管理员Id>
     * @param int $loginRecordDate <admin login record date | 管理员登录时间>
     * 
     * @param mix function
     */
    public function getAdminLoginRecord(int $adminId, int $loginRecordDate)
    {
        return $this->selectAdminData($condition = [], $columnName = []);
    }

    /**
     * Check Admin Password.
     * 检查管理员密码
     * 
     * @param array $condition <DB where condition | 数据库 where 检索约束条件>
     * @param array $columnName <DB column name | 数据库列名>
     * @param string $adminPassword <admin password | 管理员密码>
     * 
     * @return bool 0 | 1 <bool value | 布尔值>
     */
    public function checkAdminPassword(array $condition, array $columnName, string $adminPassword)
    {
        $result = $this->selectAdminData($condition, $columnName);
        $hashPassword = isset($result[0]->admin_password) ? $result[0]->admin_password : NULL;

        return Hash::check($adminPassword, $hashPassword);
    }

    public function updateAdminSessionAndLastLoginAtAndTotalLoginTimes(
        string $loginTime,
        string $adminSession,
        string $adminEmail
    ) {
        return $this->updateAdminData(
            $condition = [['admin_email', $adminEmail]],
            $updateData = [
                'last_login_at' => $loginTime,
                'admin_session' => $adminSession,
                'total_login_times' => DB::raw('total_login_times + 1')
            ]
        );
    }

    private function createAdminData(array $data): int
    {
        $id = DB::table(self::TABLE_NAME)
            ->insertGetId($data);

        return $id;
    }

    private function selectAdminData(array $condition = [], array $columnName = ['*'])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }

    private function updateAdminData($condition = [], $updataData = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->where($condition)
            ->update($updataData);
    }
}
