<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

trait Shazamable
{
    private array $headers = [
        'X-RapidAPI-Host' => 'shazam.p.rapidapi.com',
        'X-RapidAPI-Key' => '6d41d0343bmshec7f87b015a5515p126b2bjsn78f70c853d7e',
    ];

    /**
     * Returns found track from shazam
     *
     * @param string $songName
     * @return array|mixed
     * @throws GuzzleException
     */
    private function getTracksFromShazam(string $songName)
    {
        $client = new Client();

        $response = $client->request('GET', "https://shazam.p.rapidapi.com/search?term={$songName}&locale=ru&offset=0&limit=10", [
            'headers' => $this->headers,
        ]);

        try {
            $tracks = json_decode($response->getBody()->getContents(), true)['tracks']['hits'];
        } catch (Exception $ex) {
            $tracks = [];
        }

        return $tracks;
    }

    /**
     * Returns similar tracks from Shazam
     *
     * @param int $songId
     * @return array
     * @throws GuzzleException
     */
    private function getSimilarTracksFromShazam(int $songId)
    {

        $client = new Client();

        $response = $client->request('GET', "https://shazam.p.rapidapi.com/shazam-songs/list-similarities?id=track-similarities-id-{$songId}&locale=en-US", [
            'headers' => $this->headers,
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
