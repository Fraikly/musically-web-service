<html>
<head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="{{ url('favicon.png') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/backgrounds.css')}}">
    <link rel="stylesheet" href="{{ url('css/searchSongs.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koh+Santepheap&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koh+Santepheap&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Домашняя страница</title>

</head>
<body class="upCircle">
@csrf
@include('layouts.burger')
<div class="centerBlock" style="top: 30%">
    <p>Начнем поиски</p>
    <lable>найдите понравившуюся вам песню или получите случайную</lable>
    <div class="search-page__input">
        <input type="text" id="search">
        <img src="{{ url('image/loop.png') }}" alt="Loop" style="cursor:pointer" id="loop">
    </div>

</div>
</body>
</html>

<script>
    $(document).ready(function () {
        if (localStorage.getItem('token')) {
            $('#3').css('display', 'block');
        }
    });

    $('#loop').click(function () {
        window.location.href = '/search?name=' + $('#search').val();
    });


</script>
