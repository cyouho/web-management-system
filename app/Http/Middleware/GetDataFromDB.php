<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\AdminAccount;

class GetDataFromDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $adminCookie = request()->cookie('_zhangfan');
        $admin = new AdminAccount();
        $result = $admin->getAdminAccount($condition = [['admin_session', $adminCookie]], $columnName = ['admin_id', 'admin_name', 'admin_role']);

        $AdminData = [
            'admin_id' => isset($result[0]->admin_id) ? $result[0]->admin_id : NULL,
            'admin_name' => isset($result[0]->admin_name) ? $result[0]->admin_name : NULL,
            'isLogin' => isset($result[0]->admin_id),
        ];

        view()->share('data', $AdminData);

        return $next($request);
    }
}
