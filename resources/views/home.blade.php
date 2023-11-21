@extends('common')

@section('head_script')
    

@endsection

@section('page')

<div class="right_box">
    <div class="bread_crumb">
        <i class="bi bi-house-fill"></i>
        <span class="path"><a href="{{ url('home') }}">首頁</a></span>
    </div>
    <div class="main">
        <h1>首頁</h1>
        <img src="{!! $inlineUrl !!}">

    </div>
</div>

@endsection


@section('script_js')

<script>

$(function () 
{
    $(".btn_delete_log")
        .on("mouseover", function() {
            $(this).html('<i class="bi bi-trash3-fill"></i>');
        })
        .on("mouseout", function() {
            $(this ).html('<i class="bi bi-trash3"></i>');
        });

    $('#add_log').on('click', function() {
        location.href = "{{ route('log_form')}}";
    })

})

</script>

@endsection
