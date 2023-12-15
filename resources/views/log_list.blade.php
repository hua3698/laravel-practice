@extends('common')

@section('head_script')


@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
        <span class="path">機房日誌</span>
    </div>

    @if (isset($create_success))
    <div class="error_msg rounded" style="background-color: #d1e7dd;">
        {{ $create_success }}
        <span class="error_msg_close"><i class="bi bi-x-lg"></i></span>
    </div>
    @endif

    <div class="main">
        <div class="title">
            <p>機房日誌</p>
        </div>
        <div>

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
                            <th scope="row">{{ $from + $index }}</th>
                            <td class="server_log_id">{{ $list['server_log_id'] }}</td>
                            <td class="maintain_man">{{ $list['maintain_man'] }}</td>
                            <td class="types">{{ $list['types'] }}</td>
                            <td class="more">
                                <span class="work_description">更多</span>
                            </td>
                            <td>{{ $list['maintain_date']}} {{ $list['enter_time'] }} ~ {{ $list['exit_time'] }}</td>
                            <td>{{ $list['created_at'] }}</td>
                            <td class="btn_delete_log" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <i class="bi bi-trash3"></i>
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

                    @for ($i = 1; $i <= $last_page; $i++) 
                        <li class="page-item">
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">確定要刪除這筆日誌嗎?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal_number">日誌編號： <span></span></div>
                    <div class="modal_man">維護人員： <span></span></div>
                    <div class="modal_type">類型： <span></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button id="button_delete" type="button" class="btn btn-primary">確定刪除</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script_js')

<script>
    $(function() {
        // delete modal
        let myModal = $('#staticBackdrop')

        $(".btn_delete_log")
            .on('click', function() {
                console.log($(this))
                let parent_tr = $(this).closest('tr')
                let log_id = parent_tr.find('.server_log_id').html()
                let log_man = parent_tr.find('.maintain_man').html()
                let log_type = parent_tr.find('.types').html()

                myModal.find('.modal_number span').html(log_id).end()
                    .find('.modal_man span').html(log_man).end()
                    .find('.modal_type span').html(log_type).end()
                    .find('#button_delete').data('log_id', log_id).end()
                    .trigger('shown.bs.modal')
            });

        $('#button_delete')
            .on('click', function() {
                let log_id = $(this).data('log_id')

                $.ajax({
                    url: '{{ route("log.delete", ":id") }}'.replace(':id', log_id),
                    type: 'PUT',
                    data: "_token={{ csrf_token() }}",
                    success: function(data) {
                        location.href = "{{ route('log_list', ['create_success' => '刪除成功']) }}"
                    }
                });
            });

        $('.more')
            .on('click', function() {
                let log_id = $(this).closest('tr').find('.server_log_id').html()
                // console.log(log_id)

                location.href = log_id;
            })
    })
</script>

@endsection