<html>

<head>
    @include('global.global_header')
</head>

<body>
    @include('global.global_navbar')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2" style="background-color:lavender;">
                @include('global.global_sidebar')
            </div>
            <div class="col-sm-10" style="background-color:lavenderblush;">.col-sm-8</div>
        </div>
    </div>
    @foreach ($data as $key => $value)
    {{$key}}: {{$value}}
    @endforeach
</body>

</html>