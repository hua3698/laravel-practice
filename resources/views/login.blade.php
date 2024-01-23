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
            <div class="animate form login_form">
                <section class="login_content">
                    <form>
                        <h1>Login Form</h1>
                        <div id="login_div" class="control_div">
                            <div>
                                <input type="text" class="form-control" placeholder="Username" required="" autofocus/>
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div style="margin: 40px 0 0px;">
                                <a href="" id="btn_login" class="btn btn-secondary">登入</a>
                            </div>
                        </div>
                        <div id="otp_div" class="control_div" style="display: none;">
                            <div style="text-align: left;">
                                <label for="2fa">請輸入Google OTP驗證碼</label>
                                <input type="text" name="google2fa_otp" class="form-control" placeholder="OTP (enter six number)"/>
                            </div>
                            <div style="margin: 40px 0 0px;">
                                <a href="" id="btn_otp" class="btn btn-secondary">驗證</a>
                            </div>
                        </div>
                        <div id="qrcode_div" class="control_div" style="display: none;">
                            <div>
                                <h2>QR code</h2>
                                <p>打開Authenticator APP，掃描QR CODE，下次登入需要</p>
                                <div id="qrcode-img"></div>
                            </div>
                            <div style="margin: 40px 0 0px;">
                                <a href="" id="btn_qrcode" class="btn btn-secondary">儲存後，回首頁</a>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(function() {

            let username = ''
            let password = ''

            let init_event = function() {

                $('#btn_login').on('click', function(e) {
                    e.preventDefault()

                    username = $('#login_div input[type=text]').val()
                    password = $('#login_div input[type=password]').val()

                    if (!username || !password) return

                    let post_data = {}
                    post_data.name = username
                    post_data.password = password
                    // post_data.google2fa_otp = otp

                    $.post("{{ route('signIn') }}", post_data, function(re) {

                        let response = JSON.parse(re)

                        $('.control_div').hide()
                        if(response.show_div === 'qrcode') {
                            $('#qrcode-img').html(response.qrcode_img)
                            $('#qrcode_div').show()
                        } else if(response.show_div === 'otp') {
                            $('#otp_div').show()
                            $('#otp_div input[name=google2fa_otp]').focus()
                        }
                    })
                });

                $('#btn_qrcode').on('click', function(e) {

                    e.preventDefault()

                    location.href = '{{ url("home") }}';
                })

                $('#btn_otp').on('click', function(e) {

                    e.preventDefault()

                    let otp = $('#otp_div input[name=google2fa_otp]').val()
                    if (!otp) return

                    let post_data = {}
                    post_data.name = username
                    post_data.otp = otp

                    $.post("{{ route('validOTP') }}", post_data, function(re) {
                        if(re == 'ok') {
                            location.href =  '{{ url("home") }}';
                        } else {
                            alert('系統錯誤，請聯絡管理者')
                        }

                    })
                })

                $('input[type=password]').keypress(function (e) {
                    let key = e.which
                    if(key == 13) {
                        $('#btn_login').click();
                        return false;  
                    }
                });

                $('input[name=google2fa_otp]').keypress(function (e) {
                    let key = e.which
                    if(key == 13) {
                        $('#btn_otp').click();
                        return false;  
                    }
                });   
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