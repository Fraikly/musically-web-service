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

    <title>Домашняя страница</title>

</head>
<body class="centerCircle">
<div class="rightText">
    Войти в систему
</div>
<div class="centerBlock">
<p>Добро пожаловать</p>
<lable>для начала подбора песен создайте аккаунт или продолжите как гость</lable>

    <button class="registrationButton">Создать аккаунт</button>
    <button class="guestButton">Войти как гость</button>
</div>
</body>
</html>
