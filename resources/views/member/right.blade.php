@extends('common')

@php
    $login_email = session()->get('email');
@endphp


@section('page')
<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path">會員權限管理</span>
    </div>

    <div class="main">
        <div class="title">
            <p>會員權限管理</p>
        </div>

        <div class="table_content">
            <table id="member-right-table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">登入帳號</th>
                        <th scope="col">會員信箱</th>
                        <th scope="col">管理權限</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($list))
                    @foreach ($list as $index => $list)
                    <tr>
                        <th scope="row">{{ 1 + $index }}</th>
                        <td>{{ $list['name'] }}</td>
                        <td class="email">{{ $list['email'] }}</td>
                        <td>
                            @if ($list['email'] == $login_email)
                                {{ ($list['role'] == 'normal' ) ? '一般使用者' : '管理員' }}
                            @else
                                <div class="">
                                    <select class="form-select" data-role="{{ $list['role'] }}">
                                        <option value="normal" {{ ($list['role'] == 'normal' ) ? 'selected' : '' }}>一般使用者</option>
                                        <option value="admin" {{ ($list['role'] == 'admin' ) ? 'selected' : '' }}>管理員</option>
                                    </select>
                                </div>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm">儲存</button>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>

</div>

@endsection


@section('script_js')

<script>
    $(function() {
        // delete modal
        $('.form-select').on('change', function () {
            let select_role = $(this).val()
            let origin_role = $(this).data('role')

            if(select_role == origin_role) {
                $(this).closest('tr').find('button').addClass('btn-secondary').removeClass('btn-success')
            } else {
                $(this).closest('tr').find('button').addClass('btn-success').removeClass('btn-secondary')
            }
        })

        $('button').on('click', function () {
            let email = $(this).closest('tr').find('.email').html()
            let modify_role = $(this).closest('tr').find('.form-select').val()

            let data = {}
            data.email = email
            data.modify_role = modify_role

            $.ajax({
                type: 'PUT',
                url: "{{ url('member/right') }}",
                contentType: 'application/json',
                data: JSON.stringify(data),
            }).done(function (re) {
                // alert('修改成功')
                // location.reload()
            }).fail(function (msg) {
                console.log(msg)
                alert('系統錯誤')
                location.href = "{{ url('home') }}"
            }).always(function (msg) {
                console.log('ALWAYS');
            });
        })

        let init_login_Page = function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        let reloadList = function() {

        }

        init_login_Page()
    })
</script>

@endsection 