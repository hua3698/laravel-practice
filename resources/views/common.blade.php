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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="{{ asset('plugins/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('plugins/vendors/animate.css/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom Theme Style -->
    <link href="{{ asset('plugins/build/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

    <script src="{{ asset('plugins/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

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
                <!-- <div class="nav_link"><span><a href="{{ url('home')}}">首頁</a></span></div>
                <div class="nav_link"><span><a href="{{ url('log/list?page=1') }}">機房日誌</a></span></div>
                <div class="nav_link"><span>會員管理</span></div> -->
                @if (session()->get('username'))
                    <div class="nav_link" style="color: #f7f7f7;">{{ session()->get('username') }}，<span><a href="{{ url('logout')}}">登出</a></span></div>
                @else
                    <div class="nav_link"><span><a href="{{ url('login')}}">登入</a></span></div>
                @endif
            </div>
        </div>
    </div>

    <div class="content_body">
        <div class="content_container row">
            <div class="content_left col-2">
                <div class="left_box">
                    <div class="left_box_item main_list" data-tag="log">
                        <div class="item_dropdown">
                            <a href="{{ url('log/list?page=1') }}" class="col-9">機房日誌</a>
                            <i class="bi bi-chevron-down col-3"></i>
                        </div>
                    </div>
                    <div class="left_box_item sub_list" data-tag="log">
                        <div class="">
                            <a href="{{ url('log/form') }}">新增機房日誌</a>
                        </div>
                    </div>
                    <div class="left_box_item main_list" data-tag="member">
                        <div class="item_dropdown">
                            <a href="{{ url('member') }}" class="col-9">會員管理</a>
                            <i class="bi bi-chevron-down col-3"></i>
                        </div>
                    </div>
                    <div class="left_box_item sub_list" data-tag="member">
                        <div class="">
                            <a href="{{ url('log/form') }}">新增會員</a>
                        </div>
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

    <script>
        $(function() {
            $('.sub_list').hide();

            $('.main_list').on('click', function() {
                let tag = $(this).data('tag')

                $('.sub_list').each(function() {
                    var sub_tag = $(this).data('tag');
                    if (sub_tag === tag) {
                        $(this).slideDown()
                    }
                });
            })
        })
    </script>

</body>

</html>