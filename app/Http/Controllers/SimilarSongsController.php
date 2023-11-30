<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Traits\Shazamable;

class SimilarSongsController extends Controller
{
    use Shazamable;

    /**
     * Show the similar songs list
     *
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws GuzzleException
     */
    public function __invoke(Request $request)
    {
        $id = $request->songId;
        $tracks = $this->getSimilarTracksFromShazam($id);

       return view('songsSimilar', compact('tracks'));
    }
}
