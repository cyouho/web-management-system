<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Admin Login Record Class.
 * 管理员登录记录类
 */
class AdminLoginRecord extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'admin_login_record';

    /**
     * Set Admin Login Record.
     * 设置管理员登录记录
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB where condition | 数据库 where 检索约束条件>
     */
    public function setAdminLoginRecord(array $columnName = [], array $condition = [])
    {
        $this->createAdminData($columnName, $condition);
    }

    /**
     * Get Admin Login Record.
     * 获取管理员登录记录
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     * @param string $orderByColumnName <DB order by column name | 数据库排序字段>
     * @param string $orderBy <DB order by type | 数据库排序规则>
     * 
     * @return mix function
     */
    public function getAdminLoginRecord(
        array $columnName = [],
        array $condition = [],
        string $orderByColumnName = '',
        string $orderBy = 'desc'
    ) {
        return $this->selectAdminData($columnName, $condition, $orderByColumnName, $orderBy);
    }

    /**
     * Create Admin Data.
     * 创建管理员数据
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     */
    private function createAdminData(array $columnName = [], array $condition = [])
    {
        $affected = DB::table(self::TABLE_NAME)
            ->updateOrInsert(
                $columnName,
                $condition
            );
    }

    private function selectAdminData(
        array $columnName = ['*'],
        array $condition = [],
        string $orderByColumnName,
        string $orderBy
    ) {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->orderBy($orderByColumnName, $orderBy)
            ->get();

        return $result;
    }
}
