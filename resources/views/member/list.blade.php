@extends('common')

@section('head_script')

@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path">使用者管理</span>
    </div>

    <div class="main">
        <div class="title">
            <p>新增使用者</p>
        </div>
        <div class="create_user">
            <div class="table_container">
                <form id="register" class="g-3">
                    @csrf

                    <div class="form-group row">
                        <div class="mb-3 col-4">
                            <label for="account_name" class="form-label">使用者帳號：</label>
                            <input type="text" class="form-control" name="account_name" placeholder="Username" required="">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="password" class="form-label">使用者密碼：</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="mb-3 col-4">
                            <label for="account_email" class="form-label">使用者信箱：</label>
                            <input type="email" class="form-control" name="account_email" placeholder="Email" required="">
                        </div>
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

        <div class="title">
            <p>使用者管理</p>
        </div>

        <div class="table_content">
            <table class="table table-hover member_table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>登入帳號</th>
                        <th>使用者信箱</th>
                        <th>帳號新增時間</th>
                        <th>Key</th>
                        <th>reset button</th>
                        <th>reset時間</th>
                        <th>是否已啟用驗證</th>
                        <th>使用者身分</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($list))
                    @foreach ($list as $index => $list)
                    <tr class="member_tr">
                        <th scope="row">{{ $from + $index }}</th>
                        <td class="name" title="{{ $list['name'] }}">{{ $list['name'] }}</td>
                        <td class="email" title="{{ $list['email'] }}">{{ $list['email'] }}</td>
                        <td>{{ $list['created_at'] }}</td>
                        <td class="key" title="{{ $list['google2fa_secret'] }}">{{ $list['google2fa_secret'] }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-secondary renewKey">reset key</button>
                        </td>
                        <td>{{ $list['updated_at'] }}</td>
                        <td>{{ $list['is_enable_qrcode'] }}</td>
                        <td>{{ $list['role'] }}</td>
                        <td class="del_member"><i class="bi bi-person-x-fill"></i></td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="div_pagination">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="{{ route('member_list', ['page'=>$current_page -1]) }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $last_page; $i++) <li class="page-item">
                        <a class="page-link" href="{{ route('member_list', ['page'=>$i]) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        <li class="page-item">
                            <a class="page-link" href="{{ route('member_list', ['page'=>$last_page]) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                </ul>
            </nav>

            <div class="select_page">
                <span>每一頁</span>
                <!-- <div class="row"> -->
                <select id="select_count" class="form-select">
                    <option value="5" {{ ($count == 5 ) ? 'selected' : '' }}>5</option>
                    <option value="10" {{ ($count == 10 ) ? 'selected' : '' }}>10</option>
                    <option value="20" {{ ($count == 20 ) ? 'selected' : '' }}>20</option>
                </select>
                <!-- </div> -->
                <span>筆, 共 {{ $total }} 筆</span>
            </div>
        </div>

    </div>

</div>

@endsection


@section('script_js')

<script>
    $(function() {
        $('.renewKey')
            .on('click', function() {
                let post_data = {}
                post_data.email = $(this).closest('.member_tr').find('.email').html().trim()

                $.ajax({
                    type: 'PUT',
                    url: "{{ route('renewOne') }}",
                    contentType: 'application/json',
                    data: JSON.stringify(post_data),
                }).done(function(re) {
                    alert('修改成功')
                    location.reload()
                }).fail(function(msg) {
                    alert('系統錯誤')
                });
            });

        $('.del_member')
            .on('click', function() {
                let post_data = {}
                post_data.email = $(this).closest('.member_tr').find('.email').html().trim()

                let name = $(this).closest('.member_tr').find('.name').html().trim()

                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('delMember') }}",
                    contentType: 'application/json',
                    data: JSON.stringify(post_data),
                    success: function (data) {
                        alert('刪除會員成功：' + name)
                        location.reload()
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        alert("Error occurred: " + error);
                    }
                });
            })

        $('#select_count')
            .on('change', function() {
                let count = $(this).val()
                location.href = "?count=" + count
            })

        $('#btn_register')
            .on('click', function(e) {

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
                        location.reload()
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

        let init_login_Page = function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        init_login_Page()
    })
</script>

@endsection