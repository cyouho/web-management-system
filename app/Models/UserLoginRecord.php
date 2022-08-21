<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * User Login Record Class.
 * 用户登录记录类
 */
class UserLoginRecord extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'user_login_records';

    /**
     * Set User Login Record.
     * 设置用户登录记录
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     */
    public function setUserLoginRecord(array $columnName = [], array $condition = [])
    {
        $this->createUserData($columnName, $condition);
    }

    /**
     * Get User Login Record.
     * 获取用户登录记录
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     * @param string $orderByColumnName <DB order by column name | 数据库排序字段名>
     * @param string $orderBy <DB order by type | 数据库排序规则>
     * 
     * @return mix function
     */
    public function getUserLoginRecord(
        array $columnName = [],
        array $condition = [],
        string $orderByColumnName = '',
        string $orderBy = 'desc'
    ) {
        return $this->selectUserData($columnName, $condition, $orderByColumnName, $orderBy);
    }

    /**
     * Create User Data.
     * 创建用户数据
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB where condition | 数据库 where 检索约束条件>
     */
    private function createUserData(array $columnName = [], array $condition = [])
    {
        $affected = DB::table(self::TABLE_NAME)
            ->updateOrInsert(
                $columnName,
                $condition
            );
    }

    private function selectUserData(
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
