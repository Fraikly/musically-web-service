<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="{{ url('favicon.png') }}">
    <title>Похожие песни</title>

    <link rel="stylesheet" href="{{ url('css/song-page.css') }}">
</head>
<body>
<main class="main search-page">
    @include('layouts.burger')
    <div class="song-page__content">
        <div class="song-page__song" id="list">

        </div>
    </div>
</main>

<script>
    var songs = <?php echo json_encode($tracks) ?>;
    var ids = ['668487164'];
    showSong();


    function showSong() {
        $('#list').empty();
        try {
            var songImage = $("<div class='song__image'><img src=" + songs[0]['image'] + ">");
            songImage.append("</div>");

            $('#list').append(songImage);

            var songName = $("<span class='song__name'>" + songs[0]['title'] + "</span>");
            $('#list').append(songName);

            var songArtist = $("<span class='song__author'>" + songs[0]['artist'] + "</span>");
            $('#list').append(songArtist);

            var songUrl = $("<audio controls='controls' class='song__controls' autoplay='true'> <source src=" + songs[0]['url'] + " type='audio/mp3'></audio>")
            $('#list').append(songUrl);

            var songButton = $("<div class='song__btns'><img id=" + songs[0]['id'] + " src= <?php echo url('image/dislike.svg') ?> onclick='deleteSong(this.id)'><img src= <?php echo url('image/fav.svg') ?> onclick='getError()'><img id=" + songs[0]['id'] + " src= <?php echo url('image/like.svg') ?> onclick='getSim(this.id)'></div>");
            $('#list').append(songButton);
        } catch (err) {
            var error = $("<span class='song__name'>Ой, кажется, подобранные песни кончились <br> <center> <a href='/search' style='color: #1e1e1e;text-decoration: underline;'> Найдите новую песню  </a> <center> </span>");
            $('#list').append(error);
        }

    }

    function getError() {
        window.alert('Функция находится в разработке');
    }

    function deleteSong(songId) {
        ids.push(songId);
        songs.shift();
        showSong();
    }

    function getSim(songId) {

        $.ajax({
            type: 'GET',
            url: 'http://127.0.0.1:8000/api/get_similarities?songId=' + songId,
            dataType: 'json',
            success: function (data) {
                deleteSong(songId);
                $.each(data, function (index, obj) {
                    if (!ids.includes(obj['id'])) {
                        songs.push(obj);
                    }
                });
            },
            error: function (data) {
                console.log(data);
            }

        });
        showSong();
    }
</script>
</body>
</html>

