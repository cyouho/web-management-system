@if (isset($userData['userValidateResult']))
{{ $userData['userValidateResult'] }}
@elseif (isset($userData['getUserResult']))
{{ $userData['getUserResult'] }}
@else
<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 id="userId" value="{{ isset($userData['userId']) ? $userData['userId'] : NULL }}">用户账户信息</h2>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="cardmb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="text-center">用户名</h6>
                    <h4 class="font-weight-bold text-center">{{ isset($userData['userData']['user_name']) ? $userData['userData']['user_name'] : NULL }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="cardmb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="text-center">用户注册时间</h6>
                    <h4 class="font-weight-bold text-center">{{ isset($userData['userData']['created_at']) ? $userData['userData']['created_at'] : NULL }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="cardmb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="text-center">用户最后登陆时间</h6>
                    <h4 class="font-weight-bold text-center">{{ isset($userData['userData']['last_login_at']) ? $userData['userData']['last_login_at'] : NULL }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>登录记录</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <select id="recordDate" class="btn btn-sm btn-outline-secondary">
                <option value="7">近7天</option>
                <option value="14">近14天</option>
                <option value="30">近30天</option>
            </select>
        </div>
    </div>

    <div class="my-4 w-100 main" id="main" width="900" height="380"></div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>登录记录</h2>
    </div>
</div>
@endif