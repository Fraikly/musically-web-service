<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchSongsRequest;
use App\Traits\Shazamable;
use GuzzleHttp\Exception\GuzzleException;

class SearchSongsController extends Controller
{
    use Shazamable;

    /**
     * Returns found songs
     *
     * @param SearchSongsRequest $request
     * @return array|mixed
     * @throws GuzzleException
     */
    public function search(SearchSongsRequest $request) {
        $tracks = [];

        if ($request->has('name')) {
            $songName = str_replace(' ', '%20', $request->safe()->name);
            $tracks = $this->getTracksFromShazam($songName);
        }

        return $tracks;
    }
}
