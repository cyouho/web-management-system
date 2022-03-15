<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminLoginRecord extends Model
{
    use HasFactory;

    const TABLE_NAME = 'admin_login_record';

    public function setAdminLoginRecord(array $data)
    {
        return $this->createAdminData($data);
    }

    public function getAdminLoginRecord(int $adminId, int $loginRecordDate)
    {
        return $this->selectAdminData($condition = [], $columnName = []);
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
}
