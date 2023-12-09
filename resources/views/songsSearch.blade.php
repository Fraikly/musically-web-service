<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="icon" href="{{ url('favicon.png') }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Поиск</title>

    <link rel="stylesheet" href="{{ url('css/searchSongs.css') }}">
</head>
<body>
<main class="main search-page">
    @include('layouts.burger')
    <div class="search-page__content">
        <header class="search-page__header">
            <div class="search-page__input">
                <input type="text" id="search" value="{{$search}}">
                <img src="{{ url('image/loop.png') }}" alt="Loop" style="cursor:pointer" id="loop">
            </div>

            <span class="search-page__results-num" id="result">Результаты поиска: {{count($tracks)}}</span>
        </header>

        <ul class="search-page__list" style="display: {{$tracks ? 'flex' : 'none'}}" id="list">
            @foreach($tracks as $track)
                <li class='search-page__item'>
                    <div class='list-item_left'><img src="{{$track['track']['images']['coverart']}}"></div>
                    <div class='list-item_right'>
                        <span class='list-item__title'>{{$track['track']['title']}}</span>
                        <span class='list-item__artist'>{{$track['track']['subtitle']}}</span>
                        <audio controls='controls' class='list-item__controls'>
                            <source src="{{$track['track']['hub']['actions'][1]['uri']}}" type='audio/mp3'
                                    controls='false'/>
                        </audio>
                        <button class='list-item__btn' value="{{ $track['track']['key']}}" onclick='getSim(this.value)'>
                            Найти похожие
                        </button>
                    </div>
            @endforeach
        </ul>
    </div>
</main>

<script>
    function getSim(songId) {
        console.log("a")
        window.location.href = '/get_similarities?songId=' + songId;
    }

    $('#loop').click(function () {
        $.ajax({
            url: '/api/search?name=' + $('#search').val(),
            type: "GET",
            dataType: 'json',
            success: function (data) {
                $('#list').empty();
                $('#result').text("Результаты поиска: " + data.length);

                $.each(data, function (index, obj) {
                    $('#list').css('display', 'flex');

                    obj = obj['track']
                    console.log(obj);
                    var songs = $("<li class='search-page__item'>");
                    songs.append("<div class='list-item_left'> <img src=" + obj['images']['coverart'] + "></div>");
                    songs.append("<div class='list-item_right'>" +
                        "<span class='list-item__title'>" + obj['title'] + "</span>" +
                        "<span class='list-item__artist'>" + obj['subtitle'] + "</span>" +
                        "<audio controls='controls' class='list-item__controls'> <source src=" + obj['hub']['actions'][1]['uri'] + " type='audio/mp3' controls='false'/>" +
                        "</audio>" +
                        "<button class='list-item__btn' value=" + obj['key'] + " onclick='getSim(this.value)'>Найти похожие</button>" +
                        "</div>");
                    songs.append("</li>");
                    $('#list').append(songs);
                });

            },
            error: function (data) {
                console.log(data);

            }
        });
    })
</script>
</body>
</html>
