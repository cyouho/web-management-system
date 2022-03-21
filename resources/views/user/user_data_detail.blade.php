@if (isset($userData['userValidateResult']))
{{ $userData['userValidateResult'] }}
@elseif (isset($userData['getUserResult']))
{{ $userData['getUserResult'] }}
@else
<div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 id="adminId" value="{{ $data['admin_id'] }}">登录记录</h2>
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
</div>
@endif