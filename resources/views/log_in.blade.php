<html>
<head>
    <meta charset="utf-8">
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
        <p>Вход в систему</p>

        <input type="text" required placeholder="Введите электронную почту">
        <input type="password" required placeholder="Введите пароль">

        <button>Войти</button>
        <label>Еще нет аккаунта? Зарегистрируйтесь</label>
    </div>
</div>
</div>
</body>
</html>
