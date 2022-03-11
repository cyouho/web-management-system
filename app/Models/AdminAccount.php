<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAccount extends Model
{
    const TABLE_NAME = 'admin_accounts';

    public function setAdminAccount($data)
    {
        return $this->createAdminData($data);
    }

    public function getAdminAccount(array $condition, array $columnName)
    {
        return $this->selectAdminData($condition, $columnName);
    }

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
