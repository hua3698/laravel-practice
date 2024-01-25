<!-- <div class="login_wrapper">
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

            </form>
        </section>
    </div>
</div> -->



@extends('common')

@section('head_script')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sceditor@3/minified/themes/default.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sceditor@3/minified/sceditor.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path"><a href="{{ url('log/list?page=1') }}">使用者</a></span>
        <span class="path">
            @if (isset($title))
            {{ $title }}
            @else
            新增使用者
            @endif
        </span>
    </div>

    @if ($errors->any())
    <div class="error_msg rounded">
        {{ $errors->first() }}
        <span class="error_msg_close"><i class="bi bi-x-lg"></i></span>
    </div>

    @endif

    <div class="main">
        <div class="title">
            <p>
                @if (isset($title))
                {{ $title }}
                @else
                新增使用者
                @endif
            </p>
        </div>
        <div class="table_container">
            <form id="register" class="g-3">
                @csrf

                <div class="form-group row">
                    <div class="mb-3 col-4">
                        <label for="account_name" class="form-label">使用者帳號：</label>
                        <input type="text" class="form-control" name="account_name" placeholder="Username" required="">
                    </div>
                    <div class="mb-3 col-4">
                        <label for="account_email" class="form-label">使用者信箱：</label>
                        <input type="email" class="form-control" name="account_email" placeholder="Email" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mb-3 col-4">
                        <label for="password" class="form-label">使用者密碼：</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required="">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="mb-3 col-4">
                        <label for="role" class="form-label">使用者身分</label>
                        <select id="role" class="form-select">
                            <option value="normal" selected>一般使用者</option>
                            <option value="admin">管理者</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 submit_div">
                    <button id="btn_register" type="submit" class="btn btn-primary">確認送出</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@section('script_js')

<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    $(function() {

        let init_event = function() {
            $('#btn_register').on('click', function(e) {

                e.preventDefault()

                let name = $('#register input[type=text]').val()
                let email = $('#register input[type=email]').val()
                let password = $('#register input[type=password]').val()
                let role = $('#register #role').val()

                if (!name || !email || !password) return false;
                if (name.length > 30) {
                    alert('使用者帳號長度最多30')
                    return false;
                }

                if(password.length < 8 || password.length > 30) {
                    alert('密碼長度需大於8');
                    return false;
                }

                let regularExpression  = /^(?=.*[0-9])(?=.*[!@#$%^&*_-])[a-zA-Z0-9!@#$%^&*_-]{8,30}$/;
                if(!regularExpression.test(password)) {
                    alert("密碼不合格，至少要有英文、數字、及特殊符號!@#$%^&*_-");
                    return false;
                }

                let post_data = {}
                post_data.name = name
                post_data.email = email
                post_data.password = password
                post_data.role = role

                $.post("{{ route('createMember') }}", post_data, function(re) {
                    if (re['status'] == 'ok') {
                        alert('新增成功')
                        clearInput()
                    } else {
                        console.log(re)
                        alert(re)
                    }
                })
                .done(function(re) {
                })
                .fail(function(re) {
                    alert(re.responseText)
                })
            })
        }

        let clearInput = function() {
            $('#register input[type=text]').val('')
            $('#register input[type=email]').val('')
            $('#register input[type=password]').val('')
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

@endsection