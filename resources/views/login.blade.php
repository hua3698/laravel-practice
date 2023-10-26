@extends('login_template')

@section('script_js')
<script type="text/javascript">


$(function() {

    let init_event = function () {
        $('#btn_register').on('click', function (e) {

            e.preventDefault()

            let name = $('#register input[type=text]').val()
            let email = $('#register input[type=email]').val()
            let password = $('#register input[type=password]').val()

            if(!name || !email || !password) return

            let post_data = {}
            post_data.name = name
            post_data.email = email
            post_data.password = password

            $.post("{{ route('signUp') }}", post_data, function(re) {
                location.href = 'login#signin'
            })
        })

        $('#btn_login').on('click', function (e) {
            e.preventDefault()

            let name = $('#login input[type=text]').val()
            let password = $('#login input[type=password]').val()

            if(!name || !password) return

            let post_data = {}
            post_data.name = name
            post_data.password = password

            $.post("{{ route('signIn') }}", post_data, function(re) {
                location.href = 'greet'
            })
        })
    }

    let init_login_Page = function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    init_login_Page()
    init_event()
})
</script>

@endsection

