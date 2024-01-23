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
                        <th>reset button</th>
                        <th>reset時間</th>
                        <th scope="col">是否已啟用驗證</th>
                        <th scope="col">使用者身分</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($list))
                    @foreach ($list as $index => $list)
                    <tr class="member_tr">
                        <th scope="row">{{ $from + $index }}</th>
                        <td class="name">{{ $list['name'] }}</td>
                        <td class="email">{{ $list['email'] }}</td>
                        <td>{{ $list['created_at'] }}</td>
                        <td>{{ $list['google2fa_secret'] }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-secondary renewKey">reset key</button>
                        </td>
                        <td>{{ $list['updated_at'] }}</td>
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
        $('.renewKey').on('click', function () {

            let post_data = {}
            post_data.email = $(this).closest('.member_tr').find('.email').html().trim()

            $.ajax({
                type: 'PUT',
                url: "{{ route('renewOne') }}",
                contentType: 'application/json',
                data: JSON.stringify(post_data),
            }).done(function (re) {
                alert('修改成功')
                location.reload()
            }).fail(function (msg) {
                alert('系統錯誤')
                // console.log(msg)
                // location.href = "{{ url('home') }}"
            }).always(function (msg) {
                // console.log('ALWAYS');
            });

        })

        $('#select_count').on('change', function () {
            let count = $(this).val()
            location.href = "?count=" + count
        })
    })
</script>

@endsection