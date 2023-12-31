<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Traits\Shazamable;

class SearchSongsController extends Controller
{
    use Shazamable;

    /**
     * Show the songs list
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws GuzzleException
     */
    public function __invoke(Request $request)
    {
        $search = '';

        if ($request->name) {
            $search = $request->name;
            $songName = str_replace(' ', '%20', $search);
            $tracks = $this->getTracksFromShazam($songName);
        } else {
            $tracks = [];
        }

        return view('songsSearch', compact('tracks', 'search'));
    }
}
