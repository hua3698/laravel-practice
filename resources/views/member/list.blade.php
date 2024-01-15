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
            <p>使用者管理</p>
            <div>
                <button id="renewKey" type="button" class="btn btn-outline-secondary">重新產生key</button>
            </div>
        </div>

        <div class="table_content">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">登入帳號</th>
                        <th scope="col">使用者信箱</th>
                        <th scope="col">帳號新增時間</th>
                        <th scope="col">Key</th>
                        <th scope="col">是否已啟用驗證</th>
                        <th scope="col">使用者身分</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($list))
                    @foreach ($list as $index => $list)
                    <tr class="member_tr">
                        <th scope="row">{{ $from + $index }}</th>
                        <td class="">{{ $list['name'] }}</td>
                        <td class="">{{ $list['email'] }}</td>
                        <td>{{ $list['created_at'] }}</td>
                        <td>{{ $list['google2fa_secret'] }}</td>
                        <td>{{ $list['is_enable_qrcode'] }}</td>
                        <td>{{ $list['role'] }}</td>
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
                        <a class="page-link" href="{{ route('log_list', ['page'=>$current_page -1]) }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $last_page; $i++) <li class="page-item">
                        <a class="page-link" href="{{ route('log_list', ['page'=>$i]) }}">{{ $i }}</a>
                        </li>
                        @endfor

                        <li class="page-item">
                            <a class="page-link" href="{{ route('log_list', ['page'=>$last_page]) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                </ul>
            </nav>

            <div class="select_page">
                <span>每一頁</span>
                <!-- <div class="row"> -->
                <select class="form-select">
                    <option value="1" selected>5</option>
                    <option value="2">10</option>
                    <option value="3">20</option>
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
        $('#renewKey').on('click', function () {

            $.ajax({
                type: 'PUT',
                url: "{{ route('memberRenewKey') }}",
                contentType: 'application/json',
                // data: JSON.stringify(data),
            }).done(function (re) {
                alert('修改成功')
                location.reload()
            }).fail(function (msg) {
                console.log(msg)
                alert('系統錯誤')
                // location.href = "{{ url('home') }}"
            }).always(function (msg) {
                console.log('ALWAYS');
            });

        })
    })
</script>

@endsection