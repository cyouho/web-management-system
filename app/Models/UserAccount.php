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

    public function getUserAccount(array $columnName = ['*'], $condition = [])
    {
        return $this->selectUserData($columnName, $condition);
    }

    private function selectUserData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return $result;
    }
}
