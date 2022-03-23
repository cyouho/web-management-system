<!doctype html>
<html lang="en">

<head>
    @include('global.global_header')
    <script src="js/user.js"></script>
</head>

<body>

    @include('global.global_navbar')

    <div class="container-fluid">
        <div class="row">

            @include('global.global_sidebar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div>
                    <div class="input-group mt-3 mb-3">
                        <input type="text" id="userEmail" class="form-control" placeholder="用户 email">
                        <div class="input-group-prepend">
                            <button type="button" id="userDataSearch" class="btn btn-primary">
                                检索
                            </button>
                        </div>
                    </div>
                </div>
                <div id="userDataDetail">


                </div>
            </main>
        </div>
    </div>

    @include('global.global_footer')
</body>

</html>