<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello Feng Jiaxi</title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
    <form class="form-signin" action="/doRegister" method="POST">
        @csrf
        <div class="text-center mb-4">
            <h1 class="my-0 mr-md-auto font-weight-normal">后台管理系统</h1>
            <br>
            <h5 class="my-0 mr-md-auto font-weight-normal">
                <p class="navbar-brand text-dark">
                    创建新账户</p>
            </h5>
        </div>

        <div class="form-label-group">
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputEmail">电子邮箱地址</label>
            @error('email')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
            <label for="inputPassword">登录密码</label>
            @error('password')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button id="login" class="btn btn-lg btn-success btn-block" type="submit">创建</button>
        <p class="login-callout mt-3">
            已经拥有账户？<a href="adminLogin">登录</a>
        </p>
        <p class="mt-5 mb-3 text-muted text-center">This site was created by CYOUHO with &copy; Bootstrap 4!</p>
    </form>
</body>

</html>