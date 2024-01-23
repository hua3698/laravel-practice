@extends('common')

@section('head_script')
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

        <div class="search_bar">
            <div class="row mb-3">
                <label for="keyword" class="col-sm-2 col-form-label">關鍵字搜尋：</label>
                <div class="col-4">
                    <input type="text" class="form-control" id="keyword" placeholder="維護編號/維護人員">
                </div>
            </div>
            <div class="row mb-3">
                <label for="date_picker" class="col-sm-2 col-form-label">維護日期：</label>
                <div class="col-4">
                    <input id="date_picker" class="form-control" type="text" name="date_picker" value="" />
                </div>
            </div>
            <div class="text-center">
                <button id="btnSearch" class="btn btn-sm btn-primary">查詢</button>
                <button id="btnClear" class="btn btn-sm btn-secondary">清空</button>
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
                <select id="select_count" class="form-select">
                    <option value="5" {{ ( $count == 5 ) ? 'selected' : '' }}>5</option>
                    <option value="10" {{ ( $count == 10 ) ? 'selected' : '' }}>10</option>
                    <option value="20" {{ ( $count == 20 ) ? 'selected' : '' }}>20</option>
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
        let active_calendar = 0
        // delete modal0
        let myModal = $('#staticBackdrop')

        let set_datepicker = function() {
            let today = new Date();
            let str_today = dateFormat(today)

            $('#date_picker').daterangepicker({
                "singleDatePicker": true,
                "showCustomRangeLabel": false,
                "startDate": str_today,
                maxDate: str_today,
                locale: {
                    format: 'YYYY/MM/DD',
                    applyLabel: "確認",
                    cancelLabel: "取消",
                    customRangeLabel: "自訂區間",
                    daysOfWeek: [
                        "日",
                        "一",
                        "二",
                        "三",
                        "四",
                        "五",
                        "六"
                    ],
                    monthNames: [
                        "1 月",
                        "2 月",
                        "3 月",
                        "4 月",
                        "5 月",
                        "6 月",
                        "7 月",
                        "8 月",
                        "9 月",
                        "10 月",
                        "11 月",
                        "12 月"
                    ],
                }
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });
        }

        $(".btn_delete_log")
            .on('click', function() {
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

        $('#btnSearch')
            .on('click', function() {
                let keyword = $('#keyword').val().trim()
                let maintain_date = $('#date_picker').val().trim()

                let req_data = {}
                if (keyword) {
                    req_data.keyword = keyword
                }

                if (maintain_date) {
                    req_data.maintain_date = maintain_date
                }

                console.log(req_data)

                $.ajax({
                    type: 'GET',
                    url: "{{ route('log/search') }}",
                    contentType: 'application/json',
                    data: req_data,
                })
                .done(function(re) {
                    // alert('修改成功')
                    // location.reload()
                })
                .fail(function(msg) {
                    // console.log(msg)
                    // alert('系統錯誤')
                    // location.href = "{{ url('home') }}"
                })
                .always(function(msg) {
                    console.log('ALWAYS');
                });
            })

        $('#btnClear')
            .on('click', function() {
                $('#keyword').val('')
                $('#date_picker').val('')
            })

        $('#date_picker')
            .on('cancel.daterangepicker', function(e, picker) {
                $('#date_picker').val('');
            })
            .on('mousedown', () => {

                if (!active_calendar) {
                    set_datepicker()
                }

                active_calendar = 1
            })

        $('#select_count')
            .on('change', function () {
                let count = $(this).val()
                location.href = "?count=" + count
            })
    })
</script>

@endsection