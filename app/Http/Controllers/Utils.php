<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Utils extends Controller
{
    /**
     * Make md5 value for session
     * 使用 md5 来生成所需的 session
     * 
     * @param void
     * 
     * @return string <md5 of now timestamp | 现在时间戳的md5值>
     */
    public static function getSessionRandomMD5()
    {
        return md5(time());
    }

    /**
     * Get name from email
     * 从 email 中获取 name
     * 
     * @param string $email <User email | 用户email>
     * 
     * @return string <User name from email | 从用户email里提取的用户名>
     */
    public static function getNameFromEmail($email)
    {
        return substr($email, 0, strripos($email, "@"));
    }

    public static function arrangeLoginDateWithLoginTimes($record, int $date)
    {
        // 处理返回首页的数据
        // 生成登录 '日期' 记录 '空白' 数组 | 'login_day' | $recordDate.length = $date
        $recordDate = [];

        // 生成登录 '次数' 记录 '空白' 数组 | 'login_times' | $recordTimes.length = $date
        $recordTimes = [];

        for ($i = 0; $i < $date; $i++) {
            // 生成 '指定日期长度'，'指定时间长度' 的数组 | $recordDate, $recordTimes
            $recordDate[$i] = date('Y-m-d', strtotime('-' . $i . 'day'));
            $recordTimes[$i] = 0;
            // 比较指定日期在数据库中是否存在，
            // 如果存在，就将对应日期的登录次数赋值给对应日期的 $recordTimes
            for ($j = 0; $j < count($record); $j++) {
                if ($recordDate[$i] == $record[$j]['login_at']) {
                    $recordTimes[$i] = $record[$j]['login_times'];
                }
            }
        }

        return [
            'date'  => array_reverse($recordDate),
            'times' => array_reverse($recordTimes),
        ];
    }
}
