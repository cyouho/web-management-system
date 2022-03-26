<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse font-weight-bold">
    <div class="sidebar-sticky pt-3">
        <ul class="nav flex-column dropdown-menu-macos mx-0 border-0">
            <li><a class="dropdown-item @isset($indexData['current_page']) {{$indexData['current_page']}} @endisset" href="/index">管理员主页</a></li>
            <li><a class="dropdown-item @isset($userData['current_page']) {{$userData['current_page']}} @endisset" href="/user">用户管理</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Separated link</a></li>
        </ul>
    </div>
</nav>