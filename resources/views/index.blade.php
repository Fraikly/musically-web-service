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

    <title>Music helper</title>

</head>
<body class="centerCircle">
<div class="rightText" id="3">
    Войти в систему
</div>
<div class="centerBlock">
    <p>Добро пожаловать</p>
    <lable>для начала подбора песен создайте аккаунт или продолжите как гость</lable>

    <button class="registrationButton" id="1">Создать аккаунт</button>
    <button class="guestButton" id="2">Войти как гость</button>
</div>
</body>
</html>
<script>
    $('#1').click(function () {
        window.location.href = '/register';
    })
    $('#2').click(function () {
        window.location.href = '/home';
    })
    $('#3').click(function () {
        window.location.href = '/login';
    })
</script>
