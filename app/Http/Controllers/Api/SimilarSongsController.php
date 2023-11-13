<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSimilarSongsRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class SimilarSongsController extends Controller
{
    public function __invoke(Request $request)
    {
        $id = $request->songId;
        $client = new Client();

        $response = $client->request('GET', "https://shazam.p.rapidapi.com/shazam-songs/list-similarities?id=track-similarities-id-{$id}&locale=en-US", [
            'headers' => [
                'X-RapidAPI-Host' => 'shazam.p.rapidapi.com',
                'X-RapidAPI-Key' => '6d41d0343bmshec7f87b015a5515p126b2bjsn78f70c853d7e',
            ],
        ]);

        $tracksInfo = json_decode($response->getBody()->getContents(), true)['resources']['shazam-songs'];
        $tracks = [];

        foreach ($tracksInfo as $trackInfo) {
            if (isset($trackInfo['attributes']['streaming']['preview'])) {
                $tracks[] = [
                    'id' => $trackInfo['id'],
                    'title' => $trackInfo['attributes']['title'],
                    'artist' => $trackInfo['attributes']['artist'],
                    'url' => $trackInfo['attributes']['streaming']['preview'],
                    'image' => $trackInfo['attributes']['images']['coverArt'],
                ];
            }
        }

       return view('songsSimilar', compact('tracks'));
    }

    /**
     * Show the application dashboard.
     *
     * @param GetSimilarSongsRequest $request
     * @return Renderable
     * @throws GuzzleException
     */
    public function index(GetSimilarSongsRequest $request)
    {
        $id = $request->safe()->songId;
        $client = new Client();

        $response = $client->request('GET', "https://shazam.p.rapidapi.com/shazam-songs/list-similarities?id=track-similarities-id-{$id}&locale=en-US", [
            'headers' => [
                'X-RapidAPI-Host' => 'shazam.p.rapidapi.com',
                'X-RapidAPI-Key' => '6d41d0343bmshec7f87b015a5515p126b2bjsn78f70c853d7e',
            ],
        ]);

        $tracksInfo = json_decode($response->getBody()->getContents(), true)['resources']['shazam-songs'];
        $tracks = [];

        foreach ($tracksInfo as $trackInfo) {
            if (isset($trackInfo['attributes']['streaming']['preview'])) {
                $tracks[] = [
                    'id' => $trackInfo['id'],
                    'title' => $trackInfo['attributes']['title'],
                    'artist' => $trackInfo['attributes']['artist'],
                    'url' => $trackInfo['attributes']['streaming']['preview'],
                    'image' => $trackInfo['attributes']['images']['coverArt'],
                ];
            }
        }

        return $tracks;
    }
}
