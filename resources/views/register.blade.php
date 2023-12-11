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
    <!-- NProgress -->
    <!-- <link href="{{ asset('plugins/vendors/nprogress/nprogress.css') }}" rel="stylesheet"> -->
    <!-- Animate.css -->
    <link href="{{ asset('plugins/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('plugins/build/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/claire.css') }}" rel="stylesheet">

    <script src="{{ asset('plugins/jquery-3.7.1.min.js') }}"></script>


</head>

<body class="login">
    <div>

        <div class="login_wrapper">
            <div id="register" class="animate form registration_form" style="opacity: unset;">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div><a id="btn_register" class="btn btn-secondary submit" href="">Submit</a></div>
                        <div class="clearfix"></div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {

            let init_event = function() {
                $('#btn_register').on('click', function(e) {

                    e.preventDefault()

                    let name = $('#register input[type=text]').val()
                    let email = $('#register input[type=email]').val()
                    let password = $('#register input[type=password]').val()

                    if (!name || !email || !password) return

                    let post_data = {}
                    post_data.name = name
                    post_data.email = email
                    post_data.password = password

                    $.post("{{ route('signUp') }}", post_data, function(re) {
                        location.href = 'home'
                        // if(re['status'] == 'ok') {
                        //     $('.login-qrcode-img').html(re['qrcode_img'])
                        // }
                    })
                })

            }

            let init_login_Page = function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            init_login_Page()
            init_event()
        })
    </script>

</body>

</html>