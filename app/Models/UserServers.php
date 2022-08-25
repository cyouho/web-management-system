<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * User Servers Class.
 * 用户服务类
 */
class UserServers extends Model
{
    use HasFactory;

    /**
     * DB Table Name.
     * 数据库表名
     */
    const TABLE_NAME = 'user_servers';

    /**
     * Get User Servers.
     * 获取用户服务
     * 
     * @param array $columnName <DB column name | 数据库列名>
     * @param array $condition <DB condition | 数据库 where 检索约束条件>
     * 
     * @return mix function
     */
    public function getUserServers(array $columnName = ['*'], array $condition = [])
    {
        return $this->selectUserData($columnName, $condition);
    }

    public function changeUserServerStatus(
        array $condition = [],
        array $updateData = []
    ) {
        return $this->updateUserData($condition, $updateData);
    }

    private function selectUserData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return isset($result[0]) ? $result : NULL;
    }

    /**
     * 非使用锁更新 update without any lock
     */
    private function updateUserData(
        array $condition = [],
        array $updateData = []
    ) {
        $affected = DB::table(self::TABLE_NAME)
            ->where($condition)
            ->update($updateData);

        return $affected;
    }
}
