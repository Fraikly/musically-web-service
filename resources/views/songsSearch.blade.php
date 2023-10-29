<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div id="songs">
    @foreach($tracks as $track)
        <div id="{{$track['track']['key']}}">
            <br>
            <img src="{{$track['track']['images']['coverart']}}">
            <p>{{$track['track']['title']}}</p>
            <p>{{$track['track']['subtitle']}}</p>
            <audio controls="controls">
                <source src="{{$track['track']['hub']['actions'][1]['uri']}}" type="audio/mp3" controls="false"/>
            </audio>
            <button value="{{$track['track']['key']}}" onclick="getSim(this.value)">Найти похожие</button>
        </div>
    @endforeach
</div>
</html>

<script>
    const audioList = document.querySelectorAll('audio')
    let currentAudio
    var ids = [];
    var count = 0;

    Array.prototype.forEach.call(audioList, audio => {
        audio.addEventListener('play', e => {
            if (currentAudio) currentAudio.pause()
            currentAudio = e.target
        })
    })

    function deleteSong(songId) {
        ids.push(songId);
        $('#' + songId).empty();
    }

    function getSim(songId) {
        if(count === 0 ) {
            ids.push(songId);
            $('#songs').empty();
            count = 1;
        } else {
            deleteSong(songId);
        }

        $('#songs').append("<h2 id='wait'> Ищем для вас песни... </h2>")

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
                        songs.append("<button value=" + obj['id'] + " onclick='getSim(this.value)'>Найти похожие</button>");
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

