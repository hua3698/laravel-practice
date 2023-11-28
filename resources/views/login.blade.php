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
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div id="login" class="animate form login_form">
                <section class="login_content">
                    <form>
                        <h1>Login Form</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <input type="text" name="google2fa_otp" class="form-control" placeholder="OTP (enter six number)" />
                        </div>
                        <!-- <div class="lost_pass_div">
                <a class="" href="#">Lost your password?</a>
              </div> -->
                        <div style="margin: 40px 0 0px;">
                            <a id="btn_login" class="btn btn-secondary submit" href="">Log in</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">
                            <p class="change_link">New to site?
                                <a href="#signup" class="to_register"> Create Account </a>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
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
                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
                            </p>
                            <div class="clearfix"></div>
                        </div>
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
                        location.href = 'login#signin'
                    })
                })

                $('#btn_login').on('click', function(e) {
                    e.preventDefault()

                    let name = $('#login input[type=text]').val()
                    let password = $('#login input[type=password]').val()
                    let otp = $('#login input[name=google2fa_otp]').val()

                    if (!name || !password || !otp) return

                    let post_data = {}
                    post_data.name = name
                    post_data.password = password
                    post_data.google2fa_otp = otp

                    $.post("{{ route('signIn') }}", post_data, function(re) {
                        console.log(re)
                        // location.href = 'home'
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