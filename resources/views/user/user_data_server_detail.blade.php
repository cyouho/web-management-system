<tr>
    @isset($userData['userServersData'])
    @foreach($userData['userServersData'] as $value)
    <td>
        {{ $value['user_id'] }}
    </td>
    <td>
        {{ $value['server_id'] }}
    </td>
    <td>
        {{ $userData['userServersCHNName'][$value['server_name']] }}
    </td>
    <td>
        {{ $value['server_status'] ? '使用中' : '暂停中' }}
    </td>
    <td>
        {{ $value['created_at'] }}
    </td>
    <td>
        {{ $value['updated_at'] }}
    </td>
    <td>
        @if($value['server_status'])
        <button type="button" id="changeServerStatus" class="btn btn-danger btn-sm" value="{{ $value['server_id'] }}">暂停服务</button>
        @else
        <button type="button" id="changeServerStatus" class="btn btn-success btn-sm" value="{{ $value['server_id'] }}">开始服务</button>
        @endif
    </td>
    @endforeach
    @endisset
</tr>