<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSimilarSongsRequest;
use App\Traits\Shazamable;
use GuzzleHttp\Exception\GuzzleException;

class SimilarSongsController extends Controller
{
    use Shazamable;

    /**
     * Returns similar songs.
     *
     * @param GetSimilarSongsRequest $request
     * @return array
     * @throws GuzzleException
     */
    public function index(GetSimilarSongsRequest $request)
    {
        $id = $request->safe()->songId;
        $tracks = $this->getSimilarTracksFromShazam($id);

        return $tracks;
    }
}
