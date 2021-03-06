<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminLoginRecord extends Model
{
    use HasFactory;

    const TABLE_NAME = 'admin_login_record';

    public function setAdminLoginRecord(array $columnName = [], array $condition = [])
    {
        $this->createAdminData($columnName, $condition);
    }

    public function getAdminLoginRecord(
        array $columnName = [],
        array $condition = [],
        string $orderByColumnName = '',
        string $orderBy = 'desc'
    ) {
        return $this->selectAdminData($columnName, $condition, $orderByColumnName, $orderBy);
    }

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
