<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSongsRequest;
use GuzzleHttp\Client;

class SearchSongsController extends Controller
{
    public function search (SearchSongsRequest  $request) {
        $songName = str_replace(' ', '%20', $request->safe()->name);
        $client = new Client();

        $response = $client->request('GET', "https://shazam.p.rapidapi.com/search?term={$songName}&locale=ru&offset=0&limit=10", [
            'headers' => [
                'X-RapidAPI-Host' => 'shazam.p.rapidapi.com',
                'X-RapidAPI-Key' => '6d41d0343bmshec7f87b015a5515p126b2bjsn78f70c853d7e',
            ],
        ]);

       $tracks = json_decode($response->getBody()->getContents(), true)['tracks']['hits'];
//dd($tracks[0]);
        return view('songsSearch', compact('tracks'));
    }
}
