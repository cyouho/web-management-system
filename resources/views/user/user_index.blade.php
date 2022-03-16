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
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="/index">
                                <i class="bi bi-house-door"></i>
                                管理员主页
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/user">
                                <i class="bi bi-person"></i>
                                用户管理 <span class="sr-only">(current)</span>
                            </a>
                        </li>
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