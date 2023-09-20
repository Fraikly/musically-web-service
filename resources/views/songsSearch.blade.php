<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   @foreach($tracks as $track)
       <br>
       <img src="{{$track['track']['images']['coverart']}}">
       <p>{{$track['track']['title']}}</p>
       <p>{{$track['track']['subtitle']}}</p>
       <audio controls="controls">
           <source src="{{$track['track']['hub']['actions'][1]['uri']}}" type="audio/mp3" controls="false" />
           Your browser does not support the audio element.
       </audio>
   @endforeach
</html>

<script>
    const audioList = document.querySelectorAll('audio')
    let currentAudio

    Array.prototype.forEach.call(audioList, audio => {
        audio.addEventListener('play', e => {
            if (currentAudio) currentAudio.pause()
            currentAudio = e.target
        })
    })
</script>

