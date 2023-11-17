<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','管理後台')</title>

    <!-- Bootstrap -->
    <link href="{{ asset('plugins/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('plugins/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('plugins/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Theme Style -->
    <link href="{{ asset('plugins/build/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    
    <script src="{{ asset('plugins/jquery-3.7.1.min.js') }}"></script>


    @yield('head_script')
</head>


<!-- https://doit.gov.taipei/Content_List.aspx?n=24B0D4D1DE246465 -->

<body class="">
    <div class="header">
        <div class="header_container">
            <div class="logo">
                <img src="https://fakeimg.pl/100x40/">
                <span>機房網站</span>
            </div>
            <div class="nav">
                <div class="nav_link"><span><a href="{{ url('home')}}">首頁</a></span></div>
                <div class="nav_link"><span><a href="{{ url('log/show') }}">機房日誌</a></span></div>
                <div class="nav_link"><span>首頁</span></div>
                <div class="nav_link"><span>首頁</span></div>
            </div>
        </div>
    </div>

    <div class="content_body">
        <div class="content_container row">
            <div class="content_left col-2">
                <div class="left_box">
                    <div class="left_box_item">
                        <div class="item_dropdown">
                            <a href="{{ url('log/show') }}">日誌</a>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    <div class="left_box_item">

                    </div>
                    <div class="left_box_item">

                    </div>
                </div>
            </div>
            <div class="content_right col-10">

                @yield('page')
            </div>
        </div>
    </div>

    <div class="footer"></div>

    @yield('script_js')

</body>

</html>
