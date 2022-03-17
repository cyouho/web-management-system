<!doctype html>
<html lang="en">

<head>
    @include('global.global_header')
</head>

<body>

    @include('global.global_navbar')

    <div class="container-fluid">
        <div class="row">

            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column dropdown-menu-macos mx-0 border-0">
                        <li><a class="dropdown-item" href="/index">管理员主页</a></li>
                        <li><a class="dropdown-item active" href="/user">用户管理</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

            </main>
        </div>
    </div>

    @include('global.global_footer')
</body>

</html>