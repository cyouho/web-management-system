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

    const TABLE_NAME = 'user_servers';

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
