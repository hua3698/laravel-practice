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
        <span class="path">日誌</span>
        <span class="path">新增日誌</span>
    </div>

    @if ($errors->any())
    <div class="error_msg rounded">
        {{ $errors->first() }}
        <span class="error_msg_close"><i class="bi bi-x-lg"></i></span>
    </div>
    <!-- <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> -->
    @endif

    <div class="main">
        <div class="title">
            <p>新增日誌</p>
        </div>
        <div class="table_container">
            <form class="row g-3" action="{{ url('log/create') }}" method="POST">
                @csrf

                <div class="mb-3 col-12">
                    <label for="">維護類型：</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="maintain_type" id="inlineRadio1" value="1" checked>
                        <label class="form-check-label" for="inlineRadio1">日常巡視</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="maintain_type" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2">維修</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="maintain_type" id="inlineRadio3" value="3" disabled>
                        <label class="form-check-label" for="inlineRadio3">3 (disabled)</label>
                    </div>
                </div>

                <div class="mb-3 col-4">
                    <label for="maintain_man" class="form-label">維護人員：</label>
                    <input type="text" class="form-control" name="maintain_man" id="maintain_man">
                </div>
                <div class="mb-3 col-8"></div>

                <div class="mb-3 col-4">
                    <label for="date_picker" class="form-label">維護日期：</label>
                    <input id="date_picker" class="form-control" type="text" name="maintain_date" value="" />
                </div>
                <div class="mb-3 col-8"></div>
                <div class="mb-3 col-4">
                    <label for="entrance_time" class="form-label">進入時間：</label>
                    <input type="text" class="form-control" id="entrance_time" name="entrance_time">
                </div>
                <div class="mb-3 col-4">
                    <label for="exit_time" class="form-label">離開時間：</label>
                    <input type="text" class="form-control" id="exit_time" name="exit_time">
                </div>
                <div class="mb-3 col-4"></div>

                <div class="mb-3">
                    <label for="work_desc" class="form-label">工作內容：</label>
                    <textarea name="work_desc" id="work_desc" cols="150" rows="20"></textarea>
                </div>
                <div class="col-12 submit_div">
                    <button type="submit" class="btn btn-primary">確認送出</button>
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
        const editor = ClassicEditor
            .create(document.querySelector('#work_desc'), {
                width: "400px",
                height: "500px"
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });

        // editor.setData('<p>Modified from the console!</p>');
        // var instance = sceditor.instance(textarea);
        // instance.val('aaa');

        let startDate = '2023/05/15';

        $('input[name="dates"]').daterangepicker();
        $('#date_picker').daterangepicker({
            "singleDatePicker": true,
            "showCustomRangeLabel": false,
            "startDate": startDate,
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

        $('.right_box').on('click', '.error_msg_close', function() {
            $(this).parent().hide()
        })
    })
</script>

@endsection