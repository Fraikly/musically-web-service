<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="icon" href="{{ url('favicon.png') }}">
<title>Похожие песни</title>

<div id="songs">
    @foreach($tracks as $track)
        <div id="{{$track['id']}}">
            <br>
            <img src="{{$track['image']}}">
            <p>{{$track['title']}}</p>
            <p>{{$track['artist']}}</p>
            <audio controls="controls">
                <source src="{{$track['url']}}" type="audio/mp3" controls="false"/>
            </audio>
            <button value="{{$track['id']}}" onclick='getSim(this.value)'>Мне нравится</button>
            <button value="{{$track['id']}}" onclick='deleteSong(this.value)'>Мне не нравится</button>
        </div>
    @endforeach
</div>
</html>

<script>
    const audioList = document.querySelectorAll('audio')
    let currentAudio
    var ids = [];

    Array.prototype.forEach.call(audioList, audio => {
        audio.addEventListener('play', e => {
            if (currentAudio) currentAudio.pause()
            currentAudio = e.target
        })
    })

    function deleteSong(songId) {
        $('#' + songId).empty();
    }

    function getSim(songId) {
            ids.push(songId);
            deleteSong(songId);

        $.ajax({
            type: 'GET',
            url: 'http://127.0.0.1:8000/api/get_similarities?songId=' + songId,
            dataType: 'json',
            success: function (data) {
                $.each(data, function (index, obj) {
                    if (!ids.includes(parseInt(obj['id']))) {
                        var songs = $(" <div id=" + obj['id'] + ">")
                        songs.append("<br><img src=" + obj['image'] + ">");
                        songs.append("<p>" + obj['title'] + "</p>");
                        songs.append("<p>" + obj['artist'] + "</p>");
                        songs.append("<audio controls='controls'> <source src=" + obj['url'] + " type='audio/mp3' controls='false'/>");
                        songs.append("</audio>");
                        songs.append("<button value=" + obj['id'] + " onclick='getSim(this.value)'>Мне нравится</button>");
                        songs.append("<button value=" + obj['id'] + " onclick='deleteSong(this.value)'>Мне не нравится</button>");
                        songs.append("</div>");

                        $('#songs').append(songs);
                        $('#wait').empty();

                    }
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    }




</script>

