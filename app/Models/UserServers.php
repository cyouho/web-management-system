<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserServers extends Model
{
    use HasFactory;

    const TABLE_NAME = 'user_servers';

    public function getUserServers(array $columnName = ['*'], array $condition = [])
    {
        return $this->selectUserData($columnName, $condition);
    }

    private function selectUserData(array $columnName = ['*'], array $condition = [])
    {
        $result = DB::table(self::TABLE_NAME)
            ->select($columnName)
            ->where($condition)
            ->get();

        return isset($result[0]) ? $result : NULL;
    }
}
