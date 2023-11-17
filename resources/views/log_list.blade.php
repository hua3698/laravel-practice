@extends('common')

@section('head_script')


@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path">日誌</span>
    </div>
    <div class="main">
        <div class="title">
            <p>日誌</p>
        </div>
        <div>
            <div class="addlog">
                <span id="add_log">新增日誌</span>
            </div>
        </div>
        <div class="table_content">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">維護編號</th>
                        <th scope="col">維護人員</th>
                        <th scope="col">類型</th>
                        <th scope="col">工作內容</th>
                        <th scope="col">人員進出時間</th>
                        <th scope="col">日誌新增時間</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                @if (!empty($lists))
                    @foreach ($lists as $index => $list)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $list['maintain_number'] }}</td>
                        <td>{{ $list['maintain_man'] }}</td>
                        <td>{{ $list['types'] }}</td>
                        <td>
                            <span class="work_description">更多</span>
                        </td>
                        <td>{{ $list['maintain_date']}} {{ $list['enter_time'] }} ~ {{ $list['exit_time'] }}</td>
                        <td>{{ $list['created_at'] }}</td>
                        <td class="btn_delete_log">
                            <i class="bi bi-trash3"></i>
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
        $(".btn_delete_log")
            .on("mouseover", function() {
                $(this).html('<i class="bi bi-trash3-fill"></i>');
            })
            .on("mouseout", function() {
                $(this).html('<i class="bi bi-trash3"></i>');
            });

        $('#add_log').on('click', function() {
            location.href = "{{ route('log_form')}}";
        })

    })
</script>

@endsection