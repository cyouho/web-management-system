<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @TODO 用 user api 更换现有独立操作 user 类
 */
class UserAccount extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'user_accounts';

    /**
     * Get User Account.
     * 获取用户账户
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $columnValue <DB where conditon | 数据库 where 检索约束条件>
     * 
     * @return mix function 
     */
    public function getUserAccount(array $columnName = ['*'], $condition = [])
    {
        return $this->selectUserData($columnName, $condition);
    }

    /**
     * Select User Data.
     * 检索用户数据
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     * 
     * @return object $result <selected result | 检索结果>
     */
    private function selectUserData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }
}
