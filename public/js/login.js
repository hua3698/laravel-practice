$(function() {

    $('#btn_register').on('click', function (e) {

        let user = $('#register input[type=text]').val()
        let email = $('#register input[type=email]').val()
        let password = $('#register input[type=password]').val()

        if(!user || !email || !password) return

        let post_data = {}
        post_data.user = user
        post_data.email = email
        post_data.password = password

        $.post("{{ route('createaccount') }}", post_data, function(re) {

        })


        console.log(user)
        console.log(email)
        console.log(password)

        e.preventDefault()
    })

    $('#btn_login').on('click', function () {
        e.preventDefault()

    })

    let init_login_Page = function () {
        $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
    }

    init_login_Page()
})