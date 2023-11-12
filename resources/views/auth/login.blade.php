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

    <title>Вход в систему</title>

</head>
<body class="centerGradient">
<div class="centerBlock">


    <div class="authorizationBlock">
        <form method="post" id="handleAjax" name="postform">
            @csrf
            <p>Вход в систему</p>

            <input type="text" required placeholder="Введите электронную почту" name="email">
                <span class="text-danger"  id="email"></span>

            <input type="password" required placeholder="Введите пароль" name="password">
                <span class="text-danger password"  id="password"></span>

            <button type="submit">Войти</button>
            <label>Еще нет аккаунта? <a href="/register"> Зарегистрируйтесь </a> </label>
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
            url: '/api/auth/login',
            data: $(this).serialize(),
            type: "POST",
            dataType: 'json',
            success: function (data) {
                localStorage.setItem('token', data.token);
                window.location.href = '/home';
            },
            error: function (data) {
                if (data.status === 401) {
                    $('#email').text('Проверьте правильность написания логина и пароля');
                } else if (data.status === 404) {
                    $('#email').text('Пользователь с такой почтой не найден');
                } else {
                    $('#email').text('');
                    $('#password').text('');
                    $.each(data.responseJSON.errors, function (key, val) {
                        $('#' + key).text(val);
                    });
                }
            }
        });

        return false;
    });
</script>
