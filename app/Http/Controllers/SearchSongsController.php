<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchSongsRequest;
use Exception;
use GuzzleHttp\Client;

class SearchSongsController extends Controller
{
    public function __invoke()
    {
        $tracks = [];
        return view('songsSearch', compact('tracks'));
    }

    public function search(SearchSongsRequest $request) {

        if ($request->has('name')) {
            $songName = str_replace(' ', '%20', $request->safe()->name);
            $client = new Client();

            $response = $client->request('GET', "https://shazam.p.rapidapi.com/search?term={$songName}&locale=ru&offset=0&limit=10", [
                'headers' => [
                    'X-RapidAPI-Host' => 'shazam.p.rapidapi.com',
                    'X-RapidAPI-Key' => '6d41d0343bmshec7f87b015a5515p126b2bjsn78f70c853d7e',
                ],
            ]);

            try {
                $tracks = json_decode($response->getBody()->getContents(), true)['tracks']['hits'];
            } catch (Exception $ex) {
                $tracks = [];
            }
        }

        return $tracks;
    }
}
