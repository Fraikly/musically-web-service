<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ url('favicon.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/backgrounds.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koh+Santepheap&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koh+Santepheap&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Регистрация</title>

</head>
<body class="centerGradient">
<div class="centerBlock">



    <div class="authorizationBlock">
        <p>Регистрация</p>

        <form method="post" id="handleAjax" name="postform">
            @csrf
        <input type="text" required placeholder="Введите логин" name="login">
            <span class="text-danger"  id="login"></span>
        <input type="text" required placeholder="Введите электронную почту" name="email">
            <span class="text-danger"  id="email"></span>
        <input type="password" required placeholder="Введите пароль" name="password">
            <span class="text-danger"  id="password"></span>
        <input type="password" required placeholder="Повторите пароль" name="password_confirmation">

        <button type="submit">Создать аккаунт</button>
        <label>У вас уже есть аккаунт? <a href="{{route('login')}}">Водите</a> </label>
        </form>
    </div>
</div>
</div>
</body>
</html>

<script>
    $(document).on("submit", "#handleAjax", function() {
        var e = this;

        $(this).find("[type='submit']").html("Подождите...");

        $.ajax({
            url: '/api/auth/register',
            data: $(this).serialize(),
            type: "POST",
            dataType: 'json',
            success: function (data) {
                localStorage.setItem('token', data.token);
                window.location.href = '/home';
            },
            error: function (data) {
                    $('#email').text('');
                    $('#login').text('');
                    $('#password').text('');
                    $('#password_confirmation').text('');
                    $.each(data.responseJSON.errors, function (key, val) {
                        $('#' + key).text(val);
                    });

                $(this).find("[type='submit']").html("Создать аккаунт");

            }
        });
        return false;
    });
</script>
