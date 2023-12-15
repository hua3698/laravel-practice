@extends('common')

@section('head_script')


@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path">會員管理</span>
    </div>

    <div class="main">
        <div class="title">
            <p>會員管理</p>
        </div>

        <div class="table_content">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">會員名稱</th>
                        <th scope="col">登入帳號</th>
                        <th scope="col">會員信箱</th>
                        <th scope="col">帳號新增時間</th>
                        <th scope="col">google 2FA</th>
                        <th scope="col">帳號狀態</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($lists))
                    @foreach ($lists as $index => $list)
                    <tr class="member_tr">
                        <th scope="row">{{ $from + $index }}</th>
                        <td class="">{{ $list['name'] }}</td>
                        <td class="">{{ $list['name'] }}</td>
                        <td class="">{{ $list['email'] }}</td>
                        <td>{{ $list['created_at'] }}</td>
                        <td class="qrcode-td">
                            <span class="qrcode">2FA QRCode</span>
                            <div class="qrcode-img">{!! $list['qrcode'] !!}</div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-secondary btn-sm">Secondary</button>
                        </td>
                        <td>
                            <i class="bi bi-ban"></i>停用帳號
                        </td>
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
        // delete modal

    })
</script>

@endsection